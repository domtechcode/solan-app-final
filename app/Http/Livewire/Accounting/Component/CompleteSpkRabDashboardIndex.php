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
    public $dataRab = [];
    public $catatanRab;

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

    public function sumGroup($groupId)
    {
        $totalQuantityGroup = Instruction::where('group_id', $groupId)->sum('quantity');
        $totalStockGroup = Instruction::where('group_id', $groupId)->sum('stock');
        $totalQuantity = $totalQuantityGroup - $totalStockGroup;
        return $totalQuantity;
    }
    
    public function render()
    {
        $data = WorkStep::where('work_step_list_id', 3)
                ->where('state_task', 'Complete Accounting')
                ->where('status_task', 'Complete')
                ->where('user_id', '!=', null)
                ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Training Program'])
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
                    })->orderBy('shipping_date', 'asc');
                })
                ->with(['status', 'job', 'workStepList', 'instruction'])
                ->paginate($this->paginate);

        return view('livewire.accounting.component.complete-spk-rab-dashboard-index', ['instructions' => $data])

        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Dashboard']);
    }

    public function modalInstructionDetailsCompleteSpk($instructionId)
    {
        $this->dataRab = [];
        $this->selectedInstruction = Instruction::find($instructionId);
        $this->selectedWorkStep = WorkStep::where('instruction_id', $instructionId)->with('workStepList', 'user', 'machine')->get();
        $this->selectedFileContoh = Files::where('instruction_id', $instructionId)->where('type_file', 'contoh')->get();
        $this->selectedFileArsip = Files::where('instruction_id', $instructionId)->where('type_file', 'arsip')->get();
        $this->selectedFileAccounting = Files::where('instruction_id', $instructionId)->where('type_file', 'accounting')->get();
        $this->selectedFileLayout = Files::where('instruction_id', $instructionId)->where('type_file', 'layout')->get();
        $this->selectedFileSample = Files::where('instruction_id', $instructionId)->where('type_file', 'sample')->get();
        $dataInstructionRab = FormRab::where('instruction_id', $instructionId)->get();
        
        if(isset($dataInstructionRab)){
            foreach($dataInstructionRab as $item){
                $datarab = [
                    'id' => $item['id'],
                    'jenis_pengeluaran' => $item['jenis_pengeluaran'],
                    'rab' => currency_idr($item['rab']),
                    'real' => currency_idr($item['real']),
                ];

                $this->dataRab[] = $datarab;
            }
        }else{
            $this->dataRab[] = [
                'id' => '',
                'jenis_pengeluaran' => '',
                'rab' => '',
                'real' => '',
            ];
        }

        $this->dispatchBrowserEvent('show-detail-instruction-modal-complete-spk');
    }

    public function modalInstructionDetailsGroupCompleteSpk($groupId)
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

        $this->dispatchBrowserEvent('show-detail-instruction-modal-group-complete-spk');
    }
}
