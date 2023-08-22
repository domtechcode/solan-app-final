<?php

namespace App\Http\Livewire\Purchase\Component;

use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;
use App\Models\PengajuanBarangSpk;
use App\Models\FormPengajuanMaklun;
use App\Models\PengajuanBarangPersonal;

class TabDashboardIndex extends Component
{
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

    public function mount()
    {
        $this->dataCountNewPengajuanBarangSpk = PengajuanBarangSpk::where('status_id', 8)
            ->where('state', 'Purchase')
            ->count();

        $this->dataCountProcessPengajuanBarangSpk = PengajuanBarangSpk::whereIn('status_id', [9, 10, 11])->count();

        $this->dataCountRejectPengajuanBarangSpk = PengajuanBarangSpk::whereIn('status_id', [17, 18])->count();
        $this->dataCountApprovedPengajuanBarangSpk = PengajuanBarangSpk::whereIn('status_id', [13, 14])
            ->where('state', 'Purchase')
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

        $this->dataCountNewPengajuanBarangPersonal = PengajuanBarangPersonal::where('status_id', 8)
            ->where('state', 'Purchase')
            ->count();

        $this->dataCountProcessPengajuanBarangPersonal = PengajuanBarangPersonal::whereIn('status_id', [9, 10, 11])
            ->where('state', 'Purchase')
            ->count();

        $this->dataCountRejectPengajuanBarangPersonal = PengajuanBarangPersonal::whereIn('status_id', [17, 18])
            ->where('state', 'Purchase')
            ->count();
        $this->dataCountApprovedPengajuanBarangPersonal = PengajuanBarangPersonal::whereIn('status_id', [13, 14])
            ->where('state', 'Purchase')
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

        $this->dataCountNewPengajuanMaklun = FormPengajuanMaklun::where('status', 'Pengajuan Purchase')
            ->where('pekerjaan', 'Purchase')
            ->count();

        $this->dataCountProcessPengajuanMaklun = FormPengajuanMaklun::whereIn('status', ['Pengajuan Accounting', 'Pengajuan RAB'])
            ->where('pekerjaan', 'Purchase')
            ->count();

        $this->dataCountRejectPengajuanMaklun = FormPengajuanMaklun::whereIn('status', ['Reject Accounting', 'Reject RAB'])
            ->where('pekerjaan', 'Purchase')
            ->count();

        $this->dataCountApprovedPengajuanMaklun = FormPengajuanMaklun::whereIn('status', ['Approve Accounting', 'Approve RAB'])
            ->where('pekerjaan', 'Purchase')
            ->count();

        $this->dataCountCompletePengajuanMaklun = FormPengajuanMaklun::where('status', 'Complete')
            ->where('pekerjaan', 'Purchase')
            ->count();

        $this->dataCountTotalPengajuanMaklun = $this->dataCountNewPengajuanMaklun + $this->dataCountProcessPengajuanMaklun + $this->dataCountRejectPengajuanMaklun + $this->dataCountApprovedPengajuanMaklun + $this->dataCountCompletePengajuanMaklun;
    }

    public function render()
    {
        return view('livewire.purchase.component.tab-dashboard-index')
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }
}
