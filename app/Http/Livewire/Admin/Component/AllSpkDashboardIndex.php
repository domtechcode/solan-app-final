<?php

namespace App\Http\Livewire\Admin\Component;

use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use App\Models\WorkStepList;
use Livewire\WithPagination;

class AllSpkDashboardIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginateAll = 10;
    public $searchAll = '';

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

    public $searchFinish;
    public $searchWork;
    public $dataWorkStepList;

    protected $listeners = ['indexRender' => '$refresh'];

    public function updatingSearchAll()
    {
        $this->resetPage();
    }

    public function updatingSearchFinish()
    {
        $this->resetPage();
    }

    public function updatingSearchWork()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->searchAll = request()->query('search', $this->searchAll);
        $this->searchFinish = request()->query('search', $this->searchFinish);
        $this->searchWork = request()->query('search', $this->searchWork);

        $this->dataWorkStepList = WorkStepList::all();
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
        if($this->searchWork == null){
            $this->searchWork = 1;
        }

        $dataAll = WorkStep::where('work_step_list_id', $this->searchWork)
            ->where(function ($query) {
                $query
                    ->whereHas('instruction', function ($instructionQuery) {
                        $instructionQuery->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
                    });
            })
            ->join('instructions', 'work_steps.instruction_id', '=', 'instructions.id')
            ->select('work_steps.*')
            ->with(['status', 'job', 'workStepList', 'instruction'])
            ->orderBy('instructions.shipping_date', 'asc')
            ->search(trim($this->searchAll))
            ->searchFinish(trim($this->searchFinish))
            ->paginate($this->paginateAll);

        return view('livewire.admin.component.all-spk-dashboard-index', ['instructionsAll' => $dataAll])
            ->extends('layouts.app')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function deleteSpk($instructionDeleteId)
    {
        $deleteSpk = WorkStep::where('instruction_id', $instructionDeleteId)->update([
            'spk_status' => 'Deleted',
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Delete Instruksi Kerja',
            'message' => 'SPK berhasil didelete',
        ]);

        $this->emit('notifSent', [
            'instruction_id' => '',
            'user_id' => '',
            'message' => '',
            'conversation_id' => '',
            'receiver_id' => '',
        ]);

        $this->dispatchBrowserEvent('close-modal-delete-all');
    }

    public function holdSpk($instructionHoldId)
    {
        $holdSpk = WorkStep::where('instruction_id', $instructionHoldId)->update([
            'spk_status' => 'Hold',
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Hold Instruksi Kerja',
            'message' => 'SPK berhasil dihold',
        ]);

        $this->emit('notifSent', [
            'instruction_id' => '',
            'user_id' => '',
            'message' => '',
            'conversation_id' => '',
            'receiver_id' => '',
        ]);

        $this->dispatchBrowserEvent('close-modal-hold-all');
    }

    public function cancelSpk($instructionCancelId)
    {
        $cancelSpk = WorkStep::where('instruction_id', $instructionCancelId)->update([
            'spk_status' => 'Cancel',
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Cancel Instruksi Kerja',
            'message' => 'SPK berhasil dicancel',
        ]);

        $this->emit('notifSent', [
            'instruction_id' => '',
            'user_id' => '',
            'message' => '',
            'conversation_id' => '',
            'receiver_id' => '',
        ]);

        $this->dispatchBrowserEvent('close-modal-cancel-all');
    }

    public function modalInstructionDetailsAll($instructionId)
    {
        $this->selectedInstruction = Instruction::find($instructionId);
        $this->instructionSelectedId = $instructionId;
        $this->selectedWorkStep = WorkStep::where('instruction_id', $instructionId)
            ->with('workStepList', 'user', 'machine')
            ->orderBy('step', 'asc')
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
    }

    public function modalInstructionDetailsGroupAll($groupId)
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
    }
}
