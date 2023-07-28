<?php

namespace App\Http\Livewire\Component\Operator;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\FormCetak;
use App\Models\FormPlate;
use App\Models\WarnaPlate;
use App\Models\FileSetting;
use App\Models\Instruction;
use App\Models\RincianPlate;
use Livewire\WithFileUploads;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Storage;

class FormCetakIndex extends Component
{
    use WithFileUploads;
    public $instructionCurrentId;
    public $workStepCurrentId;
    public $dataInstruction;
    public $hasil_akhir_lembar_cetak;
    public $catatanProsesPengerjaan;
    public $de;
    public $l;
    public $a;
    public $b;
    public $dataWarna = [];

    public function mount($instructionId, $workStepId)
    {
        $this->instructionCurrentId = $instructionId;
        $this->workStepCurrentId = $workStepId;
        $this->dataInstruction = Instruction::find($this->instructionCurrentId);

        $dataRincianPlate = RincianPlate::where('instruction_id', $instructionId)->where(function ($query) {
            $query->where('status', '!=', 'Deleted by Setting')
                ->orWhereNull('status');
        })->first();

        if(isset($dataRincianPlate)){
            $this->de = $dataRincianPlate['de'];
            $this->l = $dataRincianPlate['l'];
            $this->a = $dataRincianPlate['a'];
            $this->b = $dataRincianPlate['b'];
        }else{
            $this->de = '';
            $this->l = '';
            $this->a = '';
            $this->b = '';
        }

        $dataWarnaPlate = RincianPlate::where('instruction_id', $instructionId)
            ->where(function ($query) {
                $query->where('status', '!=', 'Deleted by Setting')
                    ->orWhereNull('status');
            })
            ->with('warnaPlate')
            ->get();

        if (isset($dataWarnaPlate)) {
            $this->dataWarna = [];

            foreach ($dataWarnaPlate as $dataPlate) {
                $rincianPlateData = [
                    "id" => $dataPlate->id,
                    "plate" => $dataPlate->plate,
                    "name" => $dataPlate->name,
                    "warnaCetak" => [],
                ];

                if ($dataPlate->warnaPlate->isNotEmpty()) {
                    foreach ($dataPlate->warnaPlate as $warnaPlate) {
                        $rincianPlateData['warnaCetak'][] = [
                            "id" => $warnaPlate->id,
                            "warna" => $warnaPlate->warna,
                            "keterangan" => $warnaPlate->keterangan,
                            "de" => $warnaPlate->de,
                            "l" => $warnaPlate->l,
                            "a" => $warnaPlate->a,
                            "b" => $warnaPlate->b,
                        ];
                    }
                }

                $this->dataWarna['rincianPlate'][] = $rincianPlateData;
            }
        }
        
        $dataFormCetak = FormCetak::where('instruction_id', $instructionId)->first();
        if (isset($dataFormCetak)){
            $this->hasil_akhir_lembar_cetak = $dataFormCetak['hasil_akhir_lembar_cetak'];
        }
    }

    public function render()
    {
        return view('livewire.component.operator.form-cetak-index');
    }

