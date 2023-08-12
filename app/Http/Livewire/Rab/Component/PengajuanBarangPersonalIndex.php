<?php

namespace App\Http\Livewire\Rab\Component;

use App\Models\User;
use App\Models\Files;
use App\Models\FormRab;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use App\Models\PengajuanBarangPersonal;

class PengajuanBarangPersonalIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginate = 10;
    public $search = '';

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

    public $dataBarang;
    public $harga_satuan;
    public $qty_purchase;
    public $total_harga;
    public $stock;

    protected $listeners = ['indexRender' => '$refresh'];

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }

    public function render()
    {
        $dataPengajuanBarangPersonal = PengajuanBarangPersonal::where('status_id', 11)
            ->with(['status', 'user'])
            ->orderBy('tgl_target_datang', 'asc')
            ->paginate($this->paginate);

        return view('livewire.rab.component.pengajuan-barang-personal-index', ['pengajuanBarangPersonal' => $dataPengajuanBarangPersonal])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function approveBarang($PengajuanBarangSelectedApproveId)
    {
        $this->validate([
            'harga_satuan' => 'required',
            'qty_purchase' => 'required',
            'total_harga' => 'required',
            'stock' => 'required',
        ]);

        $updateApprove = PengajuanBarangPersonal::find($PengajuanBarangSelectedApproveId);
        $destinationPrevious = $updateApprove->previous_state;
        $updateApprove->update([
            'harga_satuan' => currency_convert($this->harga_satuan),
            'qty_purchase' => currency_convert($this->qty_purchase),
            'total_harga' => currency_convert($this->total_harga),
            'stock' => currency_convert($this->stock),
            'status_id' => 14,
            'state' => $updateApprove->previous_state,
            'previous_state' => 'RAB',
            'rab' => 'RAB',
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Pengajuan Barang Instruksi Kerja',
            'message' => 'Data berhasil disimpan',
        ]);

        $userDestination = User::where('role', $destinationPrevious)->get();
        foreach ($userDestination as $dataUser) {
            $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'Keputusan Pengajuan Barang Personal', 'instruction_id' => null]);
        }
        event(new IndexRenderEvent('refresh'));
        
        $this->dispatchBrowserEvent('close-modal-pengajuan-barang-personal');
        $this->reset();

    }

    public function rejectBarang($PengajuanBarangSelectedRejectId)
    {
        $this->validate([
            'harga_satuan' => 'required',
            'qty_purchase' => 'required',
            'total_harga' => 'required',
            'stock' => 'required',
        ]);

        $updateReject = PengajuanBarangPersonal::find($PengajuanBarangSelectedRejectId);
        $destinationPrevious = $updateReject->previous_state;
        $updateReject->update([
            'harga_satuan' => currency_convert($this->harga_satuan),
            'qty_purchase' => currency_convert($this->qty_purchase),
            'total_harga' => currency_convert($this->total_harga),
            'stock' => currency_convert($this->stock),
            'status_id' => 17,
            'state' => $updateReject->previous_state,
            'previous_state' => 'RAB',
            'rab' => 'RAB',
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Pengajuan Barang Instruksi Kerja',
            'message' => 'Data berhasil disimpan',
        ]);
        event(new IndexRenderEvent('refresh'));

        $userDestination = User::where('role', $destinationPrevious)->get();
        foreach ($userDestination as $dataUser) {
            $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'Keputusan Pengajuan Barang Personal', 'instruction_id' => null]);
        }

        $this->dispatchBrowserEvent('close-modal-pengajuan-barang-personal');
        $this->reset();

    }

    public function cekTotalHarga()
    {
        $this->validate([
            'harga_satuan' => 'required',
            'qty_purchase' => 'required',
            'stock' => 'required',
        ]);

        $hargaSatuanSelected = currency_convert($this->harga_satuan);
        $qtyPurchaseSelected = currency_convert($this->qty_purchase);
        $stockSelected = currency_convert($this->stock);

        $this->total_harga = $hargaSatuanSelected * ($qtyPurchaseSelected - $stockSelected);
        $this->total_harga = currency_idr($this->total_harga);
    }

    public function modalPengajuanBarangPersonal($PengajuanBarangId)
    {
        $this->dataBarang = PengajuanBarangPersonal::find($PengajuanBarangId);

        $this->harga_satuan = currency_idr($this->dataBarang->harga_satuan);
        $this->qty_purchase = currency_idr($this->dataBarang->qty_purchase);
        $this->stock = currency_idr($this->dataBarang->stock);
        $this->total_harga = currency_idr($this->dataBarang->total_harga);

        $this->dispatchBrowserEvent('show-detail-pengajuan-barang-personal');
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
