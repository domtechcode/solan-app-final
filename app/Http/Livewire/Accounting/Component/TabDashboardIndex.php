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
        $this->dataCountNewSpkRab = WorkStep::where('work_step_list_id', 3)
            ->where('state_task', 'Complete')
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Training Program'])
            ->whereHas('instruction.formRab', function ($query) {
                $query->where('real', null);
            })

            ->count();

        $this->dataCountTotalSpkRab = $this->dataCountNewSpkRab;

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

        // $this->dataCountCompleteSpkRab = WorkStep::where('work_step_list_id', 3)
        //     ->where('state_task', 'Complete Accounting')
        //     ->where('status_task', 'Complete')
        //     ->where('user_id', '!=', null)
        //     ->count();

        // $this->dataCountPengajuanBarangSpk = PengajuanBarangSpk::where('state', 'Accounting')->count();

        // $this->dataCountPengajuanBarangPersonal = PengajuanBarangPersonal::where('state', 'Accounting')->count();

        // $this->dataCountPengajuanMaklun = FormPengajuanMaklun::where('pekerjaan', 'Accounting')->count();
    }

    public function render()
    {
        return view('livewire.accounting.component.tab-dashboard-index')
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }
}
