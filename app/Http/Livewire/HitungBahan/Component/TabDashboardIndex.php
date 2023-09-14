<?php

namespace App\Http\Livewire\HitungBahan\Component;

use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use App\Models\LayoutBahan;
use Livewire\WithPagination;
use App\Models\PengajuanBarangSpk;
use App\Models\PengajuanBarangPersonal;

class TabDashboardIndex extends Component
{
    public $dataCountNewSpk;
    public $dataCountProcessSpk;
    public $dataCountRejectSpk;
    public $dataCountIncomingSpk;
    public $dataCountAllSpk;
    public $dataCountAccRabSpk;
    public $dataCountPengajuanBarangPersonal;
    public $dataCountRejectPengajuanBarangPersonal;
    public $dataCountPengajuanBarangSpk;
    public $dataCountRejectPengajuanBarangSpk;
    public $dataCountTotalPengajuanBarang;

    public $dataPengajuanBahan;

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
        $this->dataCountNewSpk = WorkStep::where('work_step_list_id', 5)
            ->where('state_task', 'Running')
            ->whereIn('status_task', ['Pending Approved', 'Process', 'Revisi Qty'])
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Training Program'])
            ->where(function ($query) {
                $query
                    ->where(function ($subQuery) {
                        $subQuery->whereIn('status_id', [1, 3, 26]);
                    })
                    ->orWhere(function ($subQuery) {
                        $subQuery->whereIn('status_id', [2])->where('user_id', Auth()->user()->id);
                    });
            })
            ->whereHas('instruction', function ($query) {
                $query->where(function ($instructionQuery) {
                    $instructionQuery->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
                });
            })
            ->count();

        $this->dataCountAccRabSpk = WorkStep::whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Training Program'])
            ->where(function ($query) {
                $query
                    ->where('user_id', Auth()->user()->id)
                    ->where('state_task', 'Complete')
                    ->where('status_task', 'Complete')
                    ->where(function ($innerQuery) {
                        $innerQuery->where('work_step_list_id', 5)->orWhere(function ($nestedQuery) {
                            $nestedQuery
                                ->where('work_step_list_id', 3)
                                ->where('state_task', 'Complete')
                                ->where('status_task', 'Complete');
                        });
                    });
            })
            // ->whereHas('instruction', function ($query) {
            //     $query->where(function ($instructionQuery) {
            //         $instructionQuery->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
            //     });
            // })
            ->count();

        $this->dataCountProcessSpk = WorkStep::where('work_step_list_id', 5)
            ->where('state_task', 'Running')
            ->whereIn('status_task', ['Process'])
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Training Program'])
            ->where(function ($query) {
                $query
                    ->where(function ($subQuery) {
                        $subQuery->whereIn('status_id', [1, 23]);
                    })
                    ->orWhere(function ($subQuery) {
                        $subQuery->whereIn('status_id', [2])->where('user_id', Auth()->user()->id);
                    });
            })
            ->whereHas('instruction', function ($query) {
                $query->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
            })
            ->orderBy('shipping_date', 'asc')
            ->with(['status', 'job', 'workStepList', 'instruction'])
            ->count();

        $this->dataCountRejectSpk = WorkStep::where('work_step_list_id', 5)
            ->where('state_task', 'Running')
            ->whereIn('status_task', ['Reject', 'Reject Requirements'])
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Training Program'])
            ->where(function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->whereIn('status_id', [3, 22, 26]);
                });
            })
            ->whereHas('instruction', function ($query) {
                $query->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
            })
            ->orderBy('shipping_date', 'asc')
            ->with(['status', 'job', 'workStepList', 'instruction'])
            ->count();

        $this->dataCountIncomingSpk = WorkStep::where('work_step_list_id', 5)
            ->where('state_task', 'Not Running')
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Close PO', 'Training Program'])
            ->with(['status', 'job', 'workStepList', 'instruction'])
            ->count();

        $this->dataCountAllSpk = WorkStep::where('work_step_list_id', 1)
            ->whereNotIn('spk_status', ['Training Program'])
            ->orderBy('shipping_date', 'asc')
            ->with(['status', 'job', 'workStepList', 'instruction'])
            ->count();

        $dataWorkStepCompleteRab = WorkStep::where('work_step_list_id', 4)
            ->where('state_task', 'Complete')
            ->where('status_task', 'Complete')
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Close PO', 'Training Program', 'Selesai'])
            ->whereHas('instruction', function ($query) {
                $query->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
            })
            ->with(['status', 'job', 'workStepList', 'instruction'])
            ->pluck('instruction_id');

        $this->dataPengajuanBahan = LayoutBahan::whereIn('instruction_id', $dataWorkStepCompleteRab)->count();

        $this->dataCountPengajuanBarangPersonal = PengajuanBarangPersonal::where('user_id', Auth()->user()->id)->count();
        $this->dataCountRejectPengajuanBarangPersonal = PengajuanBarangPersonal::where('user_id', Auth()->user()->id)->where('status_id', 3)->count();
        $this->dataCountPengajuanBarangSpk = PengajuanBarangSpk::where('user_id', Auth()->user()->id)->count();
        $this->dataCountRejectPengajuanBarangSpk = PengajuanBarangSpk::where('user_id', Auth()->user()->id)->where('status_id', 3)->count();
        $this->dataCountTotalPengajuanBarang = $this->dataCountPengajuanBarangPersonal + $this->dataCountPengajuanBarangSpk;
    }

    public function render()
    {
        return view('livewire.hitung-bahan.component.tab-dashboard-index')
            ->extends('layouts.app')
            ->section('content');
    }
}
