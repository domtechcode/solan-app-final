<?php

namespace App\Http\Livewire\Component;

use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;

class TrainingProgramDashboardIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];
 
    public $paginateTraining = 10;
    public $searchTraining = '';

    public $instructionSelectedId;
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

    protected $listeners = ['indexRender' => 'renderIndex'];

    public function renderIndex()
    {
        $this->render();
    }

    public function updatingSearchTraining()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->searchTraining = request()->query('search', $this->searchTraining);
    }

    public function render()
    {
        $dataTraining = WorkStep::where('work_step_list_id', 1)
                        ->whereIn('spk_status', ['Training Program'])
                        ->whereHas('instruction', function ($query) {
                            $searchTerms = '%' . $this->searchTraining . '%';
                            $query->where(function ($subQuery) use ($searchTerms) {
                                $subQuery->orWhere('spk_number', 'like', $searchTerms)
                                    ->orWhere('spk_type', 'like', $searchTerms)
                                    ->orWhere('customer_name', 'like', $searchTerms)
                                    ->orWhere('order_name', 'like', $searchTerms)
                                    ->orWhere('customer_number', 'like', $searchTerms)
                                    ->orWhere('code_style', 'like', $searchTerms)
                                    ->orWhere('shipping_date', 'like', $searchTerms);
                            });
                        })
                        ->join('instructions', 'work_steps.instruction_id', '=', 'instructions.id')
                        ->select('work_steps.*')
                        ->with(['status', 'job', 'workStepList', 'instruction'])
                        ->orderBy('instructions.shipping_date', 'asc')
                        ->paginate($this->paginateTraining);

        return view('livewire.component.training-program-dashboard-index', ['instructionsTraining' => $dataTraining])
        ->extends('layouts.app')
        ->layoutData(['title' => 'Dashboard']);
    }

    public function modalInstructionDetailsTraining($instructionId)
    {
        $this->selectedInstruction = Instruction::find($instructionId);
        $this->instructionSelectedId = $instructionId;
        $this->selectedWorkStep = WorkStep::where('instruction_id', $instructionId)->with('workStepList', 'user', 'machine')->get();
        $this->selectedFileContoh = Files::where('instruction_id', $instructionId)->where('type_file', 'contoh')->get();
        $this->selectedFileArsip = Files::where('instruction_id', $instructionId)->where('type_file', 'arsip')->get();
        $this->selectedFileAccounting = Files::where('instruction_id', $instructionId)->where('type_file', 'accounting')->get();
        $this->selectedFileLayout = Files::where('instruction_id', $instructionId)->where('type_file', 'layout')->get();
        $this->selectedFileSample = Files::where('instruction_id', $instructionId)->where('type_file', 'sample')->get();
    }

    public function modalInstructionDetailsGroupTraining($groupId)
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
    }
}
