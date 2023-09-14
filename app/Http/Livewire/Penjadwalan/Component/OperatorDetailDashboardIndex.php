<?php

namespace App\Http\Livewire\Penjadwalan\Component;

use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;

class OperatorDetailDashboardIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginateOperator = 10;
    public $searchOperator = '';

    public $dijadwalkanSelected = '';
    public $targetSelesaiSelected = '';

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
        $this->render();
    }
    public function updatingTargetSelesaiSelected()
    {
        $this->render();
    }

    public function mount($dataUserOperator, $dataWorkStepList)
    {
        $this->userSelected = $dataUserOperator;
        $this->worksteplistSelected = $dataWorkStepList;
    }

    public function render()
    {
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

        return view('livewire.penjadwalan.component.operator-detail-dashboard-index', ['dataDetailWorkStep' => $dataDetailWorkStep]);
    }
}
