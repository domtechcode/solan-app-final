<?php

namespace App\Http\Livewire\Purchase\Component;

use App\Models\User;
use App\Models\Files;
use App\Models\FormRab;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use App\Models\PengajuanBarangSpk;
use App\Models\FormPengajuanMaklun;

class PengajuanProcessMaklunSpkIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginatePengajuanProcessMaklunSpk = 10;
    public $searchPengajuanProcessMaklunSpk = '';

    public $selectedInstruction;
    public $selectedWorkStep;
    public $selectedFileContoh;
    public $selectedFileArsip;
    public $selectedFileAccounting;
    public $selectedFileLayout;
    public $selectedFileSample;

    public $selectedInstructionParent;
    public $selectedWorkStepParent;
    public $selectedFileContohParent;
    public $selectedFileArsipParent;
    public $selectedFileAccountingParent;
    public $selectedFileLayoutParent;
    public $selectedFileSampleParent;

    public $selectedInstructionChild;

    public $selectedGroupParent;
    public $selectedGroupChild;
    public $workStepHitungBahanNew;

    public $dataMaklun;
    public $harga_satuan_maklun;
    public $qty_purchase_maklun;
    public $total_harga_maklun;

    protected $listeners = ['indexRender' => '$refresh'];

    public function updatingSearchPengajuanProcessMaklunSpk()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->searchPengajuanProcessMaklunSpk = request()->query('search', $this->searchPengajuanProcessMaklunSpk);
    }

    public function render()
    {
        $dataPengajuanProcessMaklunSpk = FormPengajuanMaklun::whereIn('status', ['Pengajuan Accounting', 'Pengajuan RAB'])
            ->where('pekerjaan', 'Purchase')
            ->where(function ($query) {
                $query
                    ->where('bentuk_maklun', 'like', '%' . $this->searchPengajuanProcessMaklunSpk . '%')
                    ->orWhere('rekanan', 'like', '%' . $this->searchPengajuanProcessMaklunSpk . '%')
                    ->orWhere('tgl_keluar', 'like', '%' . $this->searchPengajuanProcessMaklunSpk . '%')
                    ->orWhere('qty_keluar', 'like', '%' . $this->searchPengajuanProcessMaklunSpk . '%');
            })
            ->with(['instruction'])
            ->orderBy('tgl_keluar', 'asc')
            ->paginate($this->paginatePengajuanProcessMaklunSpk);

        return view('livewire.purchase.component.pengajuan-process-maklun-spk-index', ['pengajuanProcessMaklunSpk' => $dataPengajuanProcessMaklunSpk])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function modalPengajuanProcessMaklunSpk($PengajuanMaklunId, $instructionId)
    {
        $this->selectedInstruction = Instruction::find($instructionId);

        $dataworkStepHitungBahanNew = WorkStep::where('instruction_id', $instructionId)
            ->where('work_step_list_id', 5)
            ->first();
        if (isset($dataworkStepHitungBahanNew)) {
            $this->workStepHitungBahanNew = $dataworkStepHitungBahanNew->id;
        }

        $this->dataMaklun = FormPengajuanMaklun::find($PengajuanMaklunId);

        $this->harga_satuan_maklun = $this->dataMaklun->harga_satuan_maklun;
        $this->qty_purchase_maklun = $this->dataMaklun->qty_purchase_maklun;
        $this->total_harga_maklun = $this->dataMaklun->total_harga_maklun;
    }

    public function messageSent($arguments)
    {
        $createdMessage = 'info';
        $selectedConversation = $arguments['conversation'];
        $receiverUser = $arguments['receiver'];
        $instruction_id = $arguments['instruction_id'];

        event(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, $receiverUser));
    }
}