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
use App\Models\PengajuanBarangSpk;

class PengajuanApprovedBarangSpkIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginatePengajuanApprovedBarangSpk = 10;
    public $searchPengajuanApprovedBarangSpk = '';

    public $selectedInstruction;
    public $selectedWorkStep;
    public $selectedFileContoh;
    public $selectedFileArsip;
    public $selectedFileAccounting;
    public $selectedFileLayout;
    public $selectedFileSample;
    public $notes = [];
    public $catatan;

    public $workStepHitungBahanNew;

    public $dataBarang;
    public $harga_satuan;
    public $qty_purchase;
    public $total_harga;
    public $stock;
    public $dataPengajuanBarangSpk;

    protected $listeners = ['indexRender' => '$refresh'];

    public function updatingSearchPengajuanApprovedBarangSpk()
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
        $this->searchPengajuanApprovedBarangSpk = request()->query('search', $this->searchPengajuanApprovedBarangSpk);
    }

    public function render()
    {
        $dataPengajuanApprovedBarangSpk = PengajuanBarangSpk::whereIn('status_id', [14])
            ->where('state', 'Accounting')
            ->where(function ($query) {
                $query
                    ->whereHas('instruction', function ($instructionQuery) {
                        $instructionQuery
                            ->where('spk_number', 'like', '%' . $this->searchPengajuanApprovedBarangSpk . '%')
                            ->orWhere('spk_type', 'like', '%' . $this->searchPengajuanApprovedBarangSpk . '%')
                            ->orWhere('customer_name', 'like', '%' . $this->searchPengajuanApprovedBarangSpk . '%')
                            ->orWhere('order_name', 'like', '%' . $this->searchPengajuanApprovedBarangSpk . '%')
                            ->orWhere('customer_number', 'like', '%' . $this->searchPengajuanApprovedBarangSpk . '%')
                            ->orWhere('code_style', 'like', '%' . $this->searchPengajuanApprovedBarangSpk . '%')
                            ->orWhere('shipping_date', 'like', '%' . $this->searchPengajuanApprovedBarangSpk . '%')
                            ->orWhere('ukuran_barang', 'like', '%' . $this->searchPengajuanApprovedBarangSpk . '%')
                            ->orWhere('spk_number_fsc', 'like', '%' . $this->searchPengajuanApprovedBarangSpk . '%');
                    })
                    ->OrWhere(function ($sub) {
                        $sub->where('qty_barang', 'like', '%' . $this->searchPengajuanApprovedBarangSpk . '%')
                            ->orWhere('nama_barang', 'like', '%' . $this->searchPengajuanApprovedBarangSpk . '%')
                            ->orWhere('tgl_target_datang', 'like', '%' . $this->searchPengajuanApprovedBarangSpk . '%')
                            ->orWhere('tgl_pengajuan', 'like', '%' . $this->searchPengajuanApprovedBarangSpk . '%');
                    });
            })
            ->with(['status', 'workStepList', 'instruction', 'user'])
            ->orderBy('tgl_target_datang', 'asc')
            ->paginate($this->paginatePengajuanApprovedBarangSpk);

        return view('livewire.accounting.component.pengajuan-approved-barang-spk-index', ['pengajuanApprovedBarangSpk' => $dataPengajuanApprovedBarangSpk])
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
                    'form_pengajuan_barang_spk_id' => $this->dataBarang->id,
                ]);
            }
        }

        $updateApprove = PengajuanBarangSpk::find($PengajuanBarangSelectedApproveId);
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
            $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'Pengajuan Barang Baru', 'instruction_id' => $updateApprove->instruction_id]);
        }
        $this->emit('indexRender');

        $this->dispatchBrowserEvent('close-modal-pengajuan-approved-barang-spk');
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
                    'form_pengajuan_barang_spk_id' => $this->dataBarang->id,
                ]);
            }
        }

        $updateReject = PengajuanBarangSpk::find($PengajuanBarangSelectedRejectId);
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
            $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'Pengajuan Barang Baru', 'instruction_id' => $updateReject->instruction_id]);
        }
        $this->emit('indexRender');
        $this->dispatchBrowserEvent('close-modal-pengajuan-approved-barang-spk');
        $this->reset();
    }

    public function modalPengajuanApprovedBarangSpk($PengajuanBarangId, $instructionId)
    {
        $this->reset();

        $this->selectedInstruction = Instruction::find($instructionId);

        $dataworkStepHitungBahanNew = WorkStep::where('instruction_id', $instructionId)
            ->where('work_step_list_id', 5)
            ->first();
        if (isset($dataworkStepHitungBahanNew)) {
            $this->workStepHitungBahanNew = $dataworkStepHitungBahanNew->id;
        }

        $this->dataBarang = PengajuanBarangSpk::find($PengajuanBarangId);

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
            ->where('form_pengajuan_barang_spk_id', $PengajuanBarangId)
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

        $this->catatan = CatatanPengajuan::where('form_pengajuan_barang_spk_id', $PengajuanBarangId)
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
