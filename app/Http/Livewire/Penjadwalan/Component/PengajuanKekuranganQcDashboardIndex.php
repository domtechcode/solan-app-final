<?php

namespace App\Http\Livewire\Penjadwalan\Component;

use App\Models\User;
use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;
use App\Events\NotificationSent;
use App\Models\PengajuanKekuranganQc;

class PengajuanKekuranganQcDashboardIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginatePengajuanKekuranganQc = 10;
    public $searchPengajuanKekuranganQc = '';

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

    protected $listeners = ['indexRender' => '$refresh'];

    public function updatingSearchPengajuanKekuranganQc()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->searchPengajuanKekuranganQc = request()->query('search', $this->searchPengajuanKekuranganQc);
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
        $dataPengajuanKekuranganQc = PengajuanKekuranganQc::where('status', 'Pending')
            ->where(function ($query) {
                $searchTerms = '%' . $this->searchPengajuanKekuranganQc . '%';
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
            ->with(['instruction'])
            ->paginate($this->paginatePengajuanKekuranganQc);

        return view('livewire.penjadwalan.component.pengajuan-kekurangan-qc-dashboard-index', ['instructionsPengajuanKekuranganQc' => $dataPengajuanKekuranganQc])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function pengajuanKekuranganQc($idPengajuan, $statePengajuan)
    {
        $updatePengajuan = PengajuanKekuranganQc::find($idPengajuan);
        
        if($statePengajuan == 'Reject') {
            $updatePengajuan->update([
                'status' => $statePengajuan,
            ]);

            $workStep = WorkStep::where('instruction_id', $updatePengajuan->instruction_id)->update([
                'status_id' => 3,
                'job_id' => 36,
            ]);

            $updatePengiriman = WorkStep::where('instruction_id', $updatePengajuan->instruction_id)->where('work_step_list_id', 36)->update([
                'state_task' => 'Running',
                'status_task' => 'Process',
                'spk_status' => 'Running',
            ]);

            $this->messageSent(['receiver' => $updatePengiriman->user_id, 'conversation' => 'SPK Kekurangan Qc Di Tolak', 'instruction_id' => $updatePengajuan->instruction_id]);
        
        }else{
            $updatePengajuan->update([
                'status' => $statePengajuan,
            ]);
    
            $this->emit('indexRender');
            $this->emit('flashMessage', [
                'type' => 'success',
                'title' => 'Pengajuan Kekurangan Qc',
                'message' => 'Data Pengajuan Kekurangan Qc berhasil disimpan',
            ]);
    
            $userDestination = User::where('role', 'Follow Up')->get();
            foreach ($userDestination as $dataUser) {
                $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Kekurangan Qc', 'instruction_id' => $updatePengajuan->instruction_id]);
            }
        }
        
    }

    public function modalInstructionDetailsPengajuanKekuranganQc($instructionId)
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

    public function modalInstructionDetailsGroupPengajuanKekuranganQc($groupId)
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
