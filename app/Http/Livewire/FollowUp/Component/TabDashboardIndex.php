<?php

namespace App\Http\Livewire\FollowUp\Component;

use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;
use App\Models\PengajuanKekuranganQc;
use App\Models\PengajuanBarangPersonal;

class TabDashboardIndex extends Component
{
    public $dataCountSpk;
    public $dataCountNewSpk;
    public $dataCountRejectSpk;
    public $dataCountHoldSpk;
    public $dataCountCancelSpk;
    public $dataCountCompleteSpk;
    public $dataCountAccSpk;
    public $dataCountAllSpk;
    public $dataCountPengajuanBarangPersonal;
    public $dataCountTotalPengajuanKekuranganQc;
    

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

    public $activeTabPengajuanBarangPersonal = 'tabPengajuanBarangPersonal1';

    public function changeTabPengajuanBarangPersonal($tabPengajuanBarangPersonal)
    {
        $this->activeTabPengajuanBarangPersonal = $tabPengajuanBarangPersonal;
    }

    public function mount()
    {
        $this->dataCountNewSpk = WorkStep::where('work_step_list_id', 1)
            ->where('state_task', 'Running')
            ->where('status_task', 'Process')
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Close PO', 'Training Program'])
            ->count();

        $this->dataCountRejectSpk = WorkStep::where('work_step_list_id', 1)
            ->where('state_task', 'Running')
            ->whereIn('status_task', ['Reject', 'Reject Requirements'])
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Close PO', 'Training Program'])
            ->whereIn('status_id', [3, 22])
            ->count();

        $this->dataCountHoldSpk = WorkStep::where('work_step_list_id', 1)
            ->whereIn('spk_status', ['Hold', 'Hold Waiting Qty QC', 'Hold RAB', 'Hold Qc', 'Failed Waiting Qty QC'])
            ->count();

        $this->dataCountCancelSpk = WorkStep::where('work_step_list_id', 1)
            ->where('spk_status', 'Cancel')
            ->count();

        $this->dataCountCompleteSpk = WorkStep::where('work_step_list_id', 1)
            ->where('spk_status', 'Selesai')
            ->count();

        $this->dataCountAllSpk = WorkStep::where('work_step_list_id', 1)
            ->whereNotIn('spk_status', ['Training Program'])
            ->with(['status', 'job', 'workStepList', 'instruction'])
            ->count();

        $this->dataCountAccSpk = WorkStep::where('work_step_list_id', 1)
            ->where('spk_status', 'Acc')
            ->count();

        $this->dataCountPengajuanBarangPersonal = PengajuanBarangPersonal::where('user_id', Auth()->user()->id)->count();

        $this->dataCountSpk = $this->dataCountNewSpk + $this->dataCountCompleteSpk + $this->dataCountAccSpk;
        $this->dataCountTotalPengajuanKekuranganQc = PengajuanKekuranganQc::where('status', 'Approved')->count();
    }

    public function render()
    {
        return view('livewire.follow-up.component.tab-dashboard-index')
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }
}
