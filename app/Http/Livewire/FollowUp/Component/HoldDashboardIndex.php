<?php

namespace App\Http\Livewire\FollowUp\Component;

use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;

class HoldDashboardIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginateHold = 10;
    public $searchHold = '';

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
    public $waitingSpkHoldQc;
    public $spkProduction;

    protected $listeners = ['indexRender' => '$refresh'];

    public function mount()
    {
        $this->searchHold = request()->query('search', $this->searchHold);
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

        $dataHold = WorkStep::where('work_step_list_id', 1)
            ->whereIn('spk_status', ['Hold', 'Hold Waiting Qty QC', 'Hold RAB', 'Hold Qc', 'Failed Waiting Qty QC'])
            ->whereHas('instruction', function ($query) {
                $searchTerms = '%' . $this->searchHold . '%';
                $query
                    ->where(function ($subQuery) use ($searchTerms) {
                        $subQuery
                            ->orWhere('spk_number', 'like', $searchTerms)
                            ->orWhere('spk_type', 'like', $searchTerms)
                            ->orWhere('customer_name', 'like', $searchTerms)
                            ->orWhere('order_name', 'like', $searchTerms)
                            ->orWhere('customer_number', 'like', $searchTerms)
                            ->orWhere('code_style', 'like', $searchTerms)
                            ->orWhere('shipping_date', 'like', $searchTerms);
                    })
                    ->where(function ($subQuery) {
                        $subQuery->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
                    });
            })
            ->join('instructions', 'work_steps.instruction_id', '=', 'instructions.id')
            ->select('work_steps.*')
            ->with(['status', 'job', 'workStepList', 'instruction'])
            ->orderBy('instructions.shipping_date', 'asc')
            ->paginate($this->paginateHold);

        return view('livewire.follow-up.component.hold-dashboard-index', ['instructionsHold' => $dataHold])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function unholdSpk($instructionHoldId)
    {
        $holdSpk = WorkStep::where('instruction_id', $instructionHoldId)->update([
            'spk_status' => 'Running',
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Unhold Instruksi Kerja',
            'message' => 'SPK berhasil dijalankan kembali',
        ]);

        $this->dispatchBrowserEvent('close-modal-hold');
    }

    public function updateSpkHoldQc($instructionHoldQcId)
    {
        $this->validate([
            'waitingSpkHoldQc' => 'required',
        ]);

        $updateInstruction = Instruction::find($instructionHoldQcId);
        $updateInstruction->update([
            'waiting_spk_qc' => $this->waitingSpkHoldQc,
        ]);

        $currentWorkStep = WorkStep::where('instruction_id', $updateInstruction->id)->update([
            'spk_status' => 'Hold Waiting Qty QC',
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Hold Qc Instruksi Kerja',
            'message' => 'SPK berhasil disimpan',
        ]);

        $this->dispatchBrowserEvent('close-modal-hold-qc');
    }

    public function modalInstructionDetailsHold($instructionId)
    {
        $this->selectedInstruction = Instruction::find($instructionId);
        $this->instructionSelectedId = $instructionId;
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
    }

    public function modalInstructionDetailsHoldQc($instructionId)
    {
        $this->selectedInstruction = Instruction::find($instructionId);
        $this->instructionSelectedId = $instructionId;
        $this->waitingSpkHoldQc = $this->selectedInstruction->waiting_spk_qc;
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
        $this->spkProduction = Instruction::where('spk_type', 'production')->get();

        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target' => '#waitingSpkHoldQc',
        ]);
    }

    public function modalInstructionDetailsGroupHold($groupId)
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
