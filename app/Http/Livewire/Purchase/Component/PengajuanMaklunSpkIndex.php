<?php

namespace App\Http\Livewire\Purchase\Component;

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
use App\Models\FormPengajuanMaklun;

class PengajuanMaklunSpkIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];
 
    public $paginate = 10;
    public $search = '';

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

    public $dataMaklun;

    protected $listeners = ['indexRender' => 'renderIndex'];

    public function renderIndex()
    {
        $this->reset();
    }

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }
    
    public function render()
    {
        $dataPengajuanMaklunSpk = FormPengajuanMaklun::where('status', 'Pengajuan Purchase')
                ->with(['instruction'])
                ->orderBy('tgl_keluar', 'asc')
                ->paginate($this->paginate);

        return view('livewire.purchase.component.pengajuan-maklun-spk-index', ['pengajuanMaklunSpk' => $dataPengajuanMaklunSpk])

        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Dashboard']);
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

        $this->total_harga =  $hargaSatuanSelected * ($qtyPurchaseSelected - $stockSelected);
        $this->total_harga = currency_idr($this->total_harga);
    }

    public function modalPengajuanBarangSpk($PengajuanBarangId, $instructionId)
    {
        $this->selectedInstruction = Instruction::find($instructionId);

        $dataworkStepHitungBahanNew = WorkStep::where('instruction_id', $instructionId)->where('work_step_list_id', 5)->first();
        if(isset($dataworkStepHitungBahanNew)){
            $this->workStepHitungBahanNew = $dataworkStepHitungBahanNew->id;
        }

        $this->dataBarang = PengajuanBarangSpk::find($PengajuanBarangId);

        $this->harga_satuan = currency_idr($this->dataBarang->harga_satuan);
        $this->qty_purchase = currency_idr($this->dataBarang->qty_purchase);
        $this->stock = currency_idr($this->dataBarang->stock);
        $this->total_harga = currency_idr($this->dataBarang->total_harga);

        $this->dispatchBrowserEvent('show-detail-pengajuan-barang-spk');
    }

    public function modalInstructionDetailsGroupPengajuanBarangSpk($groupId)
    {
        $this->selectedGroupParent = Instruction::where('group_id', $groupId)->where('group_priority', 'parent')->first();
        $this->selectedGroupChild = Instruction::where('group_id', $groupId)->where('group_priority', 'child')->get();

        $this->selectedInstructionParent = Instruction::find($this->selectedGroupParent->id);
        $this->selectedWorkStepParent = WorkStep::where('instruction_id', $this->selectedGroupParent->id)->with('workStepList', 'user', 'machine')->get();
        $this->selectedFileContohParent = Files::where('instruction_id', $this->selectedGroupParent->id)->where('type_file', 'contoh')->get();
        $this->selectedFileArsipParent = Files::where('instruction_id', $this->selectedGroupParent->id)->where('type_file', 'arsip')->get();
        $this->selectedFileAccountingParent = Files::where('instruction_id', $this->selectedGroupParent->id)->where('type_file', 'accounting')->get();
        $this->selectedFileLayoutParent = Files::where('instruction_id', $this->selectedGroupParent->id)->where('type_file', 'layout')->get();
        $this->selectedFileSampleParent = Files::where('instruction_id', $this->selectedGroupParent->id)->where('type_file', 'sample')->get();

        $this->selectedInstructionChild = Instruction::where('group_id', $groupId)->where('group_priority', 'child')->with('workstep', 'workstep.workStepList', 'workstep.user', 'workstep.machine', 'fileArsip')->get();

        $this->dispatchBrowserEvent('show-detail-instruction-modal-group-pengajuan-barang-spk');
    }

    public function messageSent($arguments)
    {
        $createdMessage = "info";
        $selectedConversation = $arguments['conversation'];
        $receiverUser = $arguments['receiver'];
        $instruction_id = $arguments['instruction_id'];

        broadcast(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, $receiverUser));
    }
}
