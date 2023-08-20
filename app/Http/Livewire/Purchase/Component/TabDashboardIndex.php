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

    public $dataCountPengajuanBarangPersonal;
    public $dataCountPengajuanMaklun;

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

    public function mount()
    {
        $this->dataCountNewPengajuanBarangSpk = PengajuanBarangSpk::where('status_id', 8)
            ->where('state', 'Purchase')
            ->count();

        $this->dataCountProcessPengajuanBarangSpk = PengajuanBarangSpk::whereIn('status_id', [9, 10, 11])->count();

        $this->dataCountRejectPengajuanBarangSpk = PengajuanBarangSpk::whereIn('status_id', [17, 18])->count();
        $this->dataCountApprovedPengajuanBarangSpk = PengajuanBarangSpk::whereIn('status_id', [13, 14])
            ->where('state', 'purchase')
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

        $this->dataCountPengajuanBarangPersonal = PengajuanBarangPersonal::where('status_id', '!=', 16)->count();

        $this->dataCountPengajuanMaklun = FormPengajuanMaklun::where('pekerjaan', 'Purchase')->count();
    }

    public function render()
    {
        return view('livewire.purchase.component.tab-dashboard-index')
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }
}
