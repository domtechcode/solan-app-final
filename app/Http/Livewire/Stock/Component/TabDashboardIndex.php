<?php

namespace App\Http\Livewire\Stock\Component;

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

    public $activeTab = 'tab1';

    public function changeTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        $this->dataCountNewSpk = WorkStep::where('work_step_list_id', 4)
            ->where('state_task', 'Running')
            ->whereIn('status_task', ['Pending Approved', 'Process'])
            ->where('spk_status', 'Running')
            ->whereIn('status_id', [1, 2])
            ->join('instructions', 'work_steps.instruction_id', '=', 'instructions.id')
            ->select('work_steps.*')
            ->with(['status', 'job', 'workStepList', 'instruction'])
            ->orderBy('instructions.shipping_date', 'asc')
            ->count();

        return view('livewire.stock.component.tab-dashboard-index')
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }
}
