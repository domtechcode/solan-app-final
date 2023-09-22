<?php

namespace App\Http\Livewire\Component\Details;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\FormPond;
use App\Models\WorkStep;
use App\Models\FormPlate;
use App\Models\FileSetting;
use App\Models\Instruction;
use App\Models\RincianPlate;
use Livewire\WithFileUploads;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Storage;

class FormPondIndex extends Component
{
    use WithFileUploads;
    public $instructionCurrentId;
    public $workStepCurrentId;
    public $dataInstruction;
    public $dataWorkSteps;
    public $jenis_pekerjaan;
    public $hasil_akhir;
    public $nama_pisau;
    public $lokasi_pisau;
    public $status_pisau;
    public $nama_matress;
    public $lokasi_matress;
    public $status_matress;
    public $catatanProsesPengerjaan;
    public $dataHasilAkhir = [];

    public $notes = [];
    public $workSteps;

    public $workStepData;
    public $catatanData;

    public function addEmptyNote()
    {
        $this->notes[] = '';
    }

    public function removeNote($index)
    {
        unset($this->notes[$index]);
        $this->notes = array_values($this->notes);
    }

    public function mount($instructionId, $workStepId)
    {
        $this->instructionCurrentId = $instructionId;
        $this->workStepCurrentId = $workStepId;
        $this->dataInstruction = Instruction::find($this->instructionCurrentId);
        $dataWorkStep = WorkStep::find($workStepId);
        $this->dataWorkSteps = WorkStep::find($workStepId);

        $this->workStepData = WorkStep::find($workStepId);
        $this->catatanData = Catatan::where('instruction_id', $instructionId)
            ->where('user_id', $this->workStepData->user_id)
            ->where('kategori', 'catatan')
            ->get();

        $this->workSteps = WorkStep::where('instruction_id', $instructionId)
            ->with('workStepList')
            ->get();

        $dataPond = FormPond::where('instruction_id', $this->instructionCurrentId)
            ->where('jenis_pekerjaan', $dataWorkStep->workStepList->name)
            ->where('user_id', Auth()->user()->id)
            ->where('step', $dataWorkStep->step)
            ->first();

        if (isset($dataPond)) {
            $this->jenis_pekerjaan = $dataPond['jenis_pekerjaan'];
            $this->hasil_akhir = $dataPond['hasil_akhir'];
            $this->nama_pisau = $dataPond['nama_pisau'];
            $this->lokasi_pisau = $dataPond['lokasi_pisau'];
            $this->status_pisau = $dataPond['status_pisau'];
            $this->nama_matress = $dataPond['nama_matress'];
            $this->lokasi_matress = $dataPond['lokasi_matress'];
            $this->status_matress = $dataPond['status_matress'];

            $dataPond = FormPond::where('instruction_id', $this->instructionCurrentId)
            ->where('jenis_pekerjaan', $dataWorkStep->workStepList->name)
            ->where('user_id', Auth()->user()->id)
            ->where('step', $dataWorkStep->step)
            ->get();
            
            foreach ($dataPond as $dataHasilAkhirPond) {
                $rincianPlateDataHasilAkhir = [
                    'state' => $dataHasilAkhirPond['state'],
                    'plate' => $dataHasilAkhirPond['plate'],
                    'jumlah_lembar_cetak' => $dataHasilAkhirPond['jumlah_lembar_cetak'],
                    'waste' => $dataHasilAkhirPond['waste'],
                    'hasil_akhir_lembar_cetak_plate' => $dataHasilAkhirPond['hasil_akhir_lembar_cetak_plate'],
                ];
    
                $this->dataHasilAkhir[] = $rincianPlateDataHasilAkhir;
            }
        } else {
            $this->jenis_pekerjaan = $dataWorkStep->workStepList->name;
            $this->hasil_akhir = null;
            $this->nama_pisau = null;
            $this->lokasi_pisau = null;
            $this->status_pisau = null;
            $this->nama_matress = null;
            $this->lokasi_matress = null;
            $this->status_matress = null;

            $dataRincianPlateHasilAkhir = RincianPlate::where('instruction_id', $instructionId)->get();

            if (isset($dataRincianPlateHasilAkhir)) {
                $this->dataHasilAkhir = [];

                foreach ($dataRincianPlateHasilAkhir as $dataHasilAkhirPond) {
                    $rincianPlateDataHasilAkhir = [
                        'state' => $dataHasilAkhirPond->state,
                        'plate' => $dataHasilAkhirPond->plate,
                        'jumlah_lembar_cetak' => $dataHasilAkhirPond->jumlah_lembar_cetak,
                        'waste' => $dataHasilAkhirPond->waste,
                        'hasil_akhir_lembar_cetak_plate' => null,
                    ];

                    $this->dataHasilAkhir[] = $rincianPlateDataHasilAkhir;
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.component.details.form-pond-index');
    }

    public function save()
    {
        if ($this->dataWorkSteps->work_step_list_id == 24) {
            $this->validate([
                'hasil_akhir' => 'required',
                'nama_pisau' => 'required',
                'lokasi_pisau' => 'required',
                'status_pisau' => 'required',
                'nama_matress' => 'required',
                'lokasi_matress' => 'required',
                'status_matress' => 'required',
                'dataHasilAkhir.*.hasil_akhir_lembar_cetak_plate' => 'required',
            ]);
        } else {
            $this->validate([
                'hasil_akhir' => 'required',
                'nama_matress' => 'required',
                'lokasi_matress' => 'required',
                'status_matress' => 'required',
                'dataHasilAkhir.*.hasil_akhir_lembar_cetak_plate' => 'required',
            ]);
        }

        $instructionData = Instruction::find($this->instructionCurrentId);

        if ($this->catatanProsesPengerjaan) {
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

        if (isset($this->notes)) {
            $this->validate([
                'notes.*.tujuan' => 'required',
                'notes.*.catatan' => 'required',
            ]);

            foreach ($this->notes as $input) {
                $catatan = Catatan::create([
                    'tujuan' => $input['tujuan'],
                    'catatan' => $input['catatan'],
                    'kategori' => 'catatan',
                    'instruction_id' => $this->currentInstructionId,
                    'user_id' => Auth()->user()->id,
                ]);
            }
        }

        $currentStep = WorkStep::find($this->workStepCurrentId);
        $backtojadwal = WorkStep::where('instruction_id', $this->instructionCurrentId)
            ->where('work_step_list_id', 2)
            ->first();
        $nextStep = WorkStep::where('instruction_id', $this->instructionCurrentId)
            ->where('step', $currentStep->step + 1)
            ->first();

        if (isset($this->dataHasilAkhir)) {
            $deleteCetak = FormPond::where('instruction_id', $this->instructionCurrentId)
                ->where('jenis_pekerjaan', $currentStep->workStepList->name)
                ->where('user_id', Auth()->user()->id)
                ->where('step', $currentStep->step)
                ->delete();

            foreach ($this->dataHasilAkhir as $item) {
                $createCetak = FormPond::create([
                    'instruction_id' => $this->instructionCurrentId,
                    'user_id' => Auth()->user()->id,
                    'step' => $currentStep->step,
                    'state' => $item['state'],
                    'plate' => $item['plate'],
                    'jumlah_lembar_cetak' => $item['jumlah_lembar_cetak'],
                    'waste' => $item['waste'],
                    'hasil_akhir_lembar_cetak_plate' => $item['hasil_akhir_lembar_cetak_plate'],
                    'jenis_pekerjaan' => $this->jenis_pekerjaan,
                    'hasil_akhir' => $this->hasil_akhir,
                    'nama_pisau' => $this->nama_pisau,
                    'lokasi_pisau' => $this->lokasi_pisau,
                    'status_pisau' => $this->status_pisau,
                    'nama_matress' => $this->nama_matress,
                    'lokasi_matress' => $this->lokasi_matress,
                    'status_matress' => $this->status_matress,
                ]);
            }
        }

        if ($currentStep->status_task == 'Reject Requirements') {
            $currentStep->update([
                'state_task' => 'Complete',
                'status_task' => 'Complete',
            ]);

            $findSourceReject = WorkStep::find($currentStep->reject_from_id);

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
                'selesai' => Carbon::now()->toDateTimeString(),
            ]);

            $this->messageSent(['conversation' => 'SPK Perbaikan', 'instruction_id' => $this->instructionCurrentId, 'receiver' => $findSourceReject->user_id]);
            event(new IndexRenderEvent('refresh'));
        } else {
            if ($currentStep->flag == 'Split' || $currentStep->flag == 'Duet') {
                if ($currentStep) {
                    $currentStep->update([
                        'state_task' => 'Complete',
                        'status_task' => 'Complete',
                    ]);

                    // Cek apakah step berikutnya ada sebelum melanjutkan
                    if ($nextStep) {
                        //group
                        $dataInstruction = Instruction::find($this->instructionCurrentId);
                        if (isset($dataInstruction->group_id) && isset($dataInstruction->group_priority)) {
                            $datachild = Instruction::where('group_id', $dataInstruction->group_id)
                                ->where('group_priority', 'child')
                                ->get();

                            foreach ($datachild as $key => $item) {
                                $updateChildWorkStep = WorkStep::where('instruction_id', $item['instruction_id'])
                                    ->where('work_step_list_id', $currentStep->work_step_list_id)
                                    ->where('user_id', $currentStep->user_id)
                                    ->first();

                                if (isset($updateChildWorkStep)) {
                                    $updateChildWorkStep->update([
                                        'state_task' => 'Complete',
                                        'status_task' => 'Complete',
                                        'selesai' => Carbon::now()->toDateTimeString(),
                                    ]);
                                }
                            }
                        }

                        $userDestination = User::where('role', 'Penjadwalan')->get();
                        foreach ($userDestination as $dataUser) {
                            $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Selesai Oleh ' . $currentStep->workStepList->name, 'instruction_id' => $this->instructionCurrentId]);
                        }
                        event(new IndexRenderEvent('refresh'));
                    } else {
                        $updateSelesai = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                            'spk_status' => 'Selesai',
                            'state_task' => 'Complete',
                            'status_task' => 'Complete',
                            'selesai' => Carbon::now()->toDateTimeString(),
                        ]);

                        $updateJobStatus = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                            'job_id' => $currentStep->work_step_list_id,
                            'status_id' => 7,
                        ]);

                        //group
                        $dataInstruction = Instruction::find($this->instructionCurrentId);
                        if (isset($dataInstruction->group_id) && isset($dataInstruction->group_priority)) {
                            $datachild = Instruction::where('group_id', $dataInstruction->group_id)
                                ->where('group_priority', 'child')
                                ->get();

                            foreach ($datachild as $key => $item) {
                                $updateChildWorkStep = WorkStep::where('instruction_id', $item['instruction_id'])
                                    ->where('work_step_list_id', $currentStep->work_step_list_id)
                                    ->where('user_id', $currentStep->user_id)
                                    ->first();

                                if (isset($updateChildWorkStep)) {
                                    $updateChildWorkStep->update([
                                        'state_task' => 'Complete',
                                        'status_task' => 'Complete',
                                    ]);

                                    $updateChildJobStatus = WorkStep::where('instruction_id', $item['instruction_id'])->update([
                                        'spk_status' => 'Selesai',
                                        'state_task' => 'Complete',
                                        'status_task' => 'Complete',
                                        'job_id' => $currentStep->work_step_list_id,
                                        'status_id' => 7,
                                    ]);
                                }
                            }
                        }
                    }
                }
            } else {
                if ($currentStep) {
                    $currentStep->update([
                        'state_task' => 'Complete',
                        'status_task' => 'Complete',
                        'selesai' => Carbon::now()->toDateTimeString(),
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

                        //group
                        $dataInstruction = Instruction::find($this->instructionCurrentId);
                        if (isset($dataInstruction->group_id) && isset($dataInstruction->group_priority)) {
                            $datachild = Instruction::where('group_id', $dataInstruction->group_id)
                                ->where('group_priority', 'child')
                                ->get();

                            foreach ($datachild as $key => $item) {
                                $updateChildWorkStep = WorkStep::where('instruction_id', $item['instruction_id'])
                                    ->where('work_step_list_id', $currentStep->work_step_list_id)
                                    ->where('user_id', $currentStep->user_id)
                                    ->first();

                                if (isset($updateChildWorkStep)) {
                                    $updateChildWorkStep->update([
                                        'state_task' => 'Complete',
                                        'status_task' => 'Complete',
                                        'selesai' => Carbon::now()->toDateTimeString(),
                                    ]);

                                    $updateChildNextWorkStep = WorkStep::where('instruction_id', $item['instruction_id'])
                                        ->where('step', $updateChildWorkStep->step + 1)
                                        ->first();

                                    $updateChildNextWorkStep->update([
                                        'state_task' => 'Not Running',
                                        'status_task' => 'Pending Start',
                                    ]);

                                    $updateChildJobStatus = WorkStep::where('instruction_id', $item['instruction_id'])->update([
                                        'job_id' => $updateChildNextWorkStep->work_step_list_id,
                                        'status_id' => 7,
                                    ]);
                                }
                            }
                        }

                        $userDestination = User::where('role', 'Penjadwalan')->get();
                        foreach ($userDestination as $dataUser) {
                            $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Selesai Oleh ' . $currentStep->workStepList->name, 'instruction_id' => $this->instructionCurrentId]);
                        }
                        event(new IndexRenderEvent('refresh'));
                    } else {
                        $updateSelesai = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                            'spk_status' => 'Selesai',
                            'state_task' => 'Complete',
                            'status_task' => 'Complete',
                            'selesai' => Carbon::now()->toDateTimeString(),
                        ]);

                        $updateJobStatus = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                            'job_id' => $currentStep->work_step_list_id,
                            'status_id' => 7,
                        ]);

