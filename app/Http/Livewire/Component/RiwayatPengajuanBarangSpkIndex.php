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

class RiwayatPengajuanBarangSpkIndex extends Component
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

    public $dataBarang;
    public $harga_satuan;
    public $qty_purchase;
    public $total_harga;
    public $stock;
    public $file_pengajuan = [];

    protected $listeners = ['indexRender' => '$refresh'];

    public function updatingSearchRiwayatPengajuanBarangSpk()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->searchRiwayatPengajuanBarangSpk = request()->query('search', $this->searchRiwayatPengajuanBarangSpk);
    }

    public function render()
    {
        $dataRiwayatPengajuanBarangSpk = PengajuanBarangSpk::where('user_id', Auth()->user()->id)
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

        return view('livewire.component.riwayat-pengajuan-barang-spk-index', ['riwayatPengajuanBarangSpk' => $dataRiwayatPengajuanBarangSpk])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function modalRiwayatPengajuanBarangSpk($PengajuanBarangId, $instructionId)
    {
        $this->selectedInstruction = Instruction::find($instructionId);

        $dataworkStepHitungBahanNew = WorkStep::where('instruction_id', $instructionId)
            ->where('work_step_list_id', 5)
            ->first();

        if (isset($dataworkStepHitungBahanNew)) {
            $this->workStepHitungBahanNew = $dataworkStepHitungBahanNew->id;
        }

        $this->dataBarang = PengajuanBarangSpk::find($PengajuanBarangId);

        if (isset($this->dataBarang) && $this->dataBarang->harga_satuan != null) {
            $this->harga_satuan = currency_idr($this->dataBarang->harga_satuan);
            $this->qty_purchase = currency_idr($this->dataBarang->qty_purchase);
            $this->stock = currency_idr($this->dataBarang->stock);
            $this->total_harga = currency_idr($this->dataBarang->total_harga);

            if(isset($this->dataBarang->filesPengajuanBarangSpk)) {
                foreach ($this->dataBarang->filesPengajuanBarangSpk as $data) {
                    $dataFilePengajuan = [
                        'file_name' => $data['file_name'],
                        'file_path' => $data['file_path'],
                    ];

                    $this->file_pengajuan [] = $dataFilePengajuan;
                }
            }else{
                $this->file_pengajuan = [];
            }

        } else {
            $this->harga_satuan = '';
            $this->qty_purchase = '';
            $this->stock = '';
            $this->total_harga = '';
            $this->file_pengajuan = [];
        }
    }

    public function modalInstructionDetailsGroupRiwayatPengajuanBarangSpk($groupId)
    {
        $this->selectedGroupParent = Instruction::where('group_id', $groupId)
            ->where('group_priority', 'parent')
            ->first();
        $this->selectedGroupChild = Instruction::where('group_id', $groupId)
            ->where('group_priority', 'child')
            ->get();

        $this->selectedInstructionParent = Instruction::find($this->selectedGroupParent->id);
        $this->selectedWorkStepParent = WorkStep::where('instruction_id', $this->selectedGroupParent->id)
            ->with('workStepList', 'user', 'machine')
            ->get();
        $this->selectedFileContohParent = Files::where('instruction_id', $this->selectedGroupParent->id)
            ->where('type_file', 'contoh')
            ->get();
        $this->selectedFileArsipParent = Files::where('instruction_id', $this->selectedGroupParent->id)
            ->where('type_file', 'arsip')
            ->get();
        $this->selectedFileAccountingParent = Files::where('instruction_id', $this->selectedGroupParent->id)
            ->where('type_file', 'accounting')
            ->get();
        $this->selectedFileLayoutParent = Files::where('instruction_id', $this->selectedGroupParent->id)
            ->where('type_file', 'layout')
            ->get();
        $this->selectedFileSampleParent = Files::where('instruction_id', $this->selectedGroupParent->id)
            ->where('type_file', 'sample')
            ->get();

        $this->selectedInstructionChild = Instruction::where('group_id', $groupId)
            ->where('group_priority', 'child')
            ->with('workstep', 'workstep.workStepList', 'workstep.user', 'workstep.machine', 'fileArsip')
            ->get();
    }
}
