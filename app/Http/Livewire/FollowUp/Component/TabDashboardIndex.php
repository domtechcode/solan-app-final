<?php

namespace App\Http\Livewire\FollowUp\Component;

use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;

class TabDashboardIndex extends Component
{
    public $dataCountNewSpk;
    public $dataCountRejectSpk;
    public $dataCountRunningSpk;
    public $dataCountHoldSpk;
    public $dataCountCancelSpk;
    public $dataCountCompleteSpk;
    public $dataCountAllSpk;    

    protected $listeners = ['indexRender' => '$refresh'];
    
    public function render()
    {
        $this->dataCountNewSpk = WorkStep::where('work_step_list_id', 1)
                ->where('state_task', 'Running')
                ->where('status_task', 'Process')
                ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Training Program'])
                ->whereIn('status_id', [1, 2])
                ->whereHas('instruction', function ($query) {
                    $query->where('group_priority', '!=', 'child')
                         ->orWhereNull('group_priority');
                })->orderBy('shipping_date', 'asc')
                ->with(['status', 'job', 'workStepList', 'instruction'])
                ->count();

        $this->dataCountRejectSpk = WorkStep::where('work_step_list_id', 1)
                ->where('state_task', 'Running')
                ->whereIn('status_task', ['Reject', 'Reject Requirements'])
                ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Training Program'])
                ->whereIn('status_id', [3, 22])
                ->whereHas('instruction', function ($query) {
                    $query->where('group_priority', '!=', 'child')
                         ->orWhereNull('group_priority');
                })->orderBy('shipping_date', 'asc')
                ->with(['status', 'job', 'workStepList', 'instruction'])
                ->count();

        $this->dataCountRunningSpk = WorkStep::where('work_step_list_id', 1)
                ->where('state_task', 'Running')
                ->where('status_task', 'Process')
                ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Training Program'])
                ->whereIn('status_id', [1, 2, 23])
                ->whereHas('instruction', function ($query) {
                    $query->where('group_priority', '!=', 'child')
                         ->orWhereNull('group_priority');
                })->orderBy('shipping_date', 'asc')
                ->with(['status', 'job', 'workStepList', 'instruction'])
                ->count();

        $this->dataCountHoldSpk = WorkStep::where('work_step_list_id', 1)
                ->whereIn('spk_status', ['Hold', 'Hold Waiting Qty QC', 'Hold RAB', 'Hold Qc', 'Failed Waiting Qty QC'])
                ->whereHas('instruction', function ($query) {
                    $query->where('group_priority', '!=', 'child')
                         ->orWhereNull('group_priority');
                })->orderBy('shipping_date', 'asc')
                ->with(['status', 'job', 'workStepList', 'instruction'])
                ->count();

        $this->dataCountCancelSpk = WorkStep::where('work_step_list_id', 1)
                ->where('spk_status', 'Cancel')
                ->whereHas('instruction', function ($query) {
                    $query->where('group_priority', '!=', 'child')
                         ->orWhereNull('group_priority');
                })->orderBy('shipping_date', 'asc')
                ->with(['status', 'job', 'workStepList', 'instruction'])
                ->count();

        $this->dataCountCompleteSpk = WorkStep::where('work_step_list_id', 1)
                ->where('spk_status', 'Selesai')
                ->whereHas('instruction', function ($query) {
                    $query->where('group_priority', '!=', 'child')
                         ->orWhereNull('group_priority');
                })->orderBy('shipping_date', 'asc')
                ->with(['status', 'job', 'workStepList', 'instruction'])
                ->count();

        $this->dataCountAllSpk = WorkStep::where('work_step_list_id', 1)
                ->whereNotIn('spk_status', ['Selesai', 'Training Program'])
                ->whereHas('instruction', function ($query) {
                    $query->where('group_priority', '!=', 'child')
                         ->orWhereNull('group_priority');
                })->orderBy('shipping_date', 'asc')
                ->with(['status', 'job', 'workStepList', 'instruction'])
                ->count();

        

        return view('livewire.follow-up.component.tab-dashboard-index')

        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Dashboard']);
    }
}

