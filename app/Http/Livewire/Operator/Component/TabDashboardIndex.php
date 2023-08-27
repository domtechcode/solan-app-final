<?php

namespace App\Http\Livewire\Operator\Component;

use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;
use App\Models\PengajuanBarangSpk;
use App\Models\PengajuanBarangPersonal;

class TabDashboardIndex extends Component
{
    public $dataCountNewSpk;
    public $dataCountIncomingSpk;
    public $dataCountCompleteChecker;
    public $dataCountCompleteCustomerChecker;
    public $dataCountSelesai;
    public $dataCountPengajuanBarangPersonal;
    public $dataCountPengajuanBarangSpk;
    public $dataCountTotalPengajuanBarang;

    protected $listeners = ['indexRender' => 'mount'];

    public $activeTab = 'tab1';

    public function changeTab($tab)
    {
        $this->activeTab = $tab;
    }

    public $activeTabPengajuanBarang = 'tabPengajuanBarangPersonal1';

    public function changeTabPengajuanBarangPersonal($tabPengajuanBarang)
    {
        $this->activeTabPengajuanBarang = $tabPengajuanBarang;
    }

    public function mount()
    {
        if (Auth()->user()->jobdesk == 'Pengiriman' || Auth()->user()->jobdesk == 'Team Qc Packing') {
            $this->dataCountNewSpk = WorkStep::where('user_id', Auth()->user()->id)
                ->where('state_task', 'Running')
                ->whereIn('status_task', ['Pending Approved', 'Process', 'Reject Requirements'])
                ->where('spk_status', 'Running')
                ->orderBy('shipping_date', 'asc')
                ->with(['status', 'job', 'workStepList', 'instruction'])
                ->count();

            $this->dataCountIncomingSpk = WorkStep::where('user_id', Auth()->user()->id)
                ->where('state_task', 'Not Running')
                ->whereIn('status_task', ['Waiting'])
                ->where('spk_status', 'Running')
                ->orderBy('shipping_date', 'asc')
                ->with(['status', 'job', 'workStepList', 'instruction'])
                ->count();

            $this->dataCountSelesai = WorkStep::where('user_id', Auth()->user()->id)
                ->where('state_task', 'Complete')
                ->where('status_task', 'Complete')
                ->whereNotIn('spk_status', ['Training Program'])
                ->orderBy('shipping_date', 'asc')
                ->with(['status', 'job', 'workStepList', 'instruction'])
                ->count();
        } else {
            $this->dataCountNewSpk = WorkStep::where('user_id', Auth()->user()->id)
                ->where('state_task', 'Running')
                ->whereIn('status_task', ['Pending Approved', 'Process', 'Reject Requirements'])
                ->where('spk_status', 'Running')
                ->whereHas('instruction', function ($query) {
                    $query->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
                })
                ->orderBy('shipping_date', 'asc')
                ->with(['status', 'job', 'workStepList', 'instruction'])
                ->count();

            $this->dataCountIncomingSpk = WorkStep::where('user_id', Auth()->user()->id)
                ->where('state_task', 'Not Running')
                ->whereIn('status_task', ['Waiting'])
                ->where('spk_status', 'Running')
                ->whereHas('instruction', function ($query) {
                    $query->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
                })
                ->orderBy('shipping_date', 'asc')
                ->with(['status', 'job', 'workStepList', 'instruction'])
                ->count();

            $this->dataCountSelesai = WorkStep::where('user_id', Auth()->user()->id)
                ->where('state_task', 'Complete')
                ->where('status_task', 'Complete')
                ->whereNotIn('spk_status', ['Training Program'])
                ->whereHas('instruction', function ($query) {
                    $query->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
                })
                ->orderBy('shipping_date', 'asc')
                ->with(['status', 'job', 'workStepList', 'instruction'])
                ->count();
        }

        if (Auth()->user()->jobdesk == 'Checker') {
            $this->dataCountCompleteChecker = WorkStep::where('user_id', Auth()->user()->id)
                ->where('state_task', 'Complete')
                ->whereIn('status_task', ['Complete'])
                ->whereIn('spk_status', ['Running', 'Selesai'])
                ->whereHas('instruction', function ($query) {
                    $query->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
                })
                ->orderBy('shipping_date', 'asc')
                ->with(['status', 'job', 'workStepList', 'instruction'])
                ->count();

            $this->dataCountCompleteCustomerChecker = WorkStep::where('user_id', Auth()->user()->id)
                ->whereIn('spk_status', ['Acc'])
                ->whereHas('instruction', function ($query) {
                    $query->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
                })
                ->orderBy('shipping_date', 'asc')
                ->with(['status', 'job', 'workStepList', 'instruction'])
                ->count();

            $this->dataCountSelesai = WorkStep::where('user_id', Auth()->user()->id)
                ->where('state_task', 'Complete')
                ->where('status_task', 'Complete')
                ->whereNotIn('spk_status', ['Training Program'])
                ->whereHas('instruction', function ($query) {
                    $query->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
                })
                ->orderBy('shipping_date', 'asc')
                ->with(['status', 'job', 'workStepList', 'instruction'])
                ->count();
        }

        $this->dataCountPengajuanBarangPersonal = PengajuanBarangPersonal::where('user_id', Auth()->user()->id)->count();
        $this->dataCountPengajuanBarangSpk = PengajuanBarangSpk::where('user_id', Auth()->user()->id)->count();
        $this->dataCountTotalPengajuanBarang = $this->dataCountPengajuanBarangPersonal + $this->dataCountPengajuanBarangSpk;
    }

    public function render()
    {
        return view('livewire.operator.component.tab-dashboard-index')
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }
}
