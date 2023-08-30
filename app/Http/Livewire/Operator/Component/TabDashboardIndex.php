<?php

namespace App\Http\Livewire\Operator\Component;

use Carbon\Carbon;
use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\WarnaPlate;
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

    public $dataCountPengembalianPlate;
    public $dataCountPengajuanPlate;
    public $dataCountTotalPlate;

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

    public $activeTabPlate = 'tabPlate1';

    public function changeTabPlate($tabPlate)
    {
        $this->activeTabPlate = $tabPlate;
    }

    public function mount()
    {
        $today = Carbon::today();
        $formattedToday = $today->format('Y-m-d');

        if (Auth()->user()->jobdesk == 'Pengiriman' || Auth()->user()->jobdesk == 'Team Qc Packing') {
            $this->dataCountNewSpk = WorkStep::where('user_id', Auth()->user()->id)
                ->where('state_task', 'Running')
                ->whereIn('status_task', ['Pending Approved', 'Process', 'Reject Requirements'])
                ->where('spk_status', 'Running')
                ->where('schedule_date', '<=', $formattedToday)
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
            if (Auth()->user()->jobdesk == 'Checker') {
                $this->dataCountNewSpk = $dataNewSpk = WorkStep::where('user_id', Auth()->user()->id)
                    ->where('state_task', 'Running')
                    ->whereIn('status_task', ['Pending Approved', 'Process', 'Reject Requirements'])
                    ->where('spk_status', 'Running')
                    ->where('schedule_date', '<=', $formattedToday)
                    ->where(function ($query) {
                        $query
                            ->where(function ($subQuery) {
                                $subQuery->whereIn('status_id', [1, 3, 22]);
                            })
                            ->orWhere(function ($subQuery) {
                                $subQuery->whereIn('status_id', [2])->where('user_id', Auth()->user()->id);
                            });
                    })
                    ->whereHas('instruction', function ($query) {
                        $query->where(function ($subQuery) {
                            $subQuery
                                ->where(function ($nestedSubQuery) {
                                    $nestedSubQuery->whereIn('work_step_list_id', [35, 36])->orWhereNull('group_priority');
                                })
                                ->orWhere('group_priority', 'parent');
                        });
                    })
                    ->with(['status', 'job', 'workStepList', 'instruction'])
                    ->count();
            } else {
                $this->dataCountNewSpk = $dataNewSpk = WorkStep::where('user_id', Auth()->user()->id)
                    ->where('state_task', 'Running')
                    ->whereIn('status_task', ['Pending Approved', 'Process', 'Reject Requirements'])
                    ->where('spk_status', 'Running')
                    ->where('schedule_date', '<=', $formattedToday)
                    ->whereHas('instruction', function ($query) {
                        $query->where(function ($subQuery) {
                            $subQuery
                                ->where(function ($nestedSubQuery) {
                                    $nestedSubQuery->whereIn('work_step_list_id', [35, 36])->orWhereNull('group_priority');
                                })
                                ->orWhere('group_priority', 'parent');
                        });
                    })
                    ->with(['status', 'job', 'workStepList', 'instruction'])
                    ->count();
            }

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

        $this->dataCountPengembalianPlate = WarnaPlate::whereHas('rincianPlate', function ($query) {
            $query->where('status', 'Pengembalian Plate');
        })->count();

        $this->dataCountTotalPlate = $this->dataCountPengembalianPlate + $this->dataCountPengajuanPlate;
    }

    public function render()
    {
        return view('livewire.operator.component.tab-dashboard-index')
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }
}
