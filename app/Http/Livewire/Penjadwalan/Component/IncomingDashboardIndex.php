<?php

namespace App\Http\Livewire\Penjadwalan\Component;

use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;

class IncomingDashboardIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];
 
    public $paginate = 10;
    public $search = '';
    public $data;

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

    protected $listeners = ['notifSent' => 'refreshIndex', 'indexRender' => 'renderIndex'];

    public function refreshIndex()
    {
        $this->render();
    }

    public function renderIndex()
    {
        $this->render();
    }

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }

    public function render()
    {
        $data = WorkStep::where('work_step_list_id', 2)
                        ->where('state_task', 'Not Running')
                        ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC'])
                        ->whereHas('instruction', function ($query) {
                            $searchTerms = '%' . $this->search . '%';
                            $query->where(function ($subQuery) use ($searchTerms) {
                                $subQuery->orWhere('spk_number', 'like', $searchTerms)
                                    ->orWhere('spk_type', 'like', $searchTerms)
                                    ->orWhere('customer_name', 'like', $searchTerms)
                                    ->orWhere('order_name', 'like', $searchTerms)
                                    ->orWhere('customer_number', 'like', $searchTerms)
                                    ->orWhere('code_style', 'like', $searchTerms)
                                    ->orWhere('shipping_date', 'like', $searchTerms);
                            })->where(function ($subQuery) {
                                $subQuery->where('group_priority', '!=', 'child')
                                    ->orWhereNull('group_priority');
                            })->orderBy('shipping_date', 'asc');
                        })
                        ->with(['status', 'job', 'workStepList', 'instruction'])
                        ->paginate($this->paginate);

        return view('livewire.penjadwalan.component.incoming-dashboard-index', ['instructions' => $data])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Dashboard']);
    }

    public function modalInstructionDetailsIncoming($instructionId)
    {
        $this->selectedInstruction = Instruction::find($instructionId);
        $this->selectedWorkStep = WorkStep::where('instruction_id', $instructionId)->with('workStepList', 'user', 'machine')->get();
        $this->selectedFileContoh = Files::where('instruction_id', $instructionId)->where('type_file', 'contoh')->get();
        $this->selectedFileArsip = Files::where('instruction_id', $instructionId)->where('type_file', 'arsip')->get();
        $this->selectedFileAccounting = Files::where('instruction_id', $instructionId)->where('type_file', 'accounting')->get();
        $this->selectedFileLayout = Files::where('instruction_id', $instructionId)->where('type_file', 'layout')->get();
        $this->selectedFileSample = Files::where('instruction_id', $instructionId)->where('type_file', 'sample')->get();

        $this->dispatchBrowserEvent('show-detail-instruction-modal-incoming');
    }

    public function modalInstructionDetailsGroupIncoming($groupId)
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

        $this->dispatchBrowserEvent('show-detail-instruction-modal-group-incoming');
    }
}
