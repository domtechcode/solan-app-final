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

class PengajuanCompleteBarangSpkIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginatePengajuanCompleteBarangSpk = 10;
    public $searchPengajuanCompleteBarangSpk = '';

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

    public function updatingSearchPengajuanCompleteBarangSpk()
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
        $this->searchPengajuanCompleteBarangSpk = request()->query('search', $this->searchPengajuanCompleteBarangSpk);
    }

    public function render()
    {
        $dataPengajuanCompleteBarangSpk = PengajuanBarangSpk::whereIn('status_id', [16])
            ->where(function ($query) {
                $query
                    ->whereHas('instruction', function ($instructionQuery) {
                        $instructionQuery
                            ->where('spk_number', 'like', '%' . $this->searchPengajuanCompleteBarangSpk . '%')
                            ->orWhere('spk_type', 'like', '%' . $this->searchPengajuanCompleteBarangSpk . '%')
                            ->orWhere('customer_name', 'like', '%' . $this->searchPengajuanCompleteBarangSpk . '%')
                            ->orWhere('order_name', 'like', '%' . $this->searchPengajuanCompleteBarangSpk . '%')
                            ->orWhere('customer_number', 'like', '%' . $this->searchPengajuanCompleteBarangSpk . '%')
                            ->orWhere('code_style', 'like', '%' . $this->searchPengajuanCompleteBarangSpk . '%')
                            ->orWhere('shipping_date', 'like', '%' . $this->searchPengajuanCompleteBarangSpk . '%')
                            ->orWhere('ukuran_barang', 'like', '%' . $this->searchPengajuanCompleteBarangSpk . '%')
                            ->orWhere('spk_number_fsc', 'like', '%' . $this->searchPengajuanCompleteBarangSpk . '%');
                    })
                    ->OrWhere(function ($sub) {
                        $sub->where('qty_barang', 'like', '%' . $this->searchPengajuanCompleteBarangSpk . '%')
                            ->orWhere('nama_barang', 'like', '%' . $this->searchPengajuanCompleteBarangSpk . '%')
                            ->orWhere('tgl_target_datang', 'like', '%' . $this->searchPengajuanCompleteBarangSpk . '%')
                            ->orWhere('tgl_pengajuan', 'like', '%' . $this->searchPengajuanCompleteBarangSpk . '%');
                    });
            })
            ->with(['status', 'workStepList', 'instruction', 'user'])
            ->orderBy('tgl_target_datang', 'asc')
            ->paginate($this->paginatePengajuanCompleteBarangSpk);

        return view('livewire.accounting.component.pengajuan-complete-barang-spk-index', ['pengajuanCompleteBarangSpk' => $dataPengajuanCompleteBarangSpk])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function modalPengajuanCompleteBarangSpk($PengajuanBarangId, $instructionId)
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
}
