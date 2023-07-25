<?php

namespace App\Http\Livewire\Component\Operator;

use Carbon\Carbon;
use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class FormSettingIndex extends Component
{
    use WithFileUploads;
    public $fileLayout = [];
    public $fileLayoutData = [];
    public $instructionCurrentId;
    public $workStepCurrentId;
    public $catatanProsesPengerjaan;

    public function mount($instructionId, $workStepId)
    {
        // $updateFollowUp = WorkStep::where('work_step_list_id', 1)->update([
        //     'state_task' => 'Running',
        //     'status_task' => 'Process',
        // ]);

        // $updateFollowUp = Instruction::where('group_priority', 1)->update([
        //     'group_priority' => 'parent',
        // ]);

        // $updateFollowUp = Instruction::where('group_priority', 3)->update([
        //     'group_priority' => 'child',
        // ]);

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
        return view('livewire.component.operator.form-setting-index');
    }

    public function save()
    {
        $this->validate([
            'fileLayout' => 'required',
        ]);

        $instructionData = Instruction::find($this->instructionCurrentId);
        $fileLayoutData = Files::where('instruction_id', $this->instructionCurrentId)->where('type_file', 'layout')->count();
        
        $folder = "public/".$instructionData->spk_number."/setting";

        $nolayout = $fileLayoutData;
        foreach ($this->fileLayout as $file) {
            $fileName = Carbon::now()->format('Ymd') . '-' . $instructionData->spk_number . '-file-layout-'.$nolayout . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs($folder, $file, $fileName);
            $nolayout ++;

            Files::create([
                'instruction_id' => $this->instructionCurrentId,
                "user_id" => Auth()->user()->id,
                "type_file" => "layout",
                "file_name" => $fileName,
                "file_path" => $folder,
            ]);
        }


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
                    'status_task' => 'Pending Approved',
                ]);

                $updateJobStatus = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                    'job_id' => $nextStep->work_step_list_id,
                    'status_id' => 1,
                ]);
            }
        }

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Setting Instruksi Kerja',
            'message' => 'Data Setting berhasil disimpan',
        ]);

        return redirect()->route('operator.dashboard');
    }
}
