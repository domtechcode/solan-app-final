<?php

namespace App\Http\Livewire\Component;

use ZipArchive;
use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Keterangan;
use App\Models\FileRincian;
use App\Models\Instruction;
use App\Models\LayoutBahan;
use App\Models\LayoutSetting;
use Livewire\WithFileUploads;

use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Html;

class DetailDataViewGeneralIndex extends Component
{
    use WithFileUploads;
    public $filerincian = [];
    public $layoutSettings = [];
    public $layoutBahans = [];
    public $keterangans = [];
    public $currentInstructionId;
    public $currentWorkStepId;
    public $instructionData;
    public $contohData;
    public $note;
    public $notereject;
    public $notes = [];
    public $workSteps;

    public $stateWorkStepPlate;
    public $stateWorkStepSablon;
    public $stateWorkStepPond;
    public $stateWorkStepCetakLabel;

    //modal
    public $selectedInstruction;
    public $selectedWorkStep;
    public $selectedFileContoh;
    public $selectedFileArsip;
    public $selectedFileAccounting;
    public $selectedFileLayout;
    public $selectedFileSample;

    public $selectedInstructionParent;
    public $selectedWorkStepParent;
    public $selectedFileContohParent;
    public $selectedFileArsipParent;
    public $selectedFileAccountingParent;
    public $selectedFileLayoutParent;
    public $selectedFileSampleParent;

    public $selectedInstructionChild;

    public $selectedGroupParent;
    public $selectedGroupChild;

    public $filePaths;
    public $htmlOutputs;

    public $totalPlate;
    public $totalLembarCetakPlate;
    public $totalWastePlate;

    public $totalScreen;
    public $totalLembarCetakScreen;
    public $totalWasteScreen;

    public function mount($instructionId, $workStepId)
    {
        $this->currentInstructionId = $instructionId;
        $this->currentWorkStepId = $workStepId;

        $cekGroup = Instruction::where('id', $instructionId)
            ->whereNotNull('group_id')
            ->whereNotNull('group_priority')
            ->first();

        if (!$cekGroup) {
            $this->instructionData = Instruction::where('id', $instructionId)
                ->with('fileArsip')
                ->get();
        } else {
            $instructionGroup = Instruction::where('group_id', $cekGroup->group_id)->get();
            $this->instructionData = Instruction::whereIn('id', $instructionGroup->pluck('id'))
                ->with('fileArsip')
                ->get();
        }

        $this->contohData = Files::where('instruction_id', $instructionId)
            ->where('type_file', 'contoh')
            ->get();

        $this->stateWorkStepPlate = WorkStep::where('instruction_id', $instructionId)
            ->where('work_step_list_id', 7)
            ->first();
        $this->stateWorkStepSablon = WorkStep::where('instruction_id', $instructionId)
            ->where('work_step_list_id', 23)
            ->first();
        $this->stateWorkStepPond = WorkStep::where('instruction_id', $instructionId)
            ->where('work_step_list_id', 24)
            ->first();
        $this->stateWorkStepCetakLabel = WorkStep::where('instruction_id', $instructionId)
            ->where('work_step_list_id', 12)
            ->first();
        $this->workSteps = WorkStep::where('instruction_id', $instructionId)
            ->with('workStepList')
            ->get();
    }

    public function render()
    {
        return view('livewire.component.detail-data-view-general-index')
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Form Edit Hitung Bahan']);
    }

    // public function downloadFileContoh()
    // {
    //     $dataInstruction = Instruction::find($this->currentInstructionId);

    //     // Nama file ZIP yang akan dibuat
    //     $zipFileName = 'file-contoh.zip';

    //     // Buat file ZIP baru
    //     $zip = new ZipArchive();
    //     $zip->open(storage_path('app/public/' . $zipFileName), ZipArchive::CREATE);

    //     // // Mendapatkan data file contoh dari $dataFileContoh
    //     // $dataFileContoh = Files::where('instruction_id', $this->currentInstructionId)
    //     //     ->where('type_file', 'contoh')
    //     //     ->get();

    //     // foreach ($dataFileContoh as $file) {
    //     //     // Menambahkan setiap file ke dalam file ZIP dengan nama file asli
    //     //     $zip->addFile(storage_path('app/' . $file->file_path), $file->file_name);
    //     // }

    //     $zip->close();

    //     // Mengirimkan file ZIP sebagai respons unduhan
    //     return response()->download(storage_path('app/public/' . $zipFileName))->deleteFileAfterSend();
    // }


    public function modalInstructionDetailsDetail($instructionId)
    {
        $this->selectedInstruction = Instruction::find($instructionId);
        $this->selectedWorkStep = WorkStep::where('instruction_id', $instructionId)
            ->with('workStepList', 'user', 'machine')
            ->get();
        $this->selectedFileContoh = Files::where('instruction_id', $instructionId)
            ->where('type_file', 'contoh')
            ->get();
        $this->selectedFileArsip = Files::where('instruction_id', $instructionId)
            ->where('type_file', 'arsip')
            ->get();
        $this->selectedFileAccounting = Files::where('instruction_id', $instructionId)
            ->where('type_file', 'accounting')
            ->get();
        $this->selectedFileLayout = Files::where('instruction_id', $instructionId)
            ->where('type_file', 'layout')
            ->get();
        $this->selectedFileSample = Files::where('instruction_id', $instructionId)
            ->where('type_file', 'sample')
            ->get();

        $this->dispatchBrowserEvent('show-detail-instruction-modal-detail');
    }

    public function modalInstructionDetailsGroupDetail($groupId)
    {
        $this->selectedGroupParent = Instruction::where('group_id', $groupId)
            ->where('group_priority', 'parent')
            ->first();
        $this->selectedGroupChild = Instruction::where('group_id', $groupId)
            ->where('group_priority', 'child')
            ->get();

        $this->selectedInstructionParent = Instruction::find($this->selectedGroupParent->id);
        $this->selectedWorkStepParent = WorkStep::where('instruction_id', $this->selectedGroupParent->id)
            ->with('workStepList', 'user', 'machine')
            ->get();
        $this->selectedFileContohParent = Files::where('instruction_id', $this->selectedGroupParent->id)
            ->where('type_file', 'contoh')
            ->get();
        $this->selectedFileArsipParent = Files::where('instruction_id', $this->selectedGroupParent->id)
            ->where('type_file', 'arsip')
            ->get();
        $this->selectedFileAccountingParent = Files::where('instruction_id', $this->selectedGroupParent->id)
            ->where('type_file', 'accounting')
            ->get();
        $this->selectedFileLayoutParent = Files::where('instruction_id', $this->selectedGroupParent->id)
            ->where('type_file', 'layout')
            ->get();
        $this->selectedFileSampleParent = Files::where('instruction_id', $this->selectedGroupParent->id)
            ->where('type_file', 'sample')
            ->get();

        $this->selectedInstructionChild = Instruction::where('group_id', $groupId)
            ->where('group_priority', 'child')
            ->with('workstep', 'workstep.workStepList', 'workstep.user', 'workstep.machine', 'fileArsip')
            ->get();

        $this->dispatchBrowserEvent('show-detail-instruction-modal-group-detail');
    }
}
