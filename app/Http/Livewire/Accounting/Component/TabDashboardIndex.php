<?php

namespace App\Http\Livewire\Accounting\Component;

use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;
use App\Models\PengajuanBarangSpk;
use App\Models\FormPengajuanMaklun;

class TabDashboardIndex extends Component
{
    public $dataCountNewSpkRab;
    public $dataCountCompleteSpkRab;
    public $dataCountPengajuanBarangSpk;
    public $dataCountPengajuanMaklun;

    protected $listeners = ['indexRender' => '$refresh'];
    
    public $activeTab = 'tab1';

    public function changeTab($tab)
    {
        $this->activeTab = $tab;
    }
    
    public function render()
    {
        $this->dataCountNewSpkRab = WorkStep::where('work_step_list_id', 3)
                ->where('state_task', 'Complete')
                ->where('status_task', 'Complete')
                ->where('user_id', '!=', null)
                ->count();

        $this->dataCountCompleteSpkRab = WorkStep::where('work_step_list_id', 3)
                ->where('state_task', 'Complete Accounting')
                ->where('status_task', 'Complete')
                ->where('user_id', '!=', null)
                ->count();

        $this->dataCountPengajuanBarangSpk = PengajuanBarangSpk::where('state', 'Accounting')->count();

        $this->dataCountPengajuanMaklun = FormPengajuanMaklun::where('pekerjaan', 'Accounting')->count();

        return view('livewire.accounting.component.tab-dashboard-index')

        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Dashboard']);
    }
}

