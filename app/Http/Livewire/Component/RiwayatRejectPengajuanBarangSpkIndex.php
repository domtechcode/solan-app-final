<?php

namespace App\Http\Livewire\Component;

use App\Models\User;
use App\Models\Files;
use App\Models\FormRab;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use App\Models\WorkStepList;
use Livewire\WithPagination;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use App\Models\CatatanPengajuan;
use App\Models\PengajuanBarangSpk;

class RiwayatRejectPengajuanBarangSpkIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginateRiwayatPengajuanBarangSpk = 10;
    public $searchRiwayatPengajuanBarangSpk = '';

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

    public $dataBarangSpk = [];
    public $harga_satuan;
    public $qty_purchase;
    public $total_harga;
    public $stock;

    public $workStepList;
    public $catatanRejectBarangSpk;

    protected $listeners = ['indexRender' => '$refresh'];

    public function updatingSearchRiwayatPengajuanBarangSpk()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->searchRiwayatPengajuanBarangSpk = request()->query('search', $this->searchRiwayatPengajuanBarangSpk);
        $this->workStepList = WorkStepList::get();
    }

    public function render()
    {
        $dataRiwayatPengajuanBarangSpk = PengajuanBarangSpk::where('user_id', Auth()->user()->id)
            ->where('status_id', 3)
            ->where(function ($query) {
                $query
                    ->where('qty_barang', 'like', '%' . $this->searchRiwayatPengajuanBarangSpk . '%')
                    ->orWhere('nama_barang', 'like', '%' . $this->searchRiwayatPengajuanBarangSpk . '%')
                    ->orWhere('tgl_target_datang', 'like', '%' . $this->searchRiwayatPengajuanBarangSpk . '%')
                    ->orWhere('tgl_pengajuan', 'like', '%' . $this->searchRiwayatPengajuanBarangSpk . '%');
            })
            ->with(['status', 'workStepList', 'instruction', 'user'])
            ->orderBy('tgl_target_datang', 'asc')
            ->paginate($this->paginateRiwayatPengajuanBarangSpk);

        return view('livewire.component.riwayat-reject-pengajuan-barang-spk-index', ['riwayatPengajuanBarangSpk' => $dataRiwayatPengajuanBarangSpk])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function ajukanBarangSpkKembali()
    {
        $this->validate([
            'dataBarangSpk.*.work_step_list_id' => 'required',
            'dataBarangSpk.*.nama_barang' => 'required',
            'dataBarangSpk.*.qty_barang' => 'required',
            'dataBarangSpk.*.keterangan' => 'required',
        ]);

        if (isset($this->dataBarangSpk)) {
            foreach ($this->dataBarangSpk as $data) {
                $updatePengajuanBarang = PengajuanBarangSpk::where('id', $data['id'])->update([
                    'work_step_list_id' => $data['work_step_list_id'],
                    'nama_barang' => $data['nama_barang'],
                    'qty_barang' => $data['qty_barang'],
                    'keterangan' => $data['keterangan'],
                    'status_id' => '8',
                    // 'status' => 'Pending',
                    // 'state_pengajuan' => 'New',
                ]);
            }
        }

        $userDestination = User::where('role', 'Purchase')->get();
        foreach ($userDestination as $dataUser) {
            $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'Pengajuan Barang SPK', 'instruction_id' => null]);
        }

        $this->emit('indexRender');
        $this->dispatchBrowserEvent('close-modal-pengajuan-reject-barang-spk');
    }

    public function modalRiwayatRejectPengajuanBarangSpk($PengajuanBarangId, $instructionId)
    {
        $this->dataBarangSpk = [];
        $this->selectedInstruction = Instruction::find($instructionId);

        $dataworkStepHitungBahanNew = WorkStep::where('instruction_id', $instructionId)
            ->where('work_step_list_id', 5)
            ->first();
        if (isset($dataworkStepHitungBahanNew)) {
            $this->workStepHitungBahanNew = $dataworkStepHitungBahanNew->id;
        }

        $this->catatanRejectBarangSpk = CatatanPengajuan::where('form_pengajuan_barang_spk_id', $PengajuanBarangId)
            ->where('kategori', 'reject barang spk')
            ->where('tujuan', Auth()->user()->id)
            ->get();

        $dataBarang = PengajuanBarangSpk::where('id', $PengajuanBarangId)->get();

        if (isset($dataBarang)) {
            foreach ($dataBarang as $item) {
                $data = [
                    'id' => $item->id,
                    'instruction_id' => $item->instruction_id,
                    'work_step_list_id' => $item->work_step_list_id,
                    'user_id' => $item->user_id,
                    'tgl_pengajuan' => $item->tgl_pengajuan,
                    'tgl_target_datang' => $item->tgl_target_datang,
                    'tgl_tersedia' => $item->tgl_tersedia,
                    'status_id' => $item->status_id,
                    'state' => $item->state,
                    'nama_barang' => $item->nama_barang,
                    'qty_barang' => $item->qty_barang,
                    'keterangan' => $item->keterangan,
                ];

                $this->dataBarangSpk[] = $data;
            }
        } else {
            $this->dataBarangSpk = [];
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
