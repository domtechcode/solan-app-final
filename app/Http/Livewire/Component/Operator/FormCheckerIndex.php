<?php

namespace App\Http\Livewire\Component\Operator;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithFileUploads;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Storage;

class FormCheckerIndex extends Component
{
    use WithFileUploads;
    public $fileLayout = [];
    public $fileLayoutData = [];
    public $instructionCurrentId;
    public $workStepCurrentId;
    public $catatanProsesPengerjaan;
    public $catatanRevisi;

    public function mount($instructionId, $workStepId)
    {
        $this->instructionCurrentId = $instructionId;
        $this->workStepCurrentId = $workStepId;
        $dataFileLayout = Files::where('instruction_id', $this->instructionCurrentId)->where('type_file', 'layout')->get();
        foreach($dataFileLayout as $dataFile){
            $fileLayout = [
                'id' => $dataFile['id'],
                'file_name' => $dataFile['file_name'],
                'file_path' => $dataFile['file_path'],
                'type_file' => $dataFile['type_file'],
            ];

            $this->fileLayoutData[] = $fileLayout;
        }
    }

    public function render()
    {
        return view('livewire.component.operator.form-checker-index');
    }

    public function save()
    {
        $instructionData = Instruction::find($this->instructionCurrentId);

        if($this->catatanProsesPengerjaan){
            $dataCatatanProsesPengerjaan = WorkStep::find($this->workStepCurrentId);

            // Ambil alasan pause yang sudah ada dari database
            $existingCatatanProsesPengerjaan = json_decode($dataCatatanProsesPengerjaan->alasan_pause, true);

            // Tambahkan alasan pause yang baru ke dalam array existingCatatanProsesPengerjaan
            $timestampedKeterangan = $this->catatanProsesPengerjaan . ' - [' . now() . ']';
            $existingCatatanProsesPengerjaan[] = $timestampedKeterangan;

            // Simpan data ke database sebagai JSON
            $updateCatatanPengerjaan = WorkStep::where('id', $this->workStepCurrentId)->update([
                'catatan_proses_pengerjaan' => json_encode($existingCatatanProsesPengerjaan),
            ]);
        }

        $currentStep = WorkStep::find($this->workStepCurrentId);

        // Cek apakah $currentStep ada dan step berikutnya ada
        if ($currentStep) {
            $currentStep->update([
                'state_task' => 'Complete',
                'status_task' => 'Complete',
            ]);

            $nextStep = WorkStep::where('instruction_id', $this->instructionCurrentId)
                ->where('step', $currentStep->step + 1)
                ->first();

            // Cek apakah step berikutnya ada sebelum melanjutkan
            if ($nextStep) {
                $nextStep->update([
                    'state_task' => 'Running',
                    'status_task' => 'Pending Start',
                ]);

                $updateJobStatus = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                    'job_id' => $currentStep->work_step_list_id,
                    'status_id' => 1,
                ]);

                $userDestination = User::where('role', 'Penjadwalan')->get();
                foreach($userDestination as $dataUser){
                    $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Selesai Oleh Checker', 'instruction_id' => $this->instructionCurrentId]);
                }
                
                $this->messageSent(['receiver' => $nextStep->user_id, 'conversation' => 'SPK Baru', 'instruction_id' => $this->instructionCurrentId]);
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

                $userDestination = User::where('role', 'Penjadwalan')->get();
                foreach($userDestination as $dataUser){
                    $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Selesai Oleh Checker', 'instruction_id' => $this->instructionCurrentId]);
                }
                
                broadcast(new IndexRenderEvent('refresh'));
            }
        }

        

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Setting Instruksi Kerja',
            'message' => 'Data Setting berhasil disimpan',
        ]);

        return redirect()->route('operator.dashboard');
    }

    public function revisiSetting()
    {
        $this->validate([
            'catatanRevisi' => 'required',
        ]);

        $currentStep = WorkStep::find($this->workStepCurrentId);

        // Cek apakah $currentStep ada dan step berikutnya ada
        if ($currentStep) {
            $currentStep->update([
                'state_task' => 'Not Running',
                'status_task' => 'Waiting Revisi',
            ]);

            $lastStep = WorkStep::where('instruction_id', $this->instructionCurrentId)
                ->where('step', $currentStep->step - 1)
                ->first();

            // Cek apakah step berikutnya ada sebelum melanjutkan
            if ($lastStep) {
                $lastStep->update([
                    'state_task' => 'Running',
                    'status_task' => 'Pending Approved',
                    'count_revisi' => $lastStep->count_revisi + 1,
                ]);

                $updateJobStatus = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                    'job_id' => $lastStep->work_step_list_id,
                    'status_id' => 21,
                ]);
            }
        }

        $createCatatan = Catatan::create([
            'user_id' => Auth()->user()->id,
            'instruction_id' => $this->instructionCurrentId,
            'catatan' => $this->catatanRevisi,
            'tujuan' => $lastStep->work_step_list_id,
            'kategori' => 'revisi',
        ]);

        $this->messageSent(['conversation' => 'SPK di reject oleh '. $currentStep->user->name, 'instruction_id' => $this->instructionCurrentId, 'receiver' => $lastStep->user_id]);
        broadcast(new IndexRenderEvent('refresh'));

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Revisi Instruksi Kerja',
            'message' => 'Berhasil revisi instruksi kerja',
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
