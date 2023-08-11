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
use Livewire\WithFileUploads;
use App\Models\FormCetakLabel;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Storage;

class FormCetakLabelIndex extends Component
{
    use WithFileUploads;
    public $instructionCurrentId;
    public $workStepCurrentId;
    public $dataInstruction;
    public $hasil_akhir;
    public $catatanProsesPengerjaan;

    public function mount($instructionId, $workStepId)
    {
        $this->instructionCurrentId = $instructionId;
        $this->workStepCurrentId = $workStepId;
        $this->dataInstruction = Instruction::find($this->instructionCurrentId);
        $dataCetakLabel = FormCetakLabel::where('instruction_id', $this->instructionCurrentId)->first();
        if(isset($dataCetakLabel)){
            $this->hasil_akhir = $dataCetakLabel['hasil_akhir'];
        }else{
            $this->hasil_akhir = '';
        }
    }

    public function render()
    {
        return view('livewire.component.operator.form-cetak-label-index');
    }

    public function save()
    {
        $this->validate([
            'hasil_akhir' => 'required',
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
        
        $deleteFormCetakLabel = FormCetakLabel::where('instruction_id', $this->instructionCurrentId)->delete();
        $createFormCetakLabel = FormCetakLabel::create([
            'instruction_id' => $this->instructionCurrentId,
            'hasil_akhir' => $this->hasil_akhir,
        ]);

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
        $createdMessage = "info";
        $selectedConversation = $arguments['conversation'];
        $receiverUser = $arguments['receiver'];
        $instruction_id = $arguments['instruction_id'];

        event(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, $receiverUser));
    }
}
