<?php

namespace App\Http\Livewire\Accounting\Component;

use App\Models\Files;
use App\Models\FormRab;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;
use App\Models\PengajuanBarangSpk;
use App\Models\FormPengajuanMaklun;
use App\Models\PengajuanBarangPersonal;

class TabDashboardIndex extends Component
{
    public $dataCountNewSpkRab;
    public $dataCountCompleteSpkRab;
    public $dataCountTotalSpkRab;

    public $dataCountTotalPengajuanBarangSpk;

    public $dataCountNewPengajuanBarangSpk;
    public $dataCountProcessPengajuanBarangSpk;
    public $dataCountRejectPengajuanBarangSpk;
    public $dataCountStockPengajuanBarangSpk;
    public $dataCountApprovedPengajuanBarangSpk;
    public $dataCountBeliPengajuanBarangSpk;
    public $dataCountCompletePengajuanBarangSpk;

    public $dataCountTotalPengajuanBarangPersonal;

    public $dataCountNewPengajuanBarangPersonal;
    public $dataCountProcessPengajuanBarangPersonal;
    public $dataCountRejectPengajuanBarangPersonal;
    public $dataCountStockPengajuanBarangPersonal;
    public $dataCountApprovedPengajuanBarangPersonal;
    public $dataCountBeliPengajuanBarangPersonal;
    public $dataCountCompletePengajuanBarangPersonal;

    public $dataCountTotalPengajuanMaklun;

    public $dataCountNewPengajuanMaklun;
    public $dataCountProcessPengajuanMaklun;
    public $dataCountRejectPengajuanMaklun;
    public $dataCountApprovedPengajuanMaklun;
    public $dataCountCompletePengajuanMaklun;

    protected $listeners = ['indexRender' => 'mount'];

    public $activeTab = 'tab1';

    public function changeTab($tab)
    {
        $this->activeTab = $tab;
    }

    public $activeTabPengajuanBarangSpk = 'tabPengajuanBarangSpk1';

    public function changeTabPengajuanBarangSpk($tabPengajuanBarangSpk)
    {
        $this->activeTabPengajuanBarangSpk = $tabPengajuanBarangSpk;
    }

    public $activeTabPengajuanBarangPersonal = 'tabPengajuanBarangPersonal1';

    public function changeTabPengajuanBarangPersonal($tabPengajuanBarangPersonal)
    {
        $this->activeTabPengajuanBarangPersonal = $tabPengajuanBarangPersonal;
    }

    public $activeTabPengajuanMaklun = 'tabPengajuanMaklun1';

    public function changeTabPengajuanMaklun($tabPengajuanMaklun)
    {
        $this->activeTabPengajuanMaklun = $tabPengajuanMaklun;
    }

    public $activeTabRabSpk = 'tabRabSpk1';

    public function changeTabRabSpk($tabRabSpk)
    {
        $this->activeTabRabSpk = $tabRabSpk;
    }

