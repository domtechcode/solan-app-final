<?php

namespace App\Http\Livewire\Operator\Component;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Files;
use App\Models\Machine;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use App\Models\WorkStepList;
use Livewire\WithPagination;
use App\Events\NotificationSent;

class NewSpkDashboardIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginateNewSpk = 10;
    public $searchNewSpk = '';
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

    public $instructionSelectedId;
    public $workStepSelectedId;
    public $workStepData;

    protected $listeners = ['indexRender' => '$refresh'];

    public function updatingSearchNewSpk()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->searchNewSpk = request()->query('search', $this->searchNewSpk);
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
        $today = Carbon::today();
        $formattedToday = $today->format('Y-m-d');

        if (Auth()->user()->jobdesk == 'Checker') {
            $dataNewSpk = WorkStep::where('work_step_list_id', 37)
                ->where('state_task', 'Running')
                ->whereIn('status_task', ['Pending Approved', 'Process', 'Reject Requirements'])
                ->where('spk_status', 'Running')
                ->where('schedule_date', '<=', $formattedToday)
                ->orderBy('task_priority', 'desc')
                ->where(function ($query) {
                    $query
                        ->where(function ($subQuery) {
                            $subQuery->whereIn('status_id', [1, 3, 22]);
                        })
                        ->orWhere(function ($subQuery) {
                            $subQuery->whereIn('status_id', [2])->where('user_id', Auth()->user()->id);
                        });
                })
                ->whereHas('instruction', function ($query) {
                    $searchTerms = '%' . $this->searchNewSpk . '%';
                    $query
                        ->where(function ($subQuery) use ($searchTerms) {
                            $subQuery
                                ->orWhere('spk_number', 'like', $searchTerms)
                                ->orWhere('spk_type', 'like', $searchTerms)
                                ->orWhere('customer_name', 'like', $searchTerms)
                                ->orWhere('order_name', 'like', $searchTerms)
                                ->orWhere('customer_number', 'like', $searchTerms)
                                ->orWhere('code_style', 'like', $searchTerms)
                                ->orWhere('shipping_date', 'like', $searchTerms)
                                ->orWhere('ukuran_barang', 'like', $searchTerms)
                                ->orWhere('spk_number_fsc', 'like', $searchTerms);
                        })
                        ->where(function ($subQuery) {
                            // Tambahkan kondisi jika work_step_list_id bukan 35 atau 36
                            $subQuery
                                ->where(function ($nestedSubQuery) {
                                    $nestedSubQuery->whereIn('work_step_list_id', [35, 36])->orWhereNull('group_priority');
                                })
                                ->orWhere('group_priority', 'parent');
                        });
                })
                ->join('instructions', 'work_steps.instruction_id', '=', 'instructions.id')
                ->select('work_steps.*')
                ->with(['status', 'job', 'workStepList', 'instruction'])
                ->orderBy('instructions.shipping_date', 'asc')
                ->paginate($this->paginateNewSpk);
        } elseif (Auth()->user()->jobdesk == 'Maklun') {
            $dataNewSpk = WorkStep::where('user_id', Auth()->user()->id)
                ->where('state_task', 'Running')
                ->whereIn('status_task', ['Pending Approved', 'Process', 'Reject Requirements'])
                ->where('spk_status', 'Running')
                ->where('schedule_date', '<=', $formattedToday)
                ->orderBy('task_priority', 'desc')
                ->whereHas('instruction', function ($query) {
                    $searchTerms = '%' . $this->searchNewSpk . '%';
                    $query
                        ->where(function ($subQuery) use ($searchTerms) {
                            $subQuery
                                ->orWhere('spk_number', 'like', $searchTerms)
                                ->orWhere('spk_type', 'like', $searchTerms)
                                ->orWhere('customer_name', 'like', $searchTerms)
                                ->orWhere('order_name', 'like', $searchTerms)
                                ->orWhere('customer_number', 'like', $searchTerms)
                                ->orWhere('code_style', 'like', $searchTerms)
                                ->orWhere('shipping_date', 'like', $searchTerms)
                                ->orWhere('ukuran_barang', 'like', $searchTerms)
                                ->orWhere('spk_number_fsc', 'like', $searchTerms);
                        })
                        ->where(function ($subQuery) {
                            // Tambahkan kondisi jika work_step_list_id bukan 35 atau 36
                            $subQuery
                                ->where(function ($nestedSubQuery) {
                                    $nestedSubQuery->whereIn('work_step_list_id', [35, 36])->orWhereNull('group_priority');
                                })
                                ->orWhere('group_priority', 'parent');
                        });
                })
                ->join('instructions', 'work_steps.instruction_id', '=', 'instructions.id')
                ->select('work_steps.*')
                ->with(['status', 'job', 'workStepList', 'instruction'])
                ->orderBy('instructions.shipping_date', 'asc')
                ->paginate($this->paginateNewSpk);
        } else {
            $dataNewSpk = WorkStep::where('user_id', Auth()->user()->id)
                ->where('state_task', 'Running')
                ->whereIn('status_task', ['Pending Approved', 'Process', 'Reject Requirements'])
                ->where('spk_status', 'Running')
                ->where('schedule_date', '<=', $formattedToday)
                ->orderBy('task_priority', 'desc')
                ->whereHas('instruction', function ($query) {
                    $searchTerms = '%' . $this->searchNewSpk . '%';
                    $query
                        ->where(function ($subQuery) use ($searchTerms) {
                            $subQuery
                                ->orWhere('spk_number', 'like', $searchTerms)
                                ->orWhere('spk_type', 'like', $searchTerms)
                                ->orWhere('customer_name', 'like', $searchTerms)
                                ->orWhere('order_name', 'like', $searchTerms)
                                ->orWhere('customer_number', 'like', $searchTerms)
                                ->orWhere('code_style', 'like', $searchTerms)
                                ->orWhere('shipping_date', 'like', $searchTerms)
                                ->orWhere('ukuran_barang', 'like', $searchTerms)
                                ->orWhere('spk_number_fsc', 'like', $searchTerms);
                        })
                        ->where(function ($subQuery) {
                            // Tambahkan kondisi jika work_step_list_id bukan 35 atau 36
                            $subQuery
                                ->where(function ($nestedSubQuery) {
                                    $nestedSubQuery->whereIn('work_step_list_id', [35, 36])->orWhereNull('group_priority');
                                })
                                ->orWhere('group_priority', 'parent');
                        });
                })
                ->join('instructions', 'work_steps.instruction_id', '=', 'instructions.id')
                ->select('work_steps.*')
                ->with(['status', 'job', 'workStepList', 'instruction'])
                ->orderBy('instructions.shipping_date', 'asc')
                ->paginate($this->paginateNewSpk);
        }

        return view('livewire.operator.component.new-spk-dashboard-index', ['instructionsNewSpk' => $dataNewSpk])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function modalInstructionDetailsNewSpk($instructionId)
    {
        $this->selectedInstruction = Instruction::find($instructionId);
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

    public function modalInstructionDetailsGroupNewSpk($groupId)
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

    public function operatorDikerjakan($instructionId, $workStepId)
    {
        $this->instructionSelectedId = $instructionId;
        $this->workStepSelectedId = $workStepId;
        $dataWorkStep = WorkStep::find($this->workStepSelectedId);

        if (Auth()->user()->jobdesk == 'Checker') {
            $dataWorkStep->update([
                'user_id' => Auth()->user()->id,
            ]);

            $userDestinationChecker = User::where('jobdesk', 'Checker')->get();
            foreach ($userDestinationChecker as $dataUser) {
                $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Sedang dikerjakan ' . $dataWorkStep->workStepList->name, 'instruction_id' => $this->instructionSelectedId]);
            }
        }

        if ($dataWorkStep->dikerjakan == null) {
            $dataWorkStep->update([
                'dikerjakan' => Carbon::now()->toDateTimeString(),
            ]);
        } else {
            $dataDiKerjakan = WorkStep::find($workStepId);

            // Ambil alasan pause yang sudah ada dari database
            $existingDiKerjakan = json_decode($dataDiKerjakan->dikerjakan, true);

            // Tambahkan alasan pause yang baru ke dalam array existingDiKerjakan
            $timestampedKeterangan = Carbon::now()->toDateTimeString();
            $existingDiKerjakan[] = $timestampedKeterangan;

            // Simpan data ke database sebagai JSON
            $updateCatatanPengerjaan = WorkStep::where('id', $workStepId)->update([
                'dikerjakan' => json_encode($existingDiKerjakan),

            ]);
        }

        $dataWorkStep->update([
            'status_task' => 'Process',
        ]);

        $updateJobStatus = WorkStep::where('instruction_id', $this->instructionSelectedId)->update([
            'status_id' => 2,
        ]);

        $this->workStepData = WorkStep::find($this->workStepSelectedId);
        $workStepDataCurrent = WorkStep::find($this->workStepSelectedId);

        $userDestination = User::where('role', 'Penjadwalan')->get();
        foreach ($userDestination as $dataUser) {
            $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Sedang dikerjakan ' . $workStepDataCurrent->workStepList->name, 'instruction_id' => $this->instructionSelectedId]);
        }
    }

    public function messageSent($arguments)
    {
        $createdMessage = 'info';
        $selectedConversation = $arguments['conversation'];
        $receiverUser = $arguments['receiver'];
        $instruction_id = $arguments['instruction_id'];

        event(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, $receiverUser));
    }
}
