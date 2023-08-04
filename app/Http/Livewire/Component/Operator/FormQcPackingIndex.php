<?php

namespace App\Http\Livewire\Component\Operator;

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
use App\Models\FormQcPacking;
use Livewire\WithFileUploads;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Storage;

class FormQcPackingIndex extends Component
{
    use WithFileUploads;
    public $instructionCurrentId;
    public $workStepCurrentId;
    public $dataInstruction;
    public $dataWorkSteps;
    public $hasil_akhir;
    public $jumlah_barang_gagal;
    public $jumlah_stock;
    public $lokasi_stock;
    public $catatanProsesPengerjaan;
    public $dataAnggota;
    public $anggota = [];


    public function addAnggota()
    {
        $this->anggota[] = ['nama' => '', 'hasil' => ''];
    }

    public function removeAnggota($index)
    {
        unset($this->anggota[$index]);
        $this->anggota = array_values($this->anggota);
    }

    public function mount($instructionId, $workStepId)
    {
        $this->instructionCurrentId = $instructionId;
        $this->workStepCurrentId = $workStepId;
        $this->dataInstruction = Instruction::find($this->instructionCurrentId);
        $dataWorkStep = WorkStep::find($workStepId);
        $this->dataWorkSteps = WorkStep::find($workStepId);
        $this->dataAnggota = User::where('jobdesk', 'Team Qc Packing')->get();
        $dataQcPacking = FormQcPacking::where('instruction_id', $this->instructionCurrentId)->first();
        if(isset($dataQcPacking)){
            $this->hasil_akhir = $dataQcPacking['hasil_akhir'];
            $this->jumlah_barang_gagal = $dataQcPacking['jumlah_barang_gagal'];
            $this->jumlah_stock = $dataQcPacking['jumlah_stock'];
            $this->lokasi_stock = $dataQcPacking['lokasi_stock'];
        }else{
            $this->hasil_akhir = '';
            $this->jumlah_barang_gagal = '';
            $this->jumlah_stock = '';
            $this->lokasi_stock = '';
        }
        
        $dataAnggotaCurrent = FormQcPacking::where('instruction_id', $this->instructionCurrentId)->get();
        if(isset($dataAnggotaCurrent)){
            foreach($dataAnggotaCurrent as $item){
                $anggota = [
                    'nama' => $item['nama_anggota'],
                    'hasil' => $item['hasil_per_anggota'],
                ];

                $this->anggota[] = $anggota;
            }
        }

        if(empty($this->anggota)){
            $this->anggota[] = [
                'nama' => '',
                'hasil' => '',
            ];
        }
    
    }

    public function render()
    {
        return view('livewire.component.operator.form-qc-packing-index');
    }

    public function save()
    {
        $this->validate([
            'hasil_akhir' => 'required',
            'jumlah_barang_gagal' => 'required',
            'jumlah_stock' => 'required',
            'lokasi_stock' => 'required',
            'anggota.*.nama' => 'required',
            'anggota.*.hasil' => 'required',
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

        $currentStep = WorkStep::find($this->workStepCurrentId);
        $backtojadwal = WorkStep::where('instruction_id', $this->instructionCurrentId)
                ->where('work_step_list_id', 2)
                ->first();
        $nextStep = WorkStep::where('instruction_id', $this->instructionCurrentId)
                ->where('step', $currentStep->step + 1)
                ->first();
        
        if(isset($this->anggota)){
            $deleteFormQcPacking = FormQcPacking::where('instruction_id', $this->instructionCurrentId)->delete();
            foreach($this->anggota as $dataAnggota){
                $createFormQcPacking = FormQcPacking::create([
                    'instruction_id' => $this->instructionCurrentId,
                    'hasil_akhir' => $this->hasil_akhir,
                    'jumlah_barang_gagal' => $this->jumlah_barang_gagal,
                    'jumlah_stock' => $this->jumlah_stock,
                    'lokasi_stock' => $this->lokasi_stock,
                    'nama_anggota' => $dataAnggota['nama'],
                    'hasil_per_anggota' => $dataAnggota['hasil'],
                ]);
            }
        }

        if($currentStep->status_task == 'Reject Requirements'){
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

                }else{
                    $updateSelesai = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                        'spk_status' => 'Selesai',
                        'state_task' => 'Complete',
                        'status_task' => 'Complete',
                    ]);

                    $updateJobStatus = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                        'job_id' => $currentStep->work_step_list_id,
                        'status_id' => 7,
                    ]);
                }
            }

            $searchWaitingSpkQc = Instruction::where('waiting_spk_qc', $instructionData->spk_number)->first();

            if(isset($searchWaitingSpkQc)){
                $updateSpkHold = WorkStep::where('instruction_id', $searchWaitingSpkQc->id)->update([
                    'spk_status' => 'Running',
                ]);
            }else{
                $updateSpkHold = WorkStep::where('instruction_id', $searchWaitingSpkQc->id)->update([
                    'spk_status' => 'Failed Waiting Qty QC',
                ]);
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
