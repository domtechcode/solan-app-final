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
use App\Models\CatatanPengajuan;
use App\Models\PengajuanBarangSpk;
use App\Models\PengajuanBarangPersonal;

class PengajuanBarangPersonalIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginatePengajuanBarangPersonal = 10;
    public $searchPengajuanBarangPersonal = '';

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

    public $notes = [];
    public $catatan;
    public $dataPengajuanBarangSpk;

    protected $listeners = ['indexRender' => '$refresh'];

    public function updatingSearchPengajuanBarangPersonal()
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
        $this->searchPengajuanBarangPersonal = request()->query('search', $this->searchPengajuanBarangPersonal);
    }

    public function render()
    {
        $dataPengajuanBarangPersonal = PengajuanBarangPersonal::where('status_id', 11)
            ->where('state', 'RAB')
            ->where(function ($query) {
                $query
                    ->where('qty_barang', 'like', '%' . $this->searchPengajuanBarangPersonal . '%')
                    ->orWhere('nama_barang', 'like', '%' . $this->searchPengajuanBarangPersonal . '%')
                    ->orWhere('tgl_target_datang', 'like', '%' . $this->searchPengajuanBarangPersonal . '%')
                    ->orWhere('tgl_pengajuan', 'like', '%' . $this->searchPengajuanBarangPersonal . '%');
            })
            ->with(['status', 'user'])
            ->orderBy('tgl_target_datang', 'asc')
            ->paginate($this->paginatePengajuanBarangPersonal);

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

        if (isset($this->notes)) {
            $this->validate([
                'notes.*.tujuan' => 'required',
                'notes.*.catatan' => 'required',
            ]);

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
        $this->emit('indexRender');

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

        if (isset($this->notes)) {
            $this->validate([
                'notes.*.tujuan' => 'required',
                'notes.*.catatan' => 'required',
            ]);

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
        $this->emit('indexRender');

        $userDestination = User::where('role', $destinationPrevious)->get();
        foreach ($userDestination as $dataUser) {
            $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'Keputusan Pengajuan Barang Personal', 'instruction_id' => null]);
        }

        $this->dispatchBrowserEvent('close-modal-pengajuan-barang-personal');
        $this->reset();
    }

    public function modalPengajuanBarangPersonal($PengajuanBarangId)
    {
        $this->reset();

        $this->dataBarang = PengajuanBarangPersonal::find($PengajuanBarangId);

        $this->harga_satuan = $this->dataBarang->harga_satuan;
        $this->qty_purchase = $this->dataBarang->qty_purchase;
        $this->stock = $this->dataBarang->stock;
        $this->total_harga = $this->dataBarang->total_harga;

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

        $this->catatan = CatatanPengajuan::where('form_pengajuan_barang_personal_id', $PengajuanBarangId)
            ->with('user')
            ->get();

        $this->dataPengajuanBarangSpk = PengajuanBarangSpk::where('id', $PengajuanBarangId)
            ->with('workStepList', 'filesPengajuanBarangSpk')
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
