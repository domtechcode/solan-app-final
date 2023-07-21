<?php

namespace App\Http\Livewire\Penjadwalan\Component;

use App\Models\User;
use App\Models\Files;
use App\Models\Machine;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;

class NewSpkDashboardIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];
 
    public $paginate = 10;
    public $search = '';
    public $data;

    public $dataWorkSteps;
    public $dataUsers;
    public $dataMachines;
    public $workSteps = [];

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

    public function addField($index)
    {
        array_splice($this->workSteps, $index + 1, 0, [[
            'work_step_list_id' => '',
            'target_date' => '',
            'schedule_date' => '',
            'target_time' => '',
            'user_id' => '',
            'machine_id' => '',
        ]]);

        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target'    => '#work_step_list_id-'.$index,
        ]);

        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target'    => '#user_id-'.$index,
        ]); 

        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target'    => '#machine_id-'.$index,
        ]); 
    }

    public function removeField($index)
    {
        unset($this->workSteps[$index]);
        $this->workSteps = array_values($this->workSteps);
    }

    public function mount()
    {
        $this->dataWorkSteps = WorkStep::whereNotIn('work_step_list_id', [1,2,3])->with('workStepList', 'user', 'machine')->get();
        $this->dataUsers = User::whereNotIn('role', ['Admin', 'Follow Up', 'Penjadwalan', 'RAB'])->get();
        $this->dataMachines = Machine::all();
        $this->search = request()->query('search', $this->search);

        

    }

    public function render()
    {
        // Init Event
        $this->dispatchBrowserEvent('pharaonic.select2.init');
        
        return view('livewire.penjadwalan.component.new-spk-dashboard-index', [
            'instructions' => $this->search === null ?
                            WorkStep::where('work_step_list_id', 2)
                                        ->where('state_task', 'Running')
                                        ->whereIn('status_task', ['Pending Approved'])
                                        ->where('spk_status', 'Running')
                                        ->whereIn('status_id', [1, 2])
                                        ->whereHas('instruction', function ($query) {
                                            $query->orderBy('shipping_date', 'asc');
                                        })
                                        ->with(['status', 'job', 'workStepList'])
                                        ->paginate($this->paginate) :
                            WorkStep::where('work_step_list_id', 2)
                                        ->where('state_task', 'Running')
                                        ->whereIn('status_task', ['Pending Approved'])
                                        ->where('spk_status', 'Running')
                                        ->whereIn('status_id', [1, 2])
                                        ->whereHas('instruction', function ($query) {
                                            $query->where('spk_number', 'like', '%' . $this->search . '%')
                                            ->orWhere('spk_type', 'like', '%' . $this->search . '%')
                                            ->orWhere('customer_name', 'like', '%' . $this->search . '%')
                                            ->orWhere('order_name', 'like', '%' . $this->search . '%')
                                            ->orWhere('customer_number', 'like', '%' . $this->search . '%')
                                            ->orWhere('code_style', 'like', '%' . $this->search . '%')
                                            ->orWhere('shipping_date', 'like', '%' . $this->search . '%')
                                            ->orderBy('shipping_date', 'asc');
                                        })
                                        ->with(['status', 'job', 'workStepList'])
                                        ->paginate($this->paginate)
        ])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Dashboard']);
    }

    public function modalInstructionDetailsNewSpk($instructionId)
    {
        $this->selectedInstruction = Instruction::find($instructionId);
        $this->selectedWorkStep = WorkStep::where('instruction_id', $instructionId)->whereNotIn('work_step_list_id', [1,2,3])->with('workStepList', 'user', 'machine')->get();
        
        foreach($this->selectedWorkStep as $key => $dataSelected){
            $workSteps = [
                'work_step_list_id' => $dataSelected['work_step_list_id'],
                'target_date' => $dataSelected['target_date'],
                'schedule_date' => $dataSelected['schedule_date'],
                'target_time' => $dataSelected['target_time'],
                'user_id' => $dataSelected['user_id'],
                'machine_id' => $dataSelected['machine_id'],
            ];
            $this->workSteps[] = $workSteps;

            // Load Event
            $this->dispatchBrowserEvent('pharaonic.select2.load', [
                'component' => $this->id,
                'target'    => '#work_step_list_id-'.$key,
            ]);

            // Load Event
            $this->dispatchBrowserEvent('pharaonic.select2.load', [
                'component' => $this->id,
                'target'    => '#user_id-'.$key,
            ]); 

            // Load Event
            $this->dispatchBrowserEvent('pharaonic.select2.load', [
                'component' => $this->id,
                'target'    => '#machine_id-'.$key,
            ]); 
        }

        

        // dd($this->workSteps);

        $this->selectedFileContoh = Files::where('instruction_id', $instructionId)->where('type_file', 'contoh')->get();
        $this->selectedFileArsip = Files::where('instruction_id', $instructionId)->where('type_file', 'arsip')->get();
        $this->selectedFileAccounting = Files::where('instruction_id', $instructionId)->where('type_file', 'accounting')->get();
        $this->selectedFileLayout = Files::where('instruction_id', $instructionId)->where('type_file', 'layout')->get();
        $this->selectedFileSample = Files::where('instruction_id', $instructionId)->where('type_file', 'sample')->get();

        $this->dispatchBrowserEvent('show-detail-instruction-modal-new-spk');
    }

    public function modalInstructionDetailsGroupNewSpk($groupId)
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

        $this->dispatchBrowserEvent('show-detail-instruction-modal-group-new-spk');
    }
}
