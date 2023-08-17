<?php

namespace App\Http\Livewire\Component;

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
use App\Models\PengajuanBarangPersonal;

class RiwayatPengajuanBarangPersonalIndex extends Component
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

    public $dataBarang;
    public $harga_satuan;
    public $qty_purchase;
    public $total_harga;
    public $stock;

    protected $listeners = ['indexRender' => 'renderIndex'];

    public function renderIndex()
    {
        $this->render();
    }

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
        $dataRiwayatPengajuanBarangPersonal = PengajuanBarangPersonal::where('user_id', Auth()->user()->id)->where(function ($query) {
            $query->where('qty_barang', 'like', '%' . $this->searchRiwayatPengajuanBarangPersonal . '%')
                ->orWhere('nama_barang', 'like', '%' . $this->searchRiwayatPengajuanBarangPersonal . '%')
                ->orWhere('tgl_target_datang', 'like', '%' . $this->searchRiwayatPengajuanBarangPersonal . '%')
                ->orWhere('tgl_pengajuan', 'like', '%' . $this->searchRiwayatPengajuanBarangPersonal . '%');
        })
            ->orderBy('tgl_pengajuan', 'asc')
            ->with(['status', 'user'])
            ->paginate($this->paginateRiwayatPengajuanBarangPersonal);

        return view('livewire.component.riwayat-pengajuan-barang-personal-index', ['riwayatPengajuanBarangPersonal' => $dataRiwayatPengajuanBarangPersonal])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function modalRiwayatPengajuanBarangPersonal($PengajuanBarangId)
    {
        $this->dataBarang = PengajuanBarangPersonal::find($PengajuanBarangId);
        $this->harga_satuan = currency_idr($this->dataBarang->harga_satuan);
        $this->qty_purchase = currency_idr($this->dataBarang->qty_purchase);
        $this->stock = currency_idr($this->dataBarang->stock);
        $this->total_harga = currency_idr($this->dataBarang->total_harga);
    }
}
