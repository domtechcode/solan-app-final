<?php

namespace App\Http\Livewire\Stock\Component;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Storage;

class RejectDashboardIndex extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginateReject = 10;
    public $searchReject = '';

    public $catatan;
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

    public $stock;
    public $workSteps;
    public $fileRincian = [];
    public $keteranganReject;
    public $catatanHitungBahan;

    protected $listeners = ['indexRender' => '$refresh'];

    public function updatingSearchReject()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->searchReject = request()->query('search', $this->searchReject);
    }

    public function render()
    {
        $dataReject = WorkStep::where('work_step_list_id', 4)
            ->where('state_task', 'Running')
            ->whereIn('status_task', ['Reject', 'Reject Requirements'])
            ->where('spk_status', 'Running')
            ->where(function ($query) {
                $searchTerms = '%' . $this->searchReject . '%';
                $query
                    ->whereHas('instruction', function ($instructionQuery) use ($searchTerms) {
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
            ->join('instructions', 'work_steps.instruction_id', '=', 'instructions.id')
            ->select('work_steps.*')
            ->with(['status', 'job', 'workStepList', 'instruction'])
            ->orderBy('instructions.shipping_date', 'asc')
            ->paginate($this->paginateReject);

        return view('livewire.stock.component.reject-dashboard-index', ['instructionsReject' => $dataReject])
            ->extends('layouts.app')
            ->section('content');
    }

    public function saveReject()
    {
        $this->validate([
            'stock' => 'required',
        ]);

        if (isset($this->notes)) {
            $this->validate([
                'notes.*.tujuan' => 'required',
                'notes.*.catatan' => 'required',
            ]);

            foreach ($this->notes as $input) {
                $catatan = Catatan::create([
                    'tujuan' => $input['tujuan'],
                    'catatan' => $input['catatan'],
                    'kategori' => 'catatan',
                    'instruction_id' => $this->selectedInstruction->id,
                    'user_id' => Auth()->user()->id,
                ]);
            }
        }

        if ($this->selectedInstruction->quantity < currency_convert($this->stock)) {
            $this->emit('flashMessage', [
                'type' => 'error',
                'title' => 'Error Stock',
                'message' => 'Stock tidak boleh lebih dari quantity',
            ]);
        } else {
            $updateStock = Instruction::where('id', $this->selectedInstruction->id)->update([
                'stock' => currency_convert($this->stock),
            ]);

            $updateTask = WorkStep::where('instruction_id', $this->selectedInstruction->id)
                ->where('work_step_list_id', 4)
                ->first();

            if ($updateTask) {
                $updateTask->update([
                    'state_task' => 'Complete',
                    'status_task' => 'Complete',
                    'selesai' => Carbon::now()->toDateTimeString(),
                    'target_time' => 1,
                ]);

                $updateNextStep = WorkStep::find($updateTask->reject_from_id);

                if ($updateNextStep) {
                    if ($updateTask->reject_from_status == 1) {
                        $updateNextStep->update([
                            'state_task' => 'Running',
                            'status_task' => 'Pending Approved',
                            'schedule_date' => Carbon::now(),
                        ]);

                        $updateStatusJob = WorkStep::where('instruction_id', $this->selectedInstruction->id)->update([
                            'status_id' => $updateTask->reject_from_status,
                            'job_id' => $updateTask->reject_from_job,
                        ]);
                    } else {
                        $updateNextStep->update([
                            'state_task' => 'Running',
                            'status_task' => 'Process',
                            'schedule_date' => Carbon::now(),
                        ]);

                        $updateStatusJob = WorkStep::where('instruction_id', $this->selectedInstruction->id)->update([
                            'status_id' => $updateTask->reject_from_status,
                            'job_id' => $updateTask->reject_from_job,
                        ]);
                    }
                }

                $updateTask->update([
                    'reject_from_id' => NULL,
                    'reject_from_status' => NULL,
                    'reject_from_job' => NULL,
                ]);
            }

            if ($this->fileRincian) {
                $folder = 'public/' . $this->selectedInstruction->spk_number . '/stock';

                $norincianstock = 1;
                foreach ($this->fileRincian as $file) {
                    $fileName = $this->selectedInstruction->spk_number . '-file-rincian-stock-' . $norincianstock . '.' . $file->getClientOriginalExtension();
                    Storage::putFileAs($folder, $file, $fileName);
                    $norincianstock++;

                    Files::create([
                        'instruction_id' => $this->selectedInstruction->id,
                        'user_id' => Auth()->user()->id,
                        'type_file' => 'arsip',
                        'file_name' => $fileName,
                        'file_path' => $folder,
                    ]);
                }
            }

            $userDestination = User::where('role', 'Penjadwalan')->get();
            foreach ($userDestination as $dataUser) {
                $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Telah Selesai', 'instruction_id' => $this->selectedInstruction->id]);
            }
            event(new IndexRenderEvent('refresh'));

            $this->emit('flashMessage', [
                'type' => 'success',
                'title' => 'Stock Instruksi Kerja',
                'message' => 'Data berhasil disimpan',
            ]);

            $this->reset();
            $this->dispatchBrowserEvent('pondReset');
            $this->dispatchBrowserEvent('close-modal-reject-spk-stock');
        }
    }

    public function rejectSpkFollowUp()
    {
        $this->validate([
            'keteranganReject' => 'required',
        ]);

        if (isset($this->notes)) {
            $this->validate([
                'notes.*.tujuan' => 'required',
                'notes.*.catatan' => 'required',
            ]);

            foreach ($this->notes as $input) {
                $catatan = Catatan::create([
                    'tujuan' => $input['tujuan'],
                    'catatan' => $input['catatan'],
                    'kategori' => 'catatan',
                    'instruction_id' => $this->selectedInstruction->id,
                    'user_id' => Auth()->user()->id,
                ]);
            }
        }

        $workStepCurrent = WorkStep::where('instruction_id', $this->selectedInstruction->id)
            ->where('work_step_list_id', 4)
            ->first();
        $workStepDestination = WorkStep::where('instruction_id', $this->selectedInstruction->id)
            ->where('work_step_list_id', 1)
            ->first();

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

        $this->keteranganReject = null;
        $this->dispatchBrowserEvent('close-modal-new-spk-stock');
        $this->messageSent(['conversation' => 'SPK Reject dari Stock', 'receiver' => $workStepDestination->user_id, 'instruction_id' => $this->selectedInstruction->id]);
        event(new IndexRenderEvent('refresh'));
    }

    public function modalInstructionStockRejectSpk($instructionId)
    {
        $this->reset();

        $this->catatan = Catatan::where('instruction_id', $instructionId)
            ->where('kategori', 'catatan')
            ->where('tujuan', 4)
            ->get();
        $this->selectedInstruction = Instruction::find($instructionId);
        $this->stock = $this->selectedInstruction->stock;
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

        $this->workSteps = WorkStep::where('instruction_id', $instructionId)
            ->with('workStepList')
            ->get();
    }

    public function modalInstructionDetailsGroupReject($groupId)
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
