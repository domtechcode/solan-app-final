<?php

namespace App\Http\Livewire\Penjadwalan\Component;

use App\Models\User;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\WorkStepList;
use Livewire\WithPagination;

class OperatorDashboardIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginateOperator = 10;
    public $searchOperator = '';

    public $dijadwalkanSelected = '';
    public $targetSelesaiSelected = '';

    public $dataWorkStepList;
    public $dataUser;
    public $userSelected;
    public $worksteplistSelected;

    public $workSteps = [];
    public $dataWorkStep;
    public $changeTo = [];

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

    protected $listeners = ['indexRenderPage' => 'refresh'];

    public function updatingDijadwalkanSelected()
    {
        $this->resetPage();
    }

    public function updatingTargetSelesaiSelected()
    {
        $this->resetPage();
    }

    public function updatingWorksteplistSelected()
    {
        $this->resetPage();
    }

    public function updatingUserSelected()
    {
        $this->resetPage();
    }

    public function refresh()
    {
        $this->mount();
        $this->render();
    }

    public function mount()
    {
        $this->select2();
        $this->dataWorkStepList = WorkStepList::whereNotIn('id', [1, 2, 3, 4, 5])->get();
        $this->dataUser = User::where('role', 'Operator')->get();
        $this->userSelected = 'all';
        $this->worksteplistSelected = 6;

        if ($this->userSelected == 'all') {
            $dataDetailWorkStep = WorkStep::where('work_step_list_id', $this->worksteplistSelected)
                ->whereIn('state_task', ['Running', 'Not Running'])
                ->whereIn('status_task', ['Pending Approved', 'Process', 'Waiting', 'Pending Start'])
                ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Close PO', 'Training Program'])
                ->where(function ($query) {
                    $searchTerms = '%' . $this->dijadwalkanSelected . '%';
                    $searchTermsTarget = '%' . $this->targetSelesaiSelected . '%';
                    $query
                        ->where(function ($instructionQuery) use ($searchTerms, $searchTermsTarget) {
                            $instructionQuery->orWhere('schedule_date', 'like', $searchTerms)->where('target_date', 'like', $searchTermsTarget);
                        })
                        ->whereHas('instruction', function ($subQuery) {
                            $subQuery->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
                        });
                })
                ->with(['instruction', 'user', 'instruction.layoutBahan', 'machine'])
                // ->paginate($this->paginateOperator);
                ->orderBy('user_id', 'asc')
                ->get();

            $dataDetailWorkStep->groupBy('user_id');

            $this->changeTo = [];
            foreach ($dataDetailWorkStep as $data) {
                $item = [
                    'user_id' => $data->user_id,
                    'schedule_date' => $data->schedule_date,
                    'target_date' => $data->target_date,
                ];

                $this->changeTo[] = $item;
            }
        } else {
            $dataDetailWorkStep = WorkStep::where('work_step_list_id', $this->worksteplistSelected)
                ->where('user_id', $this->userSelected)
                ->whereIn('state_task', ['Running', 'Not Running'])
                ->whereIn('status_task', ['Pending Approved', 'Process', 'Waiting', 'Pending Start'])
                ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Close PO', 'Training Program'])
                ->where(function ($query) {
                    $searchTerms = '%' . $this->dijadwalkanSelected . '%';
                    $searchTermsTarget = '%' . $this->targetSelesaiSelected . '%';
                    $query
                        ->where(function ($instructionQuery) use ($searchTerms, $searchTermsTarget) {
                            $instructionQuery->orWhere('schedule_date', 'like', $searchTerms)->where('target_date', 'like', $searchTermsTarget);
                        })
                        ->whereHas('instruction', function ($subQuery) {
                            $subQuery->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
                        });
                })
                ->with(['instruction', 'user', 'instruction.layoutBahan', 'machine'])
                ->paginate($this->paginateOperator);

            $this->changeTo = [];
            foreach ($dataDetailWorkStep as $data) {
                $item = [
                    'user_id' => $data->user_id,
                    'schedule_date' => $data->schedule_date,
                    'target_date' => $data->target_date,
                ];

                $this->changeTo[] = $item;
            }
        }
    }

    public function select2()
    {
        // Init Event
        $this->dispatchBrowserEvent('pharaonic.select2.init');

        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target' => '#worksteplistSelected',
        ]);

        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target' => '#userSelected',
        ]);
    }

    public function render()
    {
        $this->select2();
        if ($this->userSelected == 'all') {
            $dataDetailWorkStep = WorkStep::where('work_step_list_id', $this->worksteplistSelected)
                ->whereIn('state_task', ['Running', 'Not Running'])
                ->whereIn('status_task', ['Pending Approved', 'Process', 'Waiting', 'Pending Start'])
                ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Close PO', 'Training Program'])
                ->where(function ($query) {
                    $searchTerms = '%' . $this->dijadwalkanSelected . '%';
                    $searchTermsTarget = '%' . $this->targetSelesaiSelected . '%';
                    $query
                        ->where(function ($instructionQuery) use ($searchTerms, $searchTermsTarget) {
                            $instructionQuery->orWhere('schedule_date', 'like', $searchTerms)->where('target_date', 'like', $searchTermsTarget);
                        })
                        ->whereHas('instruction', function ($subQuery) {
                            $subQuery->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
                        });
                })
                ->with(['instruction', 'user', 'instruction.layoutBahan', 'machine'])
                // ->paginate($this->paginateOperator);
                ->orderBy('user_id', 'asc')
                ->get();

            $dataDetailWorkStep->groupBy('user_id');

            $this->changeTo = [];
            foreach ($dataDetailWorkStep as $data) {
                $item = [
                    'user_id' => $data->user_id,
                    'schedule_date' => $data->schedule_date,
                    'target_date' => $data->target_date,
                ];

                $this->changeTo[] = $item;
            }
        } else {
            $dataDetailWorkStep = WorkStep::where('work_step_list_id', $this->worksteplistSelected)
                ->where('user_id', $this->userSelected)
                ->whereIn('state_task', ['Running', 'Not Running'])
                ->whereIn('status_task', ['Pending Approved', 'Process', 'Waiting', 'Pending Start'])
                ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Close PO', 'Training Program'])
                ->where(function ($query) {
                    $searchTerms = '%' . $this->dijadwalkanSelected . '%';
                    $searchTermsTarget = '%' . $this->targetSelesaiSelected . '%';
                    $query
                        ->where(function ($instructionQuery) use ($searchTerms, $searchTermsTarget) {
                            $instructionQuery->orWhere('schedule_date', 'like', $searchTerms)->where('target_date', 'like', $searchTermsTarget);
                        })
                        ->whereHas('instruction', function ($subQuery) {
                            $subQuery->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
                        });
                })
                ->with(['instruction', 'user', 'instruction.layoutBahan', 'machine'])
                ->paginate($this->paginateOperator);

                $this->changeTo = [];
            foreach ($dataDetailWorkStep as $data) {
                $item = [
                    'user_id' => $data->user_id,
                    'schedule_date' => $data->schedule_date,
                    'target_date' => $data->target_date,
                ];

                $this->changeTo[] = $item;
            }
        }

        // dd($this->changeTo);

        return view('livewire.penjadwalan.component.operator-dashboard-index', ['dataDetailWorkStep' => $dataDetailWorkStep]);
    }

    public function pindahOperator($selectedValue, $keyValue)
    {
        $searchWorkStep = WorkStep::find($selectedValue);
        $searchWorkStep->update([
            'user_id' => $this->changeTo[$keyValue]['user_id'],
            'target_date' => $this->changeTo[$keyValue]['target_date'],
            'schedule_date' => $this->changeTo[$keyValue]['schedule_date'],
        ]);

        $this->changeTo = [];
        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Success Reschedule',
            'message' => 'Data berhasil disimpan',
        ]);
        $this->emit('indexRenderPage');
    }
}
