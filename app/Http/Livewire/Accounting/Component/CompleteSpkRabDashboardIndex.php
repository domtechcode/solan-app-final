<?php

namespace App\Http\Livewire\Accounting\Component;

use App\Models\Files;
use App\Models\FormRab;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;
use App\Events\IndexRenderEvent;

class CompleteSpkRabDashboardIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginateCompleteSpkRab = 10;
    public $searchCompleteSpkRab = '';
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
    public $dataRab = [];
    public $catatanRab;

    public $workStepHitungBahanNew;

    protected $listeners = ['indexRender' => '$refresh'];

    public function updatingSearchCompleteSpkRab()
    {
        $this->resetPage();
    }

    public function renderIndex()
    {
        $this->reset();
    }

    public function mount()
    {
        $this->searchCompleteSpkRab = request()->query('search', $this->searchCompleteSpkRab);
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
        $dataCompleteSpkRab = WorkStep::where('work_step_list_id', 3)
            ->where('state_task', 'Complete')
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Training Program'])
            ->whereHas('instruction', function ($query) {
                $searchTerms = '%' . $this->searchCompleteSpkRab . '%';
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
            ->whereHas('instruction.formRab', function ($query) {
                $query->where('real', '!=', null);
            })
            ->join('instructions', 'work_steps.instruction_id', '=', 'instructions.id')
            ->select('work_steps.*')
            ->with(['status', 'job', 'workStepList', 'instruction'])
            ->orderBy('instructions.shipping_date', 'asc')
            ->paginate($this->paginateCompleteSpkRab);

        return view('livewire.accounting.component.complete-spk-rab-dashboard-index', ['instructionsCompleteSpkRab' => $dataCompleteSpkRab])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function modalInstructionDetailsCompleteSpkRab($instructionId)
    {
        $this->reset();
        $this->dataRab = [];
        $this->selectedInstruction = Instruction::find($instructionId);

        if ($this->selectedInstruction->group_id == null && $this->selectedInstruction->group_priority == null) {
            $dataworkStepHitungBahanNew = WorkStep::where('instruction_id', $instructionId)
                ->where('work_step_list_id', 5)
                ->first();

            if (isset($dataworkStepHitungBahanNew)) {
                $this->workStepHitungBahanNew = $dataworkStepHitungBahanNew->id;
            }

            $dataInstructionRab = FormRab::where('instruction_id', $instructionId)
                ->where('count', $this->selectedInstruction->count)
                ->get();
        } else {
            $parentSpk = Instruction::where('group_id', $this->selectedInstruction->group_id)
                ->where('group_priority', 'parent')
                ->first();

            $dataworkStepHitungBahanNew = WorkStep::where('instruction_id', $parentSpk->id)
                ->where('work_step_list_id', 5)
                ->first();

            $dataInstructionRab = FormRab::where('instruction_id', $parentSpk->id)
                ->where('count', $parentSpk->count)
                ->get();

            if (isset($dataworkStepHitungBahanNew)) {
                $this->workStepHitungBahanNew = $dataworkStepHitungBahanNew->id;
            }
        }

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

        if (isset($dataInstructionRab)) {
            foreach ($dataInstructionRab as $item) {
                $datarab = [
                    'id' => $item['id'],
                    'jenis_pengeluaran' => $item['jenis_pengeluaran'],
                    'rab' => $item['rab'],
                    'real' => $item['real'],
                ];

                $this->dataRab[] = $datarab;
            }
        } else {
            $this->dataRab[] = [
                'id' => '',
                'jenis_pengeluaran' => '',
                'rab' => '',
                'real' => '',
            ];
        }

        $this->dispatchBrowserEvent('show-detail-instruction-modal-complete-spk-rab');
    }

    public function editRab()
    {
        $this->validate([
            'dataRab.*.id' => 'required',
            'dataRab.*.jenis_pengeluaran' => 'required',
            'dataRab.*.rab' => 'required',
            'dataRab.*.real' => 'required',
        ]);

        if (isset($this->dataRab)) {
            foreach ($this->dataRab as $key => $data) {
                $updateRab = FormRab::find($data['id']);
                $updateRab->update([
                    'jenis_pengeluaran' => $data['jenis_pengeluaran'],
                    'rab' => $data['rab'],
                    'real' => $data['real'],
                ]);
            }
        }

        $updateState = WorkStep::where('instruction_id', $this->selectedInstruction->id)
            ->where('work_step_list_id', 3)
            ->update([
                'state_task' => 'Complete',
            ]);

        $this->dataRab = [];

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'RAB Instruksi Kerja',
            'message' => 'Berhasil menyimpan data RAB',
        ]);

        $this->emit('indexRender');
        $this->reset();
        $this->dispatchBrowserEvent('close-modal-complete-spk-rab');
    }

    public function modalInstructionDetailsGroupCompleteSpkRab($groupId)
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
