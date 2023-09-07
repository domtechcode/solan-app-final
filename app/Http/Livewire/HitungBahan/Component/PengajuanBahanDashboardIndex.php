<?php

namespace App\Http\Livewire\HitungBahan\Component;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use App\Models\LayoutBahan;
use Livewire\WithPagination;
use App\Events\NotificationSent;
use App\Models\PengajuanBarangSpk;

class PengajuanBahanDashboardIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginateLayoutBahan = 10;
    public $searchLayoutBahan = '';

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

    public $target_datang;
    public $stock;

    protected $listeners = ['indexRender' => '$refresh'];

    public function updatingSearchLayoutBahan()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->searchLayoutBahan = request()->query('search', $this->searchLayoutBahan);
    }

    public function sumGroup($groupId)
    {
        $totalQuantityGroup = Instruction::where('group_id', $groupId)->sum('quantity');
        $totalStockGroup = Instruction::where('group_id', $groupId)->sum('stock');
        $totalQuantity = $totalQuantityGroup - $totalStockGroup;
        return $totalQuantity;
    }

    public function render()
    {
        $dataInstruction = WorkStep::where('work_step_list_id', 4)
            ->where('state_task', 'Complete')
            ->where('status_task', 'Complete')
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Close PO', 'Training Program', 'Selesai'])
            ->where(function ($query) {
                $query->whereHas('instruction', function ($instructionQuery) {
                    $instructionQuery->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
                });
            })
            ->with(['status', 'job', 'workStepList', 'instruction'])
            ->pluck('instruction_id');

        $dataLayoutBahan = LayoutBahan::whereIn('instruction_id', $dataInstruction)
            ->where('status_pengajuan', null)
            ->where(function ($query) {
                $searchTerms = '%' . $this->searchLayoutBahan . '%';
                $query->whereHas('instruction', function ($instructionQuery) use ($searchTerms) {
                    $instructionQuery
                        ->where('spk_number', 'like', $searchTerms)
                        ->orWhere('spk_type', 'like', $searchTerms)
                        ->orWhere('customer_name', 'like', $searchTerms)
                        ->orWhere('order_name', 'like', $searchTerms)
                        ->orWhere('customer_number', 'like', $searchTerms)
                        ->orWhere('code_style', 'like', $searchTerms)
                        ->orWhere('shipping_date', 'like', $searchTerms)
                        ->orWhere('ukuran_barang', 'like', $searchTerms)
                        ->orWhere('spk_number_fsc', 'like', $searchTerms);
                });
            })
            ->with('instruction')
            ->paginate($this->paginateLayoutBahan);

        return view('livewire.hitung-bahan.component.pengajuan-bahan-dashboard-index', ['instructionsLayoutBahan' => $dataLayoutBahan])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function pengajuanBahan($idPengajuanBahan, $statePengajuanBahan)
    {
        if ($statePengajuanBahan == 'Ajukan') {
            $this->validate([
                'target_datang.' . $idPengajuanBahan => 'required',
                'stock.' . $idPengajuanBahan => 'required',
            ]);            

            $updateLayoutBahan = LayoutBahan::find($idPengajuanBahan);
            $updateLayoutBahan->update([
                'status_pengajuan' => $statePengajuanBahan,
            ]);

            $keteranganBarang = 'Jenis Bahan : ' . $updateLayoutBahan->jenis_bahan . ' - Gramasi : ' . $updateLayoutBahan->gramasi . ' - Sumber Bahan : ' . $updateLayoutBahan->sumber_bahan . ' - Merk Bahan : ' . $updateLayoutBahan->merk_bahan . ' - Supplier : ' . $updateLayoutBahan->supplier . ' - Jumlah Bahan : ' . $updateLayoutBahan->jumlah_bahan . ' - Ukuran Bahan : ' . $updateLayoutBahan->panjang_plano . 'X' . $updateLayoutBahan->lebar_plano . ' - Stock : ' . $this->stock[$idPengajuanBahan];
            
            $pengajuanBahan = PengajuanBarangSpk::create([
                'instruction_id' => $updateLayoutBahan->instruction_id,
                'work_step_list_id' => 5,
                'nama_barang' => $updateLayoutBahan->jenis_bahan,
                'user_id' => Auth()->user()->id,
                'tgl_pengajuan' => Carbon::now(),
                'tgl_target_datang' => $this->target_datang[$idPengajuanBahan],
                'qty_barang' => $updateLayoutBahan->jumlah_bahan,
                'keterangan' => $keteranganBarang,
                'status_id' => 8,
                'state' => 'Purchase',
            ]);
        } else {
            $updateLayoutBahan = LayoutBahan::where('id', $idPengajuanBahan)->update([
                'status_pengajuan' => $statePengajuanBahan,
            ]);
        }

        $userDestination = User::where('role', 'Purchase')->get();
        foreach ($userDestination as $dataUser) {
            $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'Pengajuan Bahan', 'instruction_id' => $updateLayoutBahan->instruction_id]);
        }

        $this->target_datang = null;
        $this->emit('indexRender');
        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Pengajuan Bahan',
            'message' => 'Berhasil data pengajuan bahan disimpan',
        ]);
    }

    public function modalInstructionDetailsLayoutBahan($instructionId)
    {
        $this->selectedInstruction = Instruction::find($instructionId);
        $this->selectedWorkStep = WorkStep::where('instruction_id', $instructionId)
            ->with('workStepList', 'user', 'machine')
            ->get();
        $this->selectedFileContoh = Files::where('instruction_id', $instructionId)
            ->where('type_file', 'contoh')
            ->get();
        $this->selectedFileArsip = Files::where('instruction_id', $instructionId)
            ->where('type_file', 'arsip')
            ->get();
        $this->selectedFileAccounting = Files::where('instruction_id', $instructionId)
            ->where('type_file', 'accounting')
            ->get();
        $this->selectedFileLayout = Files::where('instruction_id', $instructionId)
            ->where('type_file', 'layout')
            ->get();
        $this->selectedFileSample = Files::where('instruction_id', $instructionId)
            ->where('type_file', 'sample')
            ->get();
    }

    public function modalInstructionDetailsGroupLayoutBahan($groupId)
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

    public function messageSent($arguments)
    {
        $createdMessage = 'info';
        $selectedConversation = $arguments['conversation'];
        $receiverUser = $arguments['receiver'];
        $instruction_id = $arguments['instruction_id'];

        event(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, $receiverUser));
    }
}
