<?php

namespace App\Http\Livewire\HitungBahan\Component;

use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;

class AllDashboardIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];
 
    public $paginate = 10;
    public $search = '';
    public $data;

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
        return view('livewire.hitung-bahan.component.all-dashboard-index', [
            'instructions' => $this->search === null ?
                            WorkStep::where('work_step_list_id', 1)
                                        ->where('state_task', 'Running')
                                        ->whereIn('status_task', ['Process', 'Reject', 'Reject Requirements'])
                                        ->whereIn('spk_status', ['Running'])
                                        ->whereHas('instruction', function ($query) {
                                            $query->orderBy('shipping_date', 'asc');
                                        })
                                        ->with(['status', 'workStepList'])
                                        ->paginate($this->paginate) :
                            WorkStep::where('work_step_list_id', 1)
                                        ->where('state_task', 'Running')
                                        ->whereIn('status_task', ['Process', 'Reject', 'Reject Requirements'])
                                        ->whereIn('spk_status', ['Running'])
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
                                        ->with(['status', 'workStepList'])
                                        ->paginate($this->paginate)
        ])
        ->extends('layouts.app')
        ->layoutData(['title' => 'Dashboard']);
    }

    public function deleteSpk($instructionDeleteId)
    {
        $deleteSpk = WorkStep::where('instruction_id', $instructionDeleteId)->update([
            'spk_status' => 'Deleted'
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

        $this->dispatchBrowserEvent('close-modal');
    }

    public function holdSpk($instructionHoldId)
    {
        $holdSpk = WorkStep::where('instruction_id', $instructionHoldId)->update([
            'spk_status' => 'Hold'
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
        
        $this->dispatchBrowserEvent('close-modal');
    }

    public function cancelSpk($instructionCancelId)
    {
        $cancelSpk = WorkStep::where('instruction_id', $instructionCancelId)->update([
            'spk_status' => 'Cancel'
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

        $this->dispatchBrowserEvent('close-modal');
    }

    public function modalInstructionDetailsAll($instructionId)
    {
        $this->selectedInstruction = Instruction::find($instructionId);
        $this->instructionSelectedId = $instructionId;
        $this->selectedWorkStep = WorkStep::where('instruction_id', $instructionId)->with('workStepList', 'user', 'machine')->get();
        $this->selectedFileContoh = Files::where('instruction_id', $instructionId)->where('type_file', 'contoh')->get();
        $this->selectedFileArsip = Files::where('instruction_id', $instructionId)->where('type_file', 'arsip')->get();
        $this->selectedFileAccounting = Files::where('instruction_id', $instructionId)->where('type_file', 'accounting')->get();
        $this->selectedFileLayout = Files::where('instruction_id', $instructionId)->where('type_file', 'layout')->get();
        $this->selectedFileSample = Files::where('instruction_id', $instructionId)->where('type_file', 'sample')->get();

        $this->dispatchBrowserEvent('show-detail-instruction-modal-all');
    }

    public function modalInstructionDetailsGroupAll($groupId)
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

        $this->dispatchBrowserEvent('show-detail-instruction-modal-group-all');
    }
}
