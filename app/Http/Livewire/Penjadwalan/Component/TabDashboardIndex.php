<?php

namespace App\Http\Livewire\Penjadwalan\Component;

use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use App\Models\WorkStepList;
use Livewire\WithPagination;
use App\Models\PengajuanBarangSpk;
use App\Models\PengajuanKekuranganQc;
use App\Models\PengajuanBarangPersonal;

class TabDashboardIndex extends Component
{
    public $dataCountNewSpk;
    public $dataCountRunningSpk;
    public $dataCountIncomingSpk;
    public $dataCountReady;
    public $dataCountComplete;
    public $dataCountReject;
    public $dataCountManageSpk;
    public $dataCountPengajuanBarangPersonal;
    public $dataCountRejectPengajuanBarangPersonal;
    public $dataCountPengajuanBarangSpk;
    public $dataCountRejectPengajuanBarangSpk;
    public $dataCountTotalPengajuanBarang;
    public $dataCountTotalPengajuanKekuranganQc;

    public $workStepList;

    public $dataCountLateScheduleSpk;
    public $dataCountLateDeliverySpk;

    protected $listeners = ['indexRender' => 'mount'];

    public $activeTab = 'tab1';

    public function changeTab($tab)
    {
        $this->activeTab = $tab;
    }

    public $activeTabSpk = 'tabSpk1';

    public function changeTabSpk($tabSpk)
    {
        $this->activeTabSpk = $tabSpk;
    }

    public $activeTabOperator = 'tabOperator1';

    public function changeTabOperator($tabOperator)
    {
        $this->activeTabOperator = $tabOperator;
    }

    public $activeTabPengajuanBarang = 'tabPengajuanBarangPersonal1';

    public function changeTabPengajuanBarangPersonal($tabPengajuanBarang)
    {
        $this->activeTabPengajuanBarang = $tabPengajuanBarang;
    }

    public function mount()
    {
        $this->dataCountNewSpk = WorkStep::where('work_step_list_id', 2)
            ->where('state_task', 'Running')
            ->whereIn('status_task', ['Pending Approved'])
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Close PO', 'Training Program'])
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
            ->whereNotIn('status_id', [3, 7, 21, 22, 26])
            ->where('job_id', '!=', 2)
            ->whereIn('status_task', ['Process', 'Reject', 'Reject Requirements'])
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Close PO', 'Training Program'])
            ->whereHas('instruction', function ($query) {
                $query->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
            })
            ->orderBy('shipping_date', 'asc')
            ->with(['status', 'job', 'workStepList', 'instruction'])
            ->count();

        $this->dataCountReady = WorkStep::where('work_step_list_id', 2)
            ->where('state_task', 'Running')
            ->where('status_id', 2)
            ->where('job_id', 2)
            ->whereIn('status_task', ['Process', 'Reject', 'Reject Requirements'])
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Close PO', 'Training Program'])
            ->whereHas('instruction', function ($query) {
                $query->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
            })
            ->orderBy('shipping_date', 'asc')
            ->with(['status', 'job', 'workStepList', 'instruction'])
            ->count();

        $this->dataCountComplete = WorkStep::where('work_step_list_id', 2)
            ->where('state_task', 'Running')
            ->where('status_id', 7)
            ->whereIn('status_task', ['Process', 'Reject', 'Reject Requirements'])
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Close PO', 'Training Program'])
            ->whereHas('instruction', function ($query) {
                $query->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
            })
            ->orderBy('shipping_date', 'asc')
            ->with(['status', 'job', 'workStepList', 'instruction'])
            ->count();

        $this->dataCountReject = WorkStep::where('work_step_list_id', 2)
            ->where('state_task', 'Running')
            ->whereIn('status_id', [3, 21, 22, 26])
            ->whereIn('status_task', ['Process', 'Reject', 'Reject Requirements'])
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Close PO', 'Training Program'])
            ->whereHas('instruction', function ($query) {
                $query->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
            })
            ->orderBy('shipping_date', 'asc')
            ->with(['status', 'job', 'workStepList', 'instruction'])
            ->count();

        $this->dataCountManageSpk = $this->dataCountNewSpk + $this->dataCountRunningSpk + $this->dataCountReady + $this->dataCountComplete + $this->dataCountReject;

        $this->dataCountIncomingSpk = WorkStep::where('work_step_list_id', 2)
            ->where('state_task', 'Not Running')
            ->where('spk_status', 'Running')
            ->whereHas('instruction', function ($query) {
                $query->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
            })
            ->orderBy('shipping_date', 'asc')
            ->with(['status', 'job', 'workStepList', 'instruction'])
            ->count();

        $this->dataCountLateScheduleSpk = WorkStep::where('work_step_list_id', 2)
            ->where('spk_status', 'Running')
            ->where('schedule_state', 'Late By Schedule')
            ->whereHas('instruction', function ($query) {
                $query->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
            })
            ->orderBy('shipping_date', 'asc')
            ->with(['status', 'job', 'workStepList', 'instruction'])
            ->count();

        $this->dataCountLateDeliverySpk = WorkStep::where('work_step_list_id', 2)
            ->where('spk_status', 'Running')
            ->where('delivery_state', 'Late By Delivery')
            ->whereHas('instruction', function ($query) {
                $query->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
            })
            ->orderBy('shipping_date', 'asc')
            ->with(['status', 'job', 'workStepList', 'instruction'])
            ->count();

        $this->dataCountPengajuanBarangPersonal = PengajuanBarangPersonal::where('user_id', Auth()->user()->id)->count();
        $this->dataCountRejectPengajuanBarangPersonal = PengajuanBarangPersonal::where('user_id', Auth()->user()->id)
            ->where('status_id', 3)
            ->count();
        $this->dataCountPengajuanBarangSpk = PengajuanBarangSpk::where('user_id', Auth()->user()->id)->count();
        $this->dataCountRejectPengajuanBarangSpk = PengajuanBarangSpk::where('user_id', Auth()->user()->id)
            ->where('status_id', 3)
            ->count();
        $this->dataCountTotalPengajuanBarang = $this->dataCountPengajuanBarangPersonal + $this->dataCountPengajuanBarangSpk;

        $this->dataCountTotalPengajuanKekuranganQc = PengajuanKekuranganQc::where('status', 'Pending')->count();

        $this->workStepList = WorkStepList::whereNotIn('id', [1, 2, 3, 4, 5])
            ->orderBy('no_urut', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.penjadwalan.component.tab-dashboard-index')
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }
}
