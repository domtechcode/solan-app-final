<?php

namespace App\Http\Livewire\Component\Operator;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\FormFoil;
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

class FormFoilIndex extends Component
{
    use WithFileUploads;
    public $instructionCurrentId;
    public $workStepCurrentId;
    public $dataInstruction;
    public $hasil_akhir;
    public $nama_matress;
    public $lokasi_matress;
    public $status_matress;
    public $catatanProsesPengerjaan;

    public function mount($instructionId, $workStepId)
    {
        $this->instructionCurrentId = $instructionId;
        $this->workStepCurrentId = $workStepId;
        $this->dataInstruction = Instruction::find($this->instructionCurrentId);
        $dataFoil = FormFoil::where('instruction_id', $this->instructionCurrentId)->first();
        if(isset($dataFoil)){
            $this->hasil_akhir = $dataFoil['hasil_akhir'];
            $this->nama_matress = $dataFoil['nama_matress'];
            $this->lokasi_matress = $dataFoil['lokasi_matress'];
            $this->status_matress = $dataFoil['status_matress'];
        }else{
            $this->hasil_akhir = '';
            $this->nama_matress = '';
            $this->lokasi_matress = '';
            $this->status_matress = '';
        }
    }

    public function render()
    {
        return view('livewire.component.operator.form-foil-index');
    }

    public function save()
    {
        $this->validate([
            'hasil_akhir' => 'required',
            'nama_matress' => 'required',
            'lokasi_matress' => 'required',
            'status_matress' => 'required',
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
        
        $deleteFormFoil = FormFoil::where('instruction_id', $this->instructionCurrentId)->delete();
        $createFormFoil = FormFoil::create([
            'instruction_id' => $this->instructionCurrentId,
            'hasil_akhir' => $this->hasil_akhir,
            'nama_matress' => $this->nama_matress,
            'lokasi_matress' => $this->lokasi_matress,
            'status_matress' => $this->status_matress,
        ]);

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

                    //group
                    $dataInstruction = Instruction::find($this->instructionCurrentId);
                    if(isset($dataInstruction->group_id) && isset($dataInstruction->group_priority)){
                        $datachild = Instruction::where('group_id', $dataInstruction->group_id)->where('group_priority', 'child')->get();

                        foreach($datachild as $key => $item){
                            $updateChildWorkStep = WorkStep::where('instruction_id', $item['instruction_id'])->where('work_step_list_id', $currentStep->work_step_list_id)->where('user_id', $currentStep->user_id)->first();

                            if(isset($updateChildWorkStep)){
                                $updateChildWorkStep->update([
                                    'state_task' => 'Complete',
                                    'status_task' => 'Complete',
                                ]);
    
                                $updateChildNextWorkStep = WorkStep::where('instruction_id', $item['instruction_id'])->where('step', $updateChildWorkStep->step + 1)->first();
    
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

                    //group
                    $dataInstruction = Instruction::find($this->instructionCurrentId);
                    if(isset($dataInstruction->group_id) && isset($dataInstruction->group_priority)){
                        $datachild = Instruction::where('group_id', $dataInstruction->group_id)->where('group_priority', 'child')->get();

                        foreach($datachild as $key => $item){
                            $updateChildWorkStep = WorkStep::where('instruction_id', $item['instruction_id'])->where('work_step_list_id', $currentStep->work_step_list_id)->where('user_id', $currentStep->user_id)->first();

                            if(isset($updateChildWorkStep)){
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
