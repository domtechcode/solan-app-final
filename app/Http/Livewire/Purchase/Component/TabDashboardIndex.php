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
    public $dataCountPengajuanBarangSpk;
    public $dataCountPengajuanBarangPersonal;
    public $dataCountPengajuanMaklun;
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
        $this->dataCountPengajuanBarangSpk = PengajuanBarangSpk::where('status_id', '!=', 16)->count();
        $this->dataCountPengajuanBarangPersonal = PengajuanBarangPersonal::where('status_id', '!=', 16)->count();

        $this->dataCountPengajuanMaklun = FormPengajuanMaklun::where('pekerjaan', 'Purchase')->count();

        return view('livewire.purchase.component.tab-dashboard-index')
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }
}
