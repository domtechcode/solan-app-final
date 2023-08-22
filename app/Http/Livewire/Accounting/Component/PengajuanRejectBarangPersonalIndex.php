<?php

namespace App\Http\Livewire\Accounting\Component;

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
use App\Models\PengajuanBarangPersonal;

class PengajuanRejectBarangPersonalIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginatePengajuanRejectBarangPersonal = 10;
    public $searchPengajuanRejectBarangPersonal = '';

    public $selectedInstruction;
    public $selectedWorkStep;
    public $selectedFileContoh;
    public $selectedFileArsip;
    public $selectedFileAccounting;
    public $selectedFileLayout;
    public $selectedFileSample;
    public $notes = [];

    public $workStepHitungBahanNew;

    public $dataBarang;
    public $harga_satuan;
    public $qty_purchase;
    public $total_harga;
    public $stock;

    protected $listeners = ['indexRender' => '$refresh'];

    public function updatingSearchPengajuanRejectBarangPersonal()
    {
        $this->resetPage();
    }

    public function addEmptyNote()
    {
        $this->notes[] = '';
    }

    public function removeNote($index)
    {
        unset($this->notes[$index]);
        $this->notes = array_values($this->notes);
    }

    public function mount()
    {
        $this->searchPengajuanRejectBarangPersonal = request()->query('search', $this->searchPengajuanRejectBarangPersonal);
    }

    public function render()
    {
        $dataPengajuanRejectBarangPersonal = PengajuanBarangPersonal::whereIn('status_id', [17])
            ->where('state', 'Accounting')
            ->where(function ($query) {
                $query
                    ->where('qty_barang', 'like', '%' . $this->searchPengajuanRejectBarangPersonal . '%')
                    ->orWhere('nama_barang', 'like', '%' . $this->searchPengajuanRejectBarangPersonal . '%')
                    ->orWhere('tgl_target_datang', 'like', '%' . $this->searchPengajuanRejectBarangPersonal . '%')
                    ->orWhere('tgl_pengajuan', 'like', '%' . $this->searchPengajuanRejectBarangPersonal . '%');
            })
            ->with(['status', 'user'])
            ->orderBy('tgl_target_datang', 'asc')
            ->paginate($this->paginatePengajuanRejectBarangPersonal);

        return view('livewire.accounting.component.pengajuan-reject-barang-personal-index', ['pengajuanRejectBarangPersonal' => $dataPengajuanRejectBarangPersonal])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function ajukanRabBarang($PengajuanBarangSelectedRabId)
    {
        $this->validate([
            'harga_satuan' => 'required',
            'qty_purchase' => 'required',
            'total_harga' => 'required',
            'stock' => 'required',
        ]);

        if (isset($this->notes)) {
            $this->validate([
                'notes.*.tujuan' => 'required',
                'notes.*.catatan' => 'required',
            ]);

            $deleteCatatan = CatatanPengajuan::where('user_id', Auth()->user()->id)
                ->where('form_pengajuan_barang_personal_id', $this->dataBarang->id)
                ->delete();
            foreach ($this->notes as $input) {
                $catatan = CatatanPengajuan::create([
                    'tujuan' => $input['tujuan'],
                    'catatan' => $input['catatan'],
                    'kategori' => 'catatan',
                    'user_id' => Auth()->user()->id,
                    'form_pengajuan_barang_personal_id' => $this->dataBarang->id,
                ]);
            }
        }

        $updateRab = PengajuanBarangPersonal::find($PengajuanBarangSelectedRabId);
        $updateRab->update([
            'harga_satuan' => currency_convert($this->harga_satuan),
            'qty_purchase' => currency_convert($this->qty_purchase),
            'total_harga' => currency_convert($this->total_harga),
            'stock' => currency_convert($this->stock),
            'status_id' => 11,
            'state' => 'RAB',
            'previous_state' => 'Accounting',
            'accounting' => 'Accounting',
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Stock Instruksi Kerja',
            'message' => 'Data berhasil disimpan',
        ]);

        $userDestination = User::where('role', 'RAB')->get();
        foreach ($userDestination as $dataUser) {
            $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'Pengajuan Barang Baru', 'instruction_id' => null]);
        }
        $this->emit('indexRender');

        $this->dispatchBrowserEvent('close-modal-pengajuan-reject-barang-personal');
        $this->reset();
    }

    public function approveBarang($PengajuanBarangSelectedApproveId)
    {
        $this->validate([
            'harga_satuan' => 'required',
            'qty_purchase' => 'required',
            'total_harga' => 'required',
            'stock' => 'required',
        ]);

        if (isset($this->notes)) {
            $this->validate([
                'notes.*.tujuan' => 'required',
                'notes.*.catatan' => 'required',
            ]);

            $deleteCatatan = CatatanPengajuan::where('user_id', Auth()->user()->id)
                ->where('form_pengajuan_barang_personal_id', $this->dataBarang->id)
                ->delete();
            foreach ($this->notes as $input) {
                $catatan = CatatanPengajuan::create([
                    'tujuan' => $input['tujuan'],
                    'catatan' => $input['catatan'],
                    'kategori' => 'catatan',
                    'user_id' => Auth()->user()->id,
                    'form_pengajuan_barang_personal_id' => $this->dataBarang->id,
                ]);
            }
        }

        $updateApprove = PengajuanBarangPersonal::find($PengajuanBarangSelectedApproveId);
        $updateApprove->update([
            'harga_satuan' => currency_convert($this->harga_satuan),
            'qty_purchase' => currency_convert($this->qty_purchase),
            'total_harga' => currency_convert($this->total_harga),
            'stock' => currency_convert($this->stock),
            'status_id' => 13,
            'state' => 'Purchase',
            'previous_state' => 'Accounting',
            'accounting' => 'Accounting',
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Pengajuan Barang Instruksi Kerja',
            'message' => 'Data berhasil disimpan',
        ]);

        $userDestination = User::where('role', 'Purchase')->get();
        foreach ($userDestination as $dataUser) {
            $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'Pengajuan Barang Baru', 'instruction_id' => null]);
        }
        $this->emit('indexRender');

        $this->dispatchBrowserEvent('close-modal-pengajuan-reject-barang-personal');
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

        if (isset($this->notes)) {
            $this->validate([
                'notes.*.tujuan' => 'required',
                'notes.*.catatan' => 'required',
            ]);

            $deleteCatatan = CatatanPengajuan::where('user_id', Auth()->user()->id)
                ->where('form_pengajuan_barang_personal_id', $this->dataBarang->id)
                ->delete();
            foreach ($this->notes as $input) {
                $catatan = CatatanPengajuan::create([
                    'tujuan' => $input['tujuan'],
                    'catatan' => $input['catatan'],
                    'kategori' => 'catatan',
                    'user_id' => Auth()->user()->id,
                    'form_pengajuan_barang_personal_id' => $this->dataBarang->id,
                ]);
            }
        }

        $updateReject = PengajuanBarangPersonal::find($PengajuanBarangSelectedRejectId);
        $updateReject->update([
            'harga_satuan' => currency_convert($this->harga_satuan),
            'qty_purchase' => currency_convert($this->qty_purchase),
            'total_harga' => currency_convert($this->total_harga),
            'stock' => currency_convert($this->stock),
            'status_id' => 18,
            'state' => 'Purchase',
            'previous_state' => 'Accounting',
            'accounting' => 'Accounting',
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Pengajuan Barang Instruksi Kerja',
            'message' => 'Data berhasil disimpan',
        ]);

        $userDestination = User::where('role', 'Purchase')->get();
        foreach ($userDestination as $dataUser) {
            $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'Pengajuan Barang Baru', 'instruction_id' => null]);
        }
        $this->emit('indexRender');
        $this->dispatchBrowserEvent('close-modal-pengajuan-reject-barang-personal');
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
        $this->total_harga = $this->total_harga;
    }

    public function modalPengajuanRejectBarangPersonal($PengajuanBarangId)
    {
        $this->reset();

        $this->dataBarang = PengajuanBarangPersonal::find($PengajuanBarangId);

        if (isset($this->dataBarang) && $this->dataBarang->harga_satuan != null) {
            $this->harga_satuan = $this->dataBarang->harga_satuan;
            $this->qty_purchase = $this->dataBarang->qty_purchase;
            $this->stock = $this->dataBarang->stock;
            $this->total_harga = $this->dataBarang->total_harga;
        } else {
            $this->harga_satuan = '';
            $this->qty_purchase = '';
            $this->stock = '';
            $this->total_harga = '';
        }

        $dataNote = CatatanPengajuan::where('user_id', Auth()->user()->id)
            ->where('form_pengajuan_barang_personal_id', $PengajuanBarangId)
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
