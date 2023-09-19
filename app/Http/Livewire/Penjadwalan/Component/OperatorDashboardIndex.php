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

    public function mount()
    {
        $this->select2();
        $this->dataWorkStepList = WorkStepList::whereNotIn('id', [1, 2, 3, 4, 5])->get();
        $this->dataUser = User::where('role', 'Operator')->get();

        $this->userSelected = 'all';
        $this->worksteplistSelected = 6;
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
        if ($this->userSelected == 'all') {
            $dataDetailWorkStep = WorkStep::where('work_step_list_id', $this->worksteplistSelected)
                ->where('state_task', 'Running')
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
        } else {
            $dataDetailWorkStep = WorkStep::where('work_step_list_id', $this->worksteplistSelected)
                ->where('user_id', $this->userSelected)
                ->where('state_task', 'Running')
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
        }

        return view('livewire.penjadwalan.component.operator-dashboard-index', ['dataDetailWorkStep' => $dataDetailWorkStep]);
    }
}
