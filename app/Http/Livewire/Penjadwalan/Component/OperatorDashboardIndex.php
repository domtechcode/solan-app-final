<?php

namespace App\Http\Livewire\Penjadwalan\Component;

use Livewire\Component;
use App\Models\WorkStep;

class OperatorDashboardIndex extends Component
{
    public $workStepListIdSelected;

    public $activeTabUser = 'TabUser2';

    public function changeTabUser($tabUser)
    {
        $this->activeTabUser = $tabUser;
    }

    public function mount($dataWorkStepList)
    {
        $this->workStepListIdSelected = $dataWorkStepList;
    }

    public function render()
    {
        $dataWorkStep = WorkStep::where('work_step_list_id', $this->workStepListIdSelected)
            ->where('user_id', '!=', null)
            ->where('state_task', 'Running')
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Close PO', 'Training Program'])
            ->where(function ($query) {
                $query
                    ->whereHas('instruction', function ($subQuery) {
                        $subQuery->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
                    });
            })
            ->orderBy('user_id', 'asc')
            ->with(['instruction', 'user'])
            ->get();

            $groupedData = $dataWorkStep->groupBy('user_id');

        return view('livewire.penjadwalan.component.operator-dashboard-index', ['groupedData' => $groupedData]);
    }
}