    public function save()
    {
        $this->validate([
            'hasil_akhir_lembar_cetak' => 'required',
        ]);

        $instructionData = Instruction::find($this->instructionCurrentId);

        if($this->catatanProsesPengerjaan){
            $dataCatatanProsesPengerjaan = WorkStep::find($this->workStepCurrentId);

            // Ambil alasan pause yang sudah ada dari database
            $existingCatatanProsesPengerjaan = json_decode($dataCatatanProsesPengerjaan->catatan_proses_pengerjaan, true);

            // Tambahkan alasan pause yang baru ke dalam array existingCatatanProsesPengerjaan
            $timestampedKeterangan = $this->catatanProsesPengerjaan . ' - [' . now() . ']';
            $existingCatatanProsesPengerjaan[] = $timestampedKeterangan;

            // Simpan data ke database sebagai JSON
            $updateCatatanPengerjaan = WorkStep::where('id', $this->workStepCurrentId)->update([
                'catatan_proses_pengerjaan' => json_encode($existingCatatanProsesPengerjaan),
            ]);
        }

        if(isset($this->hasil_akhir_lembar_cetak)){
            $deleteCetak = FormCetak::where('instruction_id', $this->instructionCurrentId)->delete();
            $createCetak = FormCetak::create([
                'instruction_id' => $this->instructionCurrentId,
                'hasil_akhir_lembar_cetak' => $this->hasil_akhir_lembar_cetak,
            ]);
        }

        if (isset($this->dataWarna['rincianPlate'])) {
            foreach ($this->dataWarna['rincianPlate'] as $rincianPlate) {
                // Now, update the related WarnaPlate models
                if (isset($rincianPlate['warnaCetak'])) {
                    foreach ($rincianPlate['warnaCetak'] as $warnaCetak) {
                        $warnaPlateModel = WarnaPlate::find($warnaCetak['id']);

                        if ($warnaPlateModel) {
                            $warnaPlateModel->warna = $warnaCetak['warna'];
                            $warnaPlateModel->keterangan = $warnaCetak['keterangan'];
                            $warnaPlateModel->de = $warnaCetak['de'];
                            $warnaPlateModel->l = $warnaCetak['l'];
                            $warnaPlateModel->a = $warnaCetak['a'];
                            $warnaPlateModel->b = $warnaCetak['b'];
                            $warnaPlateModel->save();
                        }
                    }
                }
            }
        }

        if (isset($this->de) && isset($this->l) && isset($this->a) && isset($this->b)){
            $update = RincianPlate::where('instruction_id', $this->instructionCurrentId)->where(function ($query) {
                $query->where('status', '!=', 'Deleted by Setting')
                    ->orWhereNull('status');
            })->update([
                'de' => $this->de,
                'l' => $this->l,
                'a' => $this->a,
                'b' => $this->b,
                'status' => 'Pengembalian Plate',
            ]);
        }

        $currentStep = WorkStep::find($this->workStepCurrentId);
        $backtojadwal = WorkStep::where('instruction_id', $this->instructionCurrentId)
                ->where('work_step_list_id', 2)
                ->first();
        $nextStep = WorkStep::where('instruction_id', $this->instructionCurrentId)
                ->where('step', $currentStep->step + 1)
                ->first();

        if($currentStep->status_task == 'Reject Requirements'){
            $currentStep->update([
                'state_task' => 'Complete',
                'status_task' => 'Complete',
            ]);

            $findSourceReject = WorkStep::where('instruction_id', $this->instructionCurrentId)->where('work_step_list_id', $currentStep->reject_from_id)->first();

            $findSourceReject->update([
                'state_task' => 'Running',
                'status_task' => 'Pending Approved',
            ]);

            $updateJobStatus = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                'status_id' => 1,
                'job_id' => $findSourceReject->work_step_list_id,
            ]);

            $currentStep->update([
                'reject_from_id' => null,
                'reject_from_status' => null,
                'reject_from_job' => null,
                'selesai' => Carbon::now()->toDateTimeString()
            ]);

            $this->messageSent(['conversation' => 'SPK Perbaikan', 'instruction_id' => $this->instructionCurrentId, 'receiver' => $findSourceReject->user_id]);
            broadcast(new IndexRenderEvent('refresh'));
        }else{
            // Cek apakah $currentStep ada dan step berikutnya ada
            if ($currentStep) {
                $currentStep->update([
                    'state_task' => 'Complete',
                    'status_task' => 'Complete',
                ]);

                // Cek apakah step berikutnya ada sebelum melanjutkan
                if ($nextStep) {
                    $nextStep->update([
                        'state_task' => 'Not Running',
                        'status_task' => 'Pending Start',
                    ]);

                    $updateJobStatus = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                        'job_id' => $currentStep->work_step_list_id,
                        'status_id' => 7,
                    ]);

                    $userDestination = User::where('role', 'Penjadwalan')->get();
                    foreach($userDestination as $dataUser){
                        $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Selesai Oleh '. $currentStep->workStepList->name, 'instruction_id' => $this->instructionCurrentId]);
                    }
                    broadcast(new IndexRenderEvent('refresh'));

                }
            }
        }
        
        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Plate Instruksi Kerja',
            'message' => 'Data Plate berhasil disimpan',
        ]);

        return redirect()->route('operator.dashboard');
    }

    public function messageSent($arguments)
    {
        $createdMessage = "info";
        $selectedConversation = $arguments['conversation'];
        $receiverUser = $arguments['receiver'];
        $instruction_id = $arguments['instruction_id'];

        broadcast(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, $receiverUser));
    }
}
