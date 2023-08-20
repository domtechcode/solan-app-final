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

class NewSpkDashboardIndex extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginateNewSpk = 10;
    public $searchNewSpk = '';

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
    public $fileRincian = [];
    public $keteranganReject;
    public $notes = [];
    public $workSteps;

    protected $listeners = ['indexRender' => '$refresh'];

    public function updatingSearchNewSpk()
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
        $this->searchNewSpk = request()->query('search', $this->searchNewSpk);
    }

    public function render()
    {
        $dataNewSpk = WorkStep::where('work_step_list_id', 4)
            ->where('state_task', 'Running')
            ->whereIn('status_task', ['Pending Approved', 'Process'])
            ->where('spk_status', 'Running')
            ->whereIn('status_id', [1, 2])
            ->whereHas('instruction', function ($query) {
                $query
                    ->where('spk_number', 'like', '%' . $this->searchNewSpk . '%')
                    ->orWhere('spk_type', 'like', '%' . $this->searchNewSpk . '%')
                    ->orWhere('customer_name', 'like', '%' . $this->searchNewSpk . '%')
                    ->orWhere('order_name', 'like', '%' . $this->searchNewSpk . '%')
                    ->orWhere('customer_number', 'like', '%' . $this->searchNewSpk . '%')
                    ->orWhere('code_style', 'like', '%' . $this->searchNewSpk . '%')
                    ->orWhere('shipping_date', 'like', '%' . $this->searchNewSpk . '%');
            })
            ->join('instructions', 'work_steps.instruction_id', '=', 'instructions.id')
            ->select('work_steps.*')
            ->with(['status', 'job', 'workStepList', 'instruction'])
            ->orderBy('instructions.shipping_date', 'asc')
            ->paginate($this->paginateNewSpk);

        return view('livewire.stock.component.new-spk-dashboard-index', ['instructionsNewSpk' => $dataNewSpk])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function save()
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
                    'instruction_id' => $updateAlasanRevisi->id,
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
        } elseif ($this->selectedInstruction->quantity == currency_convert($this->stock)) {
            $updateWorkStep = WorkStep::where('instruction_id', $this->selectedInstruction->id)
                ->whereNotIn('work_step_list_id', [1, 2, 13, 14, 33, 34, 35, 36])
                ->update([
                    'state_task' => 'Complete',
                    'status_task' => 'Complete',
                    'selesai' => Carbon::now(),
                ]);

            $updateJadwal = WorkStep::where('instruction_id', $this->selectedInstruction->id)
                ->where('work_step_list_id', 2)
                ->update([
                    'state_task' => 'Running',
                    'status_task' => 'Pending Approved',
                    'dikerjakan' => Carbon::now()->toDateTimeString(),
                    'schedule_date' => Carbon::now(),
                ]);

            $updateJadwal = WorkStep::where('instruction_id', $this->selectedInstruction->id)
                ->whereIn('work_step_list_id', [35, 36])
                ->update([
                    'state_task' => 'Running',
                    'status_task' => 'Pending Start',
                    'dikerjakan' => Carbon::now()->toDateTimeString(),
                    'schedule_date' => Carbon::now(),
                ]);

            $updateStatusJob = WorkStep::where('instruction_id', $this->selectedInstruction->id)->update([
                'status_id' => 1,
                'job_id' => 2,
            ]);

            $updateStock = Instruction::where('id', $this->selectedInstruction->id)->update([
                'stock' => currency_convert($this->stock),
            ]);

            $updateTask = WorkStep::where('instruction_id', $this->selectedInstruction->id)
                ->where('work_step_list_id', 4)
                ->update([
                    'state_task' => 'Complete',
                    'status_task' => 'Complete',
                    'selesai' => Carbon::now()->toDateTimeString(),
                    'target_time' => 1,
                ]);

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
                        'type_file' => 'rincian-stock',
                        'file_name' => $fileName,
                        'file_path' => $folder,
                    ]);
                }
            }

            $userDestination = User::where('role', 'Penjadwalan')->get();
            foreach ($userDestination as $dataUser) {
                $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Selesai Cari Stock', 'instruction_id' => $this->selectedInstruction->id]);
            }
            event(new IndexRenderEvent('refresh'));

            $this->emit('flashMessage', [
                'type' => 'success',
                'title' => 'Stock Instruksi Kerja',
                'message' => 'Data berhasil disimpan',
            ]);

            $this->reset();
            $this->dispatchBrowserEvent('pondReset');
            $this->dispatchBrowserEvent('close-modal-new-spk');
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

                $updateNextStep = WorkStep::where('instruction_id', $this->selectedInstruction->id)
                    ->where('step', $updateTask->step + 1)
                    ->first();

                if ($updateNextStep) {
                    $updateNextStep->update([
                        'state_task' => 'Running',
                        'status_task' => 'Pending Approved',
                        'schedule_date' => Carbon::now(),
                    ]);

                    $updateStatusJob = WorkStep::where('instruction_id', $this->selectedInstruction->id)->update([
                        'status_id' => 1,
                        'job_id' => $updateNextStep->work_step_list_id,
                    ]);
                }
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
                        'type_file' => 'rincian-stock',
                        'file_name' => $fileName,
                        'file_path' => $folder,
                    ]);
                }
            }

            if ($updateNextStep->work_step_list_id == 5) {
                $userDestination = User::where('role', 'Hitung Bahan')->get();
                foreach ($userDestination as $dataUser) {
                    $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Telah Selesai', 'instruction_id' => $this->selectedInstruction->id]);
                }
                event(new IndexRenderEvent('refresh'));
            } else {
                $userDestination = User::where('role', 'Penjadwalan')->get();
                foreach ($userDestination as $dataUser) {
                    $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Telah Selesai', 'instruction_id' => $this->selectedInstruction->id]);
                }
                event(new IndexRenderEvent('refresh'));
            }

            $this->emit('flashMessage', [
                'type' => 'success',
                'title' => 'Stock Instruksi Kerja',
                'message' => 'Data berhasil disimpan',
            ]);

            $this->reset();
            $this->dispatchBrowserEvent('pondReset');
            $this->dispatchBrowserEvent('close-modal-new-spk');
        }
    }

    public function rejectSpk()
    {
        $this->validate([
            'keteranganReject' => 'required',
        ]);

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
        $this->dispatchBrowserEvent('close-modal-new-spk');
        $this->messageSent(['conversation' => 'SPK Reject dari Stock', 'receiver' => $workStepDestination->user_id, 'instruction_id' => $this->selectedInstruction->id]);
        event(new IndexRenderEvent('refresh'));
    }

    public function modalInstructionStockNewSpk($instructionId)
    {
        $updateStatusStock = WorkStep::where('instruction_id', $instructionId)
            ->where('work_step_list_id', 4)
            ->update([
                'user_id' => Auth()->user()->id,
                'status_id' => 2,
                'status_task' => 'Process',
            ]);
        $this->catatan = Catatan::where('instruction_id', $instructionId)
            ->where('kategori', 'catatan')
            ->where('tujuan', 4)
            ->get();
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

        $this->workSteps = WorkStep::where('instruction_id', $instructionId)
            ->with('workStepList')
            ->get();
    }

    public function modalInstructionDetailsNewSpk($instructionId)
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

    public function modalInstructionDetailsGroupNewSpk($groupId)
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
