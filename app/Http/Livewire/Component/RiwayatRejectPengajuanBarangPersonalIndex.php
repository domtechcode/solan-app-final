<?php

namespace App\Http\Livewire\Component;

use Carbon\Carbon;
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

class RiwayatRejectPengajuanBarangPersonalIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginateRiwayatPengajuanBarangPersonal = 10;
    public $searchRiwayatPengajuanBarangPersonal = '';

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

    public $dataBarangPersonal = [];
    public $catatanRejectBarangPersonal;

    protected $listeners = ['indexRender' => '$refresh'];

    public function updatingSearchRiwayatPengajuanBarangPersonal()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->searchRiwayatPengajuanBarangPersonal = request()->query('search', $this->searchRiwayatPengajuanBarangPersonal);
    }

    public function render()
    {
        $dataRiwayatPengajuanBarangPersonal = PengajuanBarangPersonal::where('user_id', Auth()->user()->id)
            ->where('status_id', 3)
            ->where(function ($query) {
                $query
                    ->where('qty_barang', 'like', '%' . $this->searchRiwayatPengajuanBarangPersonal . '%')
                    ->orWhere('nama_barang', 'like', '%' . $this->searchRiwayatPengajuanBarangPersonal . '%')
                    ->orWhere('tgl_target_datang', 'like', '%' . $this->searchRiwayatPengajuanBarangPersonal . '%')
                    ->orWhere('tgl_pengajuan', 'like', '%' . $this->searchRiwayatPengajuanBarangPersonal . '%');
            })
            ->orderBy('tgl_pengajuan', 'asc')
            ->with(['status', 'user'])
            ->paginate($this->paginateRiwayatPengajuanBarangPersonal);

        return view('livewire.component.riwayat-reject-pengajuan-barang-personal-index', ['riwayatPengajuanBarangPersonal' => $dataRiwayatPengajuanBarangPersonal])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function ajukanBarangPersonalKembali()
    {
        $this->validate([
            'dataBarangPersonal.*.nama_barang' => 'required',
            'dataBarangPersonal.*.qty_barang' => 'required',
            'dataBarangPersonal.*.keterangan' => 'required',
        ]);

        if (isset($this->dataBarangPersonal)) {
            foreach ($this->dataBarangPersonal as $data) {
                $updatePengajuanBarang = PengajuanBarangPersonal::where('id', $data['id'])->update([
                    'user_id' => Auth()->user()->id,
                    'nama_barang' => $data['nama_barang'],
                    'tgl_pengajuan' => Carbon::now(),
                    'qty_barang' => $data['qty_barang'],
                    'keterangan' => $data['keterangan'],
                    'status_id' => 8,
                    'state' => 'Purchase',
                ]);
            }
        }

        $userDestination = User::where('role', 'Purchase')->get();
        foreach ($userDestination as $dataUser) {
            $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'Pengajuan Barang Personal', 'instruction_id' => null]);
        }

        $this->emit('indexRender');
        $this->dispatchBrowserEvent('close-modal-pengajuan-reject-barang-personal');
    }

    public function modalRiwayatRejectPengajuanBarangPersonal($PengajuanBarangId)
    {
        $this->dataBarangPersonal = [];

        $this->catatanRejectBarangPersonal = CatatanPengajuan::where('form_pengajuan_barang_personal_id', $PengajuanBarangId)
            ->where('kategori', 'reject barang personal')
            ->where('tujuan', Auth()->user()->id)
            ->get();

        $dataBarang = PengajuanBarangPersonal::where('id', $PengajuanBarangId)
            ->with('user')
            ->get();

        if (isset($dataBarang)) {
            foreach ($dataBarang as $item) {
                $data = [
                    'id' => $item->id,
                    'user_id' => $item->user_id,
                    'user' => $item->user->name,
                    'nama_barang' => $item->nama_barang,
                    'qty_barang' => $item->qty_barang,
                    'keterangan' => $item->keterangan,
                ];

                $this->dataBarangPersonal[] = $data;
            }
        } else {
            $this->dataBarangPersonal = [];
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
