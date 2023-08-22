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

class PengajuanBeliBarangPersonalIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginatePengajuanBeliBarangPersonal = 10;
    public $searchPengajuanBeliBarangPersonal = '';

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

    public function updatingSearchPengajuanBeliBarangPersonal()
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
        $this->searchPengajuanBeliBarangPersonal = request()->query('search', $this->searchPengajuanBeliBarangPersonal);
    }

    public function render()
    {
        $dataPengajuanBeliBarangPersonal = PengajuanBarangPersonal::whereIn('status_id', [15])
            ->where(function ($query) {
                $query
                    ->where('qty_barang', 'like', '%' . $this->searchPengajuanBeliBarangPersonal . '%')
                    ->orWhere('nama_barang', 'like', '%' . $this->searchPengajuanBeliBarangPersonal . '%')
                    ->orWhere('tgl_target_datang', 'like', '%' . $this->searchPengajuanBeliBarangPersonal . '%')
                    ->orWhere('tgl_pengajuan', 'like', '%' . $this->searchPengajuanBeliBarangPersonal . '%');
            })
            ->with(['status', 'user'])
            ->orderBy('tgl_target_datang', 'asc')
            ->paginate($this->paginatePengajuanBeliBarangPersonal);

        return view('livewire.accounting.component.pengajuan-beli-barang-personal-index', ['pengajuanBeliBarangPersonal' => $dataPengajuanBeliBarangPersonal])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function modalPengajuanBeliBarangPersonal($PengajuanBarangId)
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

        $dataNote = CatatanPengajuan::where('user_id', Auth()->user()->id)->where('form_pengajuan_barang_personal_id', $PengajuanBarangId)->get();

        if(isset($dataNote)){
            foreach ($dataNote as $data) {
                $notes = [
                    'tujuan' => $data->tujuan,
                    'catatan' => $data->catatan,
                ];

                $this->notes [] = $notes;
            }
        }
    }
}
