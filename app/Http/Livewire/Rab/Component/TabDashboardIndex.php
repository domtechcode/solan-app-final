<?php

namespace App\Http\Livewire\Rab\Component;

use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;

class TabDashboardIndex extends Component
{
    public $dataCountNewSpk;
    public $dataCountRejectSpk;
    public $dataCountIncomingSpk;
    public $dataCountHoldSpk;
    public $dataCountAllSpk;

    protected $listeners = ['indexRender' => 'renderIndex'];

    public function renderIndex()
    {
        $this->render();
    }
    
    public function render()
    {
        $this->dataCountNewSpk = WorkStep::where('work_step_list_id', 3)
                ->where('state_task', 'Running')
                ->whereIn('status_task', ['Pending Approved', 'Process', 'Revisi Qty'])
                ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Deleted', 'Training Program'])
                ->where(function ($query) {
                $query->where(function ($subQuery) {
                        $subQuery->whereIn('status_id', [1, 26]);
                })->orWhere(function ($subQuery) {
                        $subQuery->where('status_id', 2)
                        ->where('user_id', Auth()->user()->id);
                });
                })
                ->whereHas('instruction', function ($query) {
                    $query->where('group_priority', '!=', 'child')
                         ->orWhereNull('group_priority');
                })->orderBy('shipping_date', 'asc')
                ->with(['status', 'job', 'workStepList', 'instruction'])
                ->count();

        $this->dataCountRejectSpk = WorkStep::where('work_step_list_id', 3)
                ->where('state_task', 'Running')
                ->whereIn('status_task', ['Reject', 'Reject Requirements'])
                ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Deleted', 'Training Program'])
                ->whereIn('status_id', [3, 22])
                ->whereHas('instruction', function ($query) {
                    $query->where('group_priority', '!=', 'child')
                         ->orWhereNull('group_priority');
                })->orderBy('shipping_date', 'asc')
                ->with(['status', 'job', 'workStepList', 'instruction'])
                ->count();

        $this->dataCountIncomingSpk = WorkStep::where('work_step_list_id', 3)
                ->where('state_task', 'Not Running')
                ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Deleted', 'Training Program'])
                ->whereHas('instruction', function ($query) {
                    $query->where('group_priority', '!=', 'child')
                         ->orWhereNull('group_priority');
                })->orderBy('shipping_date', 'asc')
                ->with(['status', 'job', 'workStepList', 'instruction'])
                ->count();

        $this->dataCountHoldSpk = WorkStep::where('work_step_list_id', 3)
                ->whereIn('spk_status', ['Hold', 'Hold Waiting Qty QC', 'Hold RAB'])
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

        

        return view('livewire.rab.component.tab-dashboard-index')

        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Dashboard']);
    }
}

