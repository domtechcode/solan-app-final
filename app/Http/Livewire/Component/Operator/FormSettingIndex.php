<?php

namespace App\Http\Livewire\Component\Operator;

use Carbon\Carbon;
use App\Models\Files;
use Livewire\Component;
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
            
        }
    }
}
