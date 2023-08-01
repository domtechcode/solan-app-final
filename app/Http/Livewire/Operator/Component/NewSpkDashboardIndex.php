<?php

namespace App\Http\Livewire\Operator\Component;

use DB;
use App\Models\User;
use App\Models\Files;
use App\Models\Machine;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use App\Models\WorkStepList;
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
            'work_step_list_id' => NULL,
            'target_date' => NULL,
            'schedule_date' => NULL,
            'target_time' => NULL,
            'user_id' => NULL,
            'machine_id' => NULL,
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
        $this->dataWorkSteps = WorkStepList::whereNotIn('id', [1,2,3])->get();
        $this->dataUsers = User::whereNotIn('role', ['Admin', 'Follow Up', 'Penjadwalan', 'RAB'])->get();
        $this->dataMachines = Machine::all();
        $this->search = request()->query('search', $this->search);
    }

    public function sumGroup($groupId)
    {
        $totalQuantityGroup = Instruction::where('group_id', $groupId)->sum('quantity');
        $totalStockGroup = Instruction::where('group_id', $groupId)->sum('stock');
        $totalQuantity = $totalQuantityGroup - $totalStockGroup;
        return $totalQuantity;
    }

    public function render()
    {
        // Init Event
        $this->dispatchBrowserEvent('pharaonic.select2.init');

        $data = WorkStep::where('user_id', Auth()->user()->id)
                ->where('state_task', 'Running')
                ->whereIn('status_task', ['Pending Approved', 'Process', 'Reject Requirements'])
                ->where('spk_status', 'Running')
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
                        // Tambahkan kondisi jika work_step_list_id bukan 35 atau 36
                        $subQuery->where(function ($nestedSubQuery) {
                            $nestedSubQuery->whereIn('work_step_list_id', [35, 36])
                                ->orWhereNull('group_priority');
                        })->orWhere('group_priority', 'parent');
                    })->orderBy('shipping_date', 'asc');
                })
                ->with(['status', 'job', 'workStepList'])
                ->paginate($this->paginate);

        
        return view('livewire.operator.component.new-spk-dashboard-index', [ 'instructions' => $data ])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Dashboard']);
    }

    public function save()
    {
        $this->validate([
            'workSteps.*.work_step_list_id' => 'required',
            'workSteps.*.schedule_date' => 'required',
            'workSteps.*.target_date' => 'required',
            'workSteps.*.user_id' => 'required',
        ]);

        $firstWorkStep = WorkStep::where('instruction_id', $this->selectedInstruction->id)->where('work_step_list_id', 2)->first();
        $lastWorkStep = WorkStep::where('instruction_id', $this->selectedInstruction->id)->max(DB::raw('CAST(step AS SIGNED)'));

        $deleteWorkSteps = WorkStep::where('instruction_id', $this->selectedInstruction->id)
                        ->where('step', '>', $firstWorkStep->step)
                        ->get();
        
        if($deleteWorkSteps){
            foreach($deleteWorkSteps as $dataDeleted){
                WorkStep::where('id', $dataDeleted->id)->delete();
            }
        }

        // Insert new work steps starting from firstWorkStep->step + 1
        $stepToAdd = $firstWorkStep->step + 1;
        $newWorkSteps = [];

        foreach ($this->workSteps as $index => $workStepData) {
            $newWorkSteps[] = [
                'instruction_id' => $this->selectedInstruction->id,
                'work_step_list_id' => $workStepData['work_step_list_id'],
                'target_date' => $workStepData['target_date'],
                'schedule_date' => $workStepData['schedule_date'],
                'target_time' => $workStepData['target_time'],
                'user_id' => $workStepData['user_id'],
                'machine_id' => $workStepData['machine_id'],
                'step' => $stepToAdd++,
                'state_task' => 'Not Running',
                'status_task' => 'Waiting',
            ];
        }

        $inserWorkStep = WorkStep::insert($newWorkSteps);

        $nextWorkStep = WorkStep::where('instruction_id', $this->selectedInstruction->id)->where('step', $firstWorkStep->step + 1)->update([
            'state_task' => 'Not Running',
            'status_task' => 'Pending Start',
        ]);

        $updateJobStatus = WorkStep::where('instruction_id', $this->selectedInstruction->id)->update([
            'job_id' => $firstWorkStep->work_step_list_id,
            'status_id' => 2,
        ]);

        $firstWorkStep->update([
            'status_task' => 'Process',
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Jadwal Instruksi Kerja',
            'message' => 'Data jadwal berhasil disimpan',
        ]);

        $this->emit('indexRender');
        $this->reset();
        $this->dispatchBrowserEvent('close-modal-new-spk');
    }

    public function modalInstructionDetailsNewSpk($instructionId)
    {
        $this->selectedInstruction = Instruction::find($instructionId);
        $this->selectedWorkStep = WorkStep::where('instruction_id', $instructionId)->with('workStepList', 'user', 'machine')->get();
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
