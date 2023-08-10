<?php

namespace App\Http\Livewire\Penjadwalan\Component;

use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;

class TabDashboardIndex extends Component
{
    public $dataCountNewSpk;
    public $dataCountRunningSpk;
    public $dataCountIncomingSpk;

    protected $listeners = ['indexRender' => '$refresh'];

    public $activeTab = 'tab1';

    public function changeTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        $this->dataCountNewSpk = WorkStep::where('work_step_list_id', 2)
            ->where('state_task', 'Running')
            ->whereIn('status_task', ['Pending Approved'])
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Training Program'])
            ->whereIn('status_id', [1])
            ->whereIn('job_id', [2])
            ->whereHas('instruction', function ($query) {
                $query->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
            })
            ->orderBy('shipping_date', 'asc')
            ->with(['status', 'job', 'workStepList', 'instruction'])
            ->count();

        $this->dataCountRunningSpk = WorkStep::where('work_step_list_id', 2)
            ->where('state_task', 'Running')
            ->whereIn('status_task', ['Process', 'Reject', 'Reject Requirements'])
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Training Program'])
            ->whereHas('instruction', function ($query) {
                $query->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
            })
            ->orderBy('shipping_date', 'asc')
            ->with(['status', 'job', 'workStepList', 'instruction'])
            ->count();

        $this->dataCountIncomingSpk = WorkStep::where('work_step_list_id', 2)
            ->where('state_task', 'Not Running')
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Training Program'])
            ->whereHas('instruction', function ($query) {
                $query->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
            })
            ->orderBy('shipping_date', 'asc')
            ->with(['status', 'job', 'workStepList', 'instruction'])
            ->count();

        return view('livewire.penjadwalan.component.tab-dashboard-index')
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }
}
