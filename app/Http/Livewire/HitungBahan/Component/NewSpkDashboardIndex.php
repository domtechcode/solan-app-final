<?php

namespace App\Http\Livewire\HitungBahan\Component;

use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;
use App\Events\NotificationSent;

class NewSpkDashboardIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];
 
    public $paginate = 10;
    public $search = '';
    public $data;

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

    public $keteranganReject;

    protected $listeners = ['notifSent' => 'refreshIndex', 'indexRender' => 'renderIndex'];

    public function refreshIndex()
    {
        $this->render();
    }

    public function renderIndex()
    {
        $this->render();
    }

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }

    public function render()
    {
        $data = WorkStep::where('work_step_list_id', 5)
                ->where('state_task', 'Running')
                ->whereIn('status_task', ['Pending Approved', 'Process', 'Revisi Qty'])
                ->where('spk_status', 'Running')
                ->where(function ($query) {
                    $query->where(function ($subQuery) {
                        $subQuery->whereIn('status_id', [1, 26]);
                    })->orWhere(function ($subQuery) {
                        $subQuery->where('status_id', 2)
                            ->where('user_id', Auth()->user()->id);
                    });
                })
                ->whereHas('instruction', function ($query) {
                    $query->where('spk_number', 'like', '%' . $this->search . '%')
                        ->orWhere('spk_type', 'like', '%' . $this->search . '%')
                        ->orWhere('customer_name', 'like', '%' . $this->search . '%')
                        ->orWhere('order_name', 'like', '%' . $this->search . '%')
                        ->orWhere('customer_number', 'like', '%' . $this->search . '%')
                        ->orWhere('code_style', 'like', '%' . $this->search . '%')
                        ->orWhere('shipping_date', 'like', '%' . $this->search . '%')
                        ->orderBy('shipping_date', 'asc');
                })
                
                ->with(['status', 'job', 'workStepList'])
                ->paginate($this->paginate);

        return view('livewire.hitung-bahan.component.new-spk-dashboard-index', ['instructions' => $data])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Dashboard']);
    }

    public function modalInstructionDetails($instructionId)
    {
        $this->selectedInstruction = Instruction::find($instructionId);
        $this->selectedWorkStep = WorkStep::where('instruction_id', $instructionId)->with('workStepList', 'user', 'machine')->get();
        $this->selectedFileContoh = Files::where('instruction_id', $instructionId)->where('type_file', 'contoh')->get();
        $this->selectedFileArsip = Files::where('instruction_id', $instructionId)->where('type_file', 'arsip')->get();
        $this->selectedFileAccounting = Files::where('instruction_id', $instructionId)->where('type_file', 'accounting')->get();
        $this->selectedFileLayout = Files::where('instruction_id', $instructionId)->where('type_file', 'layout')->get();
        $this->selectedFileSample = Files::where('instruction_id', $instructionId)->where('type_file', 'sample')->get();

        $this->dispatchBrowserEvent('show-detail-instruction-modal');
    }

    public function modalInstructionDetailsGroup($groupId)
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

        $this->dispatchBrowserEvent('show-detail-instruction-modal-group');
    }

    public function rejectSpk()
    {
        $this->validate([
            'keteranganReject' => 'required',
        ]);

        $workStepCurrent = WorkStep::where('instruction_id', $this->selectedInstruction->id)->where('work_step_list_id', 5)->first();
        $workStepDestination = WorkStep::where('instruction_id', $this->selectedInstruction->id)->where('work_step_list_id', 1)->first();
        
        $workStepDestination->update([
            'status_task' => 'Reject',
            'reject_from_id' => $workStepCurrent->id,
            'reject_from_status' => $workStepCurrent->status_id,
            'reject_from_job' => $workStepCurrent->job_id,
            'count_reject' => $workStepDestination->count_reject + 1,
        ]);
        
        $updateJobStatus = WorkStep::where('instruction_id', $this->selectedInstruction->id)->update([
            'status_id' => 3,
            'job_id' => $workStepDestination->work_step_list_id,
        ]);

        $updateKeterangan = Catatan::create([
            'tujuan' => 1,
            'catatan' => $this->keteranganReject,
            'kategori' => 'reject',
            'instruction_id' => $this->selectedInstruction->id,
            'user_id' => Auth()->user()->id,
        ]);

        $workStepCurrent->update([
            'user_id' => Auth()->user()->id,
            'status_task' => 'Waiting For Repair',
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Reject Instruksi Kerja',
            'message' => 'Berhasil reject instruksi kerja',
        ]);

        $this->emit('indexRender');
        $this->keteranganReject = '';
        $this->dispatchBrowserEvent('close-modal');
        $this->messageSent(['selectedConversation' => 'SPK Reject dari Estimator','receiver' => $workStepDestination->user_id, 'instruction_id' => $this->selectedInstruction->id]);
    }

    public function messageSent($arguments)
    {
        $createdMessage = "error";
        $selectedConversation = $arguments['selectedConversation'];
        $receiverUser = $arguments['receiver'];
        $instruction_id = $arguments['instruction_id'];

        broadcast(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, $receiverUser));
    }
}
