<?php

namespace App\Http\Livewire\Component;

use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;
use Illuminate\Support\Facades\URL;

class UngroupIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];
    public $paginate = 10;
    public $search = '';

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

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }

    public function render()
    {
        return view('livewire.component.ungroup-index', [
            'instructions' =>
                $this->search === null
                    ? Instruction::whereNotNull('group_id')
                        ->whereNotNull('group_priority')
                        // ->where('spk_state', 'Running')
                        ->orderBy('shipping_date', 'asc')
                        ->with(['workStep', 'workStep.status', 'workStep.job'])
                        ->paginate($this->paginate)
                    : Instruction::whereNotNull('group_id')
                        ->whereNotNull('group_priority')
                        // ->where('spk_state', 'Running')
                        ->orderBy('shipping_date', 'asc')
                        ->where(function ($query) {
                            $query
                                ->where('spk_number', 'like', '%' . $this->search . '%')
                                ->orWhere('spk_type', 'like', '%' . $this->search . '%')
                                ->orWhere('customer_name', 'like', '%' . $this->search . '%')
                                ->orWhere('order_name', 'like', '%' . $this->search . '%')
                                ->orWhere('customer_number', 'like', '%' . $this->search . '%')
                                ->orWhere('code_style', 'like', '%' . $this->search . '%')
                                ->orWhere('shipping_date', 'like', '%' . $this->search . '%')
                                ->orWhere('group_priority', 'like', '%' . $this->search . '%')
                                ->orderBy('shipping_date', 'asc');
                        })
                        ->with(['workStep', 'workStep.status', 'workStep.job'])
                        ->paginate($this->paginate),
        ])
            ->extends('layouts.app')
            ->layoutData(['title' => 'Form Instruksi Kerja']);
    }

    public function deleteGroup($instructionId)
    {
        $updateInstruction = Instruction::where('id', $instructionId)->update([
            'group_id' => null,
            'group_priority' => null,
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Success Ungroup',
            'message' => 'Group berhasil dihapus',
        ]);

        $this->reset();
    }

    public function modalInstructionDetailsGroup($groupId)
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

        $this->dispatchBrowserEvent('show-detail-instruction-modal-group');
    }
}
