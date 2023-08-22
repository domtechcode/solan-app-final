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
use App\Models\CatatanPengajuan;
use App\Models\PengajuanBarangSpk;
use App\Models\FormPengajuanMaklun;

class PengajuanCompleteMaklunSpkIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginatePengajuanCompleteMaklunSpk = 10;
    public $searchPengajuanCompleteMaklunSpk = '';

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

    public $notes = [];
    public $catatan;

    protected $listeners = ['indexRender' => '$refresh'];

    public function addEmptyNote()
    {
        $this->notes[] = '';
    }

    public function removeNote($index)
    {
        unset($this->notes[$index]);
        $this->notes = array_values($this->notes);
    }

    public function updatingSearchPengajuanCompleteMaklunSpk()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->searchPengajuanCompleteMaklunSpk = request()->query('search', $this->searchPengajuanCompleteMaklunSpk);
    }

    public function render()
    {
        $dataPengajuanCompleteMaklunSpk = FormPengajuanMaklun::where('status', 'Complete')
        ->where('pekerjaan', 'Purchase')
            ->where(function ($query) {
                $query
                    ->where('bentuk_maklun', 'like', '%' . $this->searchPengajuanCompleteMaklunSpk . '%')
                    ->orWhere('rekanan', 'like', '%' . $this->searchPengajuanCompleteMaklunSpk . '%')
                    ->orWhere('tgl_keluar', 'like', '%' . $this->searchPengajuanCompleteMaklunSpk . '%')
                    ->orWhere('qty_keluar', 'like', '%' . $this->searchPengajuanCompleteMaklunSpk . '%');
            })
            ->with(['instruction'])
            ->orderBy('tgl_keluar', 'asc')
            ->paginate($this->paginatePengajuanCompleteMaklunSpk);

        return view('livewire.purchase.component.pengajuan-complete-maklun-spk-index', ['pengajuanCompleteMaklunSpk' => $dataPengajuanCompleteMaklunSpk])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function modalPengajuanCompleteMaklunSpk($PengajuanMaklunId, $instructionId)
    {
        $this->reset();
        
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

        $dataNote = CatatanPengajuan::where('user_id', Auth()->user()->id)
            ->where('form_pengajuan_maklun_id', $PengajuanMaklunId)
            ->get();

        if (isset($dataNote)) {
            foreach ($dataNote as $data) {
                $notes = [
                    'tujuan' => $data->tujuan,
                    'catatan' => $data->catatan,
                ];

                $this->notes[] = $notes;
            }
        }

        $this->catatan = CatatanPengajuan::where('form_pengajuan_maklun_id', $PengajuanMaklunId)
            ->with('user')
            ->get();
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