                        //group
                        $dataInstruction = Instruction::find($this->instructionCurrentId);
                        if (isset($dataInstruction->group_id) && isset($dataInstruction->group_priority)) {
                            $datachild = Instruction::where('group_id', $dataInstruction->group_id)
                                ->where('group_priority', 'child')
                                ->get();

                            foreach ($datachild as $key => $item) {
                                $updateChildWorkStep = WorkStep::where('instruction_id', $item['instruction_id'])
                                    ->where('work_step_list_id', $currentStep->work_step_list_id)
                                    ->where('user_id', $currentStep->user_id)
                                    ->first();

                                if (isset($updateChildWorkStep)) {
                                    $updateChildWorkStep->update([
                                        'state_task' => 'Complete',
                                        'status_task' => 'Complete',
                                    ]);

                                    $updateChildJobStatus = WorkStep::where('instruction_id', $item['instruction_id'])->update([
                                        'spk_status' => 'Selesai',
                                        'state_task' => 'Complete',
                                        'status_task' => 'Complete',
                                        'job_id' => $currentStep->work_step_list_id,
                                        'status_id' => 7,
                                    ]);
                                }
                            }
                        }
                    }
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
        $createdMessage = 'info';
        $selectedConversation = $arguments['conversation'];
        $receiverUser = $arguments['receiver'];
        $instruction_id = $arguments['instruction_id'];

        event(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, $receiverUser));
    }
}