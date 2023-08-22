<?php

namespace App\Http\Livewire\Component;

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
use PhpOffice\PhpSpreadsheet\Writer\Html;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class HitungBahanDataViewPengirimanIndex extends Component
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
    public $noterevisi;
    public $notes = [];
    public $workSteps;
    public $fileCheckerData = [];

    public $stateWorkStepPlate;
    public $stateWorkStepSablon;
    public $stateWorkStepPond;
    public $stateWorkStepCetakLabel;
    public $stateWorkStepFoil;
    public $stateWorkStepEmbossDeboss;

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

        if (!$cekGroup){
            $this->instructionData = Instruction::where('id', $instructionId)->get();
        }else{
            $instructionGroup = Instruction::where('group_id', $cekGroup->group_id)->get();
            $this->instructionData = Instruction::whereIn('id', $instructionGroup->pluck('id'))->get();
        }

        $this->contohData = Files::where('instruction_id', $instructionId)->where('type_file', 'contoh')->get();

        $this->stateWorkStepPlate = WorkStep::where('instruction_id', $instructionId)->where('work_step_list_id', 7)->first();
        $this->stateWorkStepSablon = WorkStep::where('instruction_id', $instructionId)->where('work_step_list_id', 23)->first();
        $this->stateWorkStepPond = WorkStep::where('instruction_id', $instructionId)->where('work_step_list_id', 24)->first();
        $this->stateWorkStepCetakLabel = WorkStep::where('instruction_id', $instructionId)->where('work_step_list_id', 12)->first();
        $this->stateWorkStepFoil = WorkStep::where('instruction_id', $instructionId)->where('work_step_list_id', 28)->first();
        $this->stateWorkStepEmbossDeboss = WorkStep::where('instruction_id', $instructionId)->whereIn('work_step_list_id', [25, 26])->first();

        $this->workSteps = WorkStep::where('instruction_id', $instructionId)->with('workStepList')->get();

        $dataWorkStep = WorkStep::find($this->currentWorkStepId);

        $this->note = Catatan::where('instruction_id', $instructionId)->where('kategori', 'catatan')->where('tujuan', $dataWorkStep->work_step_list_id)->get();
        $this->notereject = Catatan::where('instruction_id', $instructionId)->where('kategori', 'reject')->where('tujuan', $dataWorkStep->work_step_list_id)->get();
        $this->noterevisi = Catatan::where('instruction_id', $instructionId)->where('kategori', 'revisi')->where('tujuan', $dataWorkStep->work_step_list_id)->get();

        $dataNotes = Catatan::where('instruction_id', $instructionId)->where('kategori', 'catatan')->where('tujuan', $dataWorkStep->work_step_list_id)->get();

        $this->notes = [];

        foreach($dataNotes as $note) {
            $this->notes[] = [
                "tujuan" => $note->tujuan,
                "catatan" => $note->catatan,
            ];
        }

        $this->fileCheckerData = Files::where('instruction_id', $instructionId)->where('type_file', 'Approved Checker')->get();
        
    }

    public function render()
    {
        return view('livewire.component.hitung-bahan-data-view-pengiriman-index')->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Form Edit Hitung Bahan']);
    }


    public function modalInstructionDetails($instructionId)
    {
        $this->selectedInstruction = Instruction::find($instructionId);
        $this->selectedWorkStep = WorkStep::where('instruction_id', $instructionId)->with('workStepList', 'user', 'machine')->get();
        $this->selectedFileContoh = Files::where('instruction_id', $instructionId)->where('type_file', 'contoh')->get();
        $this->selectedFileArsip = Files::where('instruction_id', $instructionId)->where('type_file', 'arsip')->get();
        $this->selectedFileAccounting = Files::where('instruction_id', $instructionId)->where('type_file', 'accounting')->get();
        $this->selectedFileLayout = Files::where('instruction_id', $instructionId)->where('type_file', 'layout')->get();
        $this->selectedFileSample = Files::where('instruction_id', $instructionId)->where('type_file', 'sample')->get();

        $this->dispatchBrowserEvent('show-detail-instruction-modal');
    }

    public function modalInstructionDetailsGroup($groupId)
    {
        $this->selectedGroupParent = Instruction::where('group_id', $groupId)->where('group_priority', 'parent')->first();
        $this->selectedGroupChild = Instruction::where('group_id', $groupId)->where('group_priority', 'child')->get();

        $this->selectedInstructionParent = Instruction::find($this->selectedGroupParent->id);
        $this->selectedWorkStepParent = WorkStep::where('instruction_id', $this->selectedGroupParent->id)->with('workStepList', 'user', 'machine')->get();
        $this->selectedFileContohParent = Files::where('instruction_id', $this->selectedGroupParent->id)->where('type_file', 'contoh')->get();
        $this->selectedFileArsipParent = Files::where('instruction_id', $this->selectedGroupParent->id)->where('type_file', 'arsip')->get();
        $this->selectedFileAccountingParent = Files::where('instruction_id', $this->selectedGroupParent->id)->where('type_file', 'accounting')->get();
        $this->selectedFileLayoutParent = Files::where('instruction_id', $this->selectedGroupParent->id)->where('type_file', 'layout')->get();
        $this->selectedFileSampleParent = Files::where('instruction_id', $this->selectedGroupParent->id)->where('type_file', 'sample')->get();

        $this->selectedInstructionChild = Instruction::where('group_id', $groupId)->where('group_priority', 'child')->with('workstep', 'workstep.workStepList', 'workstep.user', 'workstep.machine', 'fileArsip')->get();

        $this->dispatchBrowserEvent('show-detail-instruction-modal-group');
    }
    
}
