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

class PengajuanProcessBarangSpkIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginatePengajuanProcessBarangSpk = 10;
    public $searchPengajuanProcessBarangSpk = '';

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

    public function updatingSearchPengajuanProcessBarangSpk()
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
        $this->searchPengajuanProcessBarangSpk = request()->query('search', $this->searchPengajuanProcessBarangSpk);
    }

    public function render()
    {
        $dataPengajuanProcessBarangSpk = PengajuanBarangSpk::whereIn('status_id', [11])
            ->where(function ($query) {
                $query
                    ->where('qty_barang', 'like', '%' . $this->searchPengajuanProcessBarangSpk . '%')
                    ->orWhere('nama_barang', 'like', '%' . $this->searchPengajuanProcessBarangSpk . '%')
                    ->orWhere('tgl_target_datang', 'like', '%' . $this->searchPengajuanProcessBarangSpk . '%')
                    ->orWhere('tgl_pengajuan', 'like', '%' . $this->searchPengajuanProcessBarangSpk . '%');
            })
            ->with(['status', 'workStepList', 'instruction', 'user'])
            ->orderBy('tgl_target_datang', 'asc')
            ->paginate($this->paginatePengajuanProcessBarangSpk);

        return view('livewire.accounting.component.pengajuan-process-barang-spk-index', ['pengajuanProcessBarangSpk' => $dataPengajuanProcessBarangSpk])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function modalPengajuanProcessBarangSpk($PengajuanBarangId, $instructionId)
    {
        $this->notes = [];

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
}