    public function mount()
    {
        $this->dataCountNewSpkRab = WorkStep::where('work_step_list_id', 3)
            ->where('state_task', 'Complete')
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Training Program'])
            ->whereHas('instruction.formRab', function ($query) {
                $query->where('real', null);
            })
            ->count();

        $this->dataCountCompleteSpkRab = WorkStep::where('work_step_list_id', 3)
            ->where('state_task', 'Complete')
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Training Program'])
            ->whereHas('instruction.formRab', function ($query) {
                $query->where('real', '!=', null);
            })
            ->count();

        $this->dataCountTotalSpkRab = $this->dataCountNewSpkRab + $this->dataCountCompleteSpkRab;

        $this->dataCountNewPengajuanBarangSpk = PengajuanBarangSpk::where('status_id', 10)
            ->where('state', 'Accounting')
            ->count();

        $this->dataCountProcessPengajuanBarangSpk = PengajuanBarangSpk::whereIn('status_id', [11])->count();

        $this->dataCountRejectPengajuanBarangSpk = PengajuanBarangSpk::whereIn('status_id', [17])
            ->where('state', 'Accounting')
            ->count();

        $this->dataCountApprovedPengajuanBarangSpk = PengajuanBarangSpk::whereIn('status_id', [14])
            ->where('state', 'Accounting')
            ->count();

        $this->dataCountStockPengajuanBarangSpk = PengajuanBarangSpk::where('status_id', 12)
            ->where('state', 'Purchase')
            ->count();

        $this->dataCountBeliPengajuanBarangSpk = PengajuanBarangSpk::where('status_id', 15)
            ->where('state', 'Purchase')
            ->count();

        $this->dataCountCompletePengajuanBarangSpk = PengajuanBarangSpk::where('status_id', 16)
            ->where('state', 'Purchase')
            ->count();

        $this->dataCountTotalPengajuanBarangSpk = $this->dataCountNewPengajuanBarangSpk + $this->dataCountProcessPengajuanBarangSpk + $this->dataCountRejectPengajuanBarangSpk + $this->dataCountApprovedPengajuanBarangSpk + $this->dataCountStockPengajuanBarangSpk + $this->dataCountBeliPengajuanBarangSpk + $this->dataCountCompletePengajuanBarangSpk;

        $this->dataCountNewPengajuanBarangPersonal = PengajuanBarangPersonal::where('status_id', 10)
            ->where('state', 'Accounting')
            ->count();

        $this->dataCountProcessPengajuanBarangPersonal = PengajuanBarangPersonal::whereIn('status_id', [11])->count();

        $this->dataCountRejectPengajuanBarangPersonal = PengajuanBarangPersonal::whereIn('status_id', [17])
            ->where('state', 'Accounting')
            ->count();

        $this->dataCountApprovedPengajuanBarangPersonal = PengajuanBarangPersonal::whereIn('status_id', [14])
            ->where('state', 'Accounting')
            ->count();

        $this->dataCountStockPengajuanBarangPersonal = PengajuanBarangPersonal::where('status_id', 12)
            ->where('state', 'Purchase')
            ->count();

        $this->dataCountBeliPengajuanBarangPersonal = PengajuanBarangPersonal::where('status_id', 15)
            ->where('state', 'Purchase')
            ->count();

        $this->dataCountCompletePengajuanBarangPersonal = PengajuanBarangPersonal::where('status_id', 16)
            ->where('state', 'Purchase')
            ->count();

        $this->dataCountTotalPengajuanBarangPersonal = $this->dataCountNewPengajuanBarangPersonal + $this->dataCountProcessPengajuanBarangPersonal + $this->dataCountRejectPengajuanBarangPersonal + $this->dataCountApprovedPengajuanBarangPersonal + $this->dataCountStockPengajuanBarangPersonal + $this->dataCountBeliPengajuanBarangPersonal + $this->dataCountCompletePengajuanBarangPersonal;

        $this->dataCountNewPengajuanMaklun = FormPengajuanMaklun::where('status', 'Pengajuan Accounting')
            ->where('pekerjaan', 'Accounting')
            ->count();

        $this->dataCountProcessPengajuanMaklun = FormPengajuanMaklun::whereIn('status', ['Pengajuan RAB'])->count();

        $this->dataCountRejectPengajuanMaklun = FormPengajuanMaklun::whereIn('status', ['Reject RAB'])
            ->where('pekerjaan', 'Accounting')
            ->count();

        $this->dataCountApprovedPengajuanMaklun = FormPengajuanMaklun::whereIn('status', ['Approve RAB'])
            ->where('pekerjaan', 'Accounting')
            ->count();

        $this->dataCountCompletePengajuanMaklun = FormPengajuanMaklun::where('status', 'Complete')
            ->where('pekerjaan', 'Purchase')
            ->count();

        $this->dataCountTotalPengajuanMaklun = $this->dataCountNewPengajuanMaklun + $this->dataCountProcessPengajuanMaklun + $this->dataCountRejectPengajuanMaklun + $this->dataCountApprovedPengajuanMaklun + $this->dataCountCompletePengajuanMaklun;
    }

    public function render()
    {
        return view('livewire.accounting.component.tab-dashboard-index')
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }
}
