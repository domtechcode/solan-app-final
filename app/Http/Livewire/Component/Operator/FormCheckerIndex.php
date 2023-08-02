<?php

namespace App\Http\Livewire\Component\Operator;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\FileSetting;
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
    public $fileFilmData = [];
    public $fileChecker = [];
    public $instructionCurrentId;
    public $workStepCurrentId;
    public $dataInstruction;
    public $catatanProsesPengerjaan;
    public $catatanRevisi;

    public function mount($instructionId, $workStepId)
    {
        $this->instructionCurrentId = $instructionId;
        $this->workStepCurrentId = $workStepId;
        $this->dataInstruction = Instruction::find($this->instructionCurrentId);
        $dataFileLayout = Files::where('instruction_id', $this->instructionCurrentId)->where('type_file', 'layout')->get();
        if(isset($dataFileLayout)){
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
        
        $dataFileFilm = FileSetting::where('instruction_id', $this->instructionCurrentId)->get();
        if(isset($dataFileFilm)){
            foreach($dataFileFilm as $dataFile){
                $fileFilm = [
                    'id' => $dataFile['id'],
                    'file_name' => $dataFile['file_name'],
                    'file_path' => $dataFile['file_path'],
                    'keperluan' => $dataFile['keperluan'],
                    'jumlah_film' => $dataFile['jumlah_film'],
                    'ukuran_film' => $dataFile['ukuran_film'],
                ];
    
                $this->fileFilmData[] = $fileFilm;
            }
        }
    }

    public function render()
    {
        return view('livewire.component.operator.form-checker-index');
    }

    public function saveLayout()
    {
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

    public function saveProductionAndSample()
    {
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
        $nextStep = WorkStep::where('instruction_id', $this->instructionCurrentId)
                ->where('step', $currentStep->step + 1)
                ->first();
        $lastStep = WorkStep::where('instruction_id', $this->instructionCurrentId)
                ->where('step', $currentStep->step - 1)
                ->first();
        
        if($lastStep->status_task == 'Waiting Repair Revisi'){
            // $this->validate([
            //     'fileChecker' => 'required',
            // ]);

            if(isset($this->fileChecker)){
                $deleteFileChecker = Files::where('instruction_id', $this->instructionCurrentId)->where('type_file', 'Approved Checker')->delete();
                $noApprovedChecker = Files::where('instruction_id', $this->instructionCurrentId)->where('type_file', 'Approved Checker')->count();
                foreach ($this->fileChecker as $file) {
                    $folder = "public/".$instructionData->spk_number."/checker";
        
                    $fileName = $instructionData->spk_number . '-file-approved-checker-'.$noApprovedChecker . '.' . $file->getClientOriginalExtension();
                    Storage::putFileAs($folder, $file, $fileName);
                    $noApprovedChecker ++;
        
                    $fileApprovedChecker= Files::create([
                        'instruction_id' => $this->instructionCurrentId,
                        'user_id' => Auth()->user()->id,
                        'type_file' => 'Approved Checker',
                        'file_path' => $folder,
                        'file_name' => $fileName,
                    ]);
                }
            }
        }else if($currentStep->status_task == 'Reject Requirements'){
            //reject requirement
        }else{
            // $this->validate([
            //     'fileChecker' => 'required',
            // ]);
            if(isset($this->fileChecker)){
                $deleteFileChecker = Files::where('instruction_id', $this->instructionCurrentId)->where('type_file', 'Approved Checker')->delete();
                $noApprovedChecker = Files::where('instruction_id', $this->instructionCurrentId)->where('type_file', 'Approved Checker')->count();
                foreach ($this->fileChecker as $file) {
                    $folder = "public/".$instructionData->spk_number."/checker";
        
                    $fileName = $instructionData->spk_number . '-file-approved-checker-'.$noApprovedChecker . '.' . $file->getClientOriginalExtension();
                    Storage::putFileAs($folder, $file, $fileName);
                    $noApprovedChecker ++;
        
                    $fileApprovedChecker= Files::create([
                        'instruction_id' => $this->instructionCurrentId,
                        'user_id' => Auth()->user()->id,
                        'type_file' => 'Approved Checker',
                        'file_path' => $folder,
                        'file_name' => $fileName,
                    ]);
                }
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
                        'state_task' => 'Running',
                        'status_task' => 'Pending Approved',
                    ]);

                    $updateJobStatus = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                        'job_id' => $nextStep->work_step_list_id,
                        'status_id' => 1,
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
                                    'state_task' => 'Running',
                                    'status_task' => 'Pending Approved',
                                ]);
    
                                $updateChildJobStatus = WorkStep::where('instruction_id', $item['instruction_id'])->update([
                                    'job_id' => $updateChildNextWorkStep->work_step_list_id,
                                    'status_id' => 1,
                                ]);
                            }
                        }
                    }

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

                    $userDestination = User::where('role', 'Penjadwalan')->get();
                    foreach($userDestination as $dataUser){
                        $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Selesai Oleh Checker', 'instruction_id' => $this->instructionCurrentId]);
                    }
                    
                    broadcast(new IndexRenderEvent('refresh'));
                }
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
                'status_task' => 'Waiting Repair Revisi',
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
