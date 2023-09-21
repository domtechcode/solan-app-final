<?php

namespace App\Http\Livewire\FollowUp\Component;

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

class CompleteDashboardIndex extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginateComplete = 10;
    public $searchComplete = '';
    public $notes = [];

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
    public $filearsiprevisi = [];
    public $filearsipacc = [];
    public $alasan_revisi;
    public $workSteps;

    protected $listeners = ['indexRender' => '$refresh'];

    public function updatingSearchComplete()
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
        $this->searchComplete = request()->query('search', $this->searchComplete);
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
        $dataComplete = WorkStep::where('work_step_list_id', 1)
            ->whereIn('spk_status', ['Selesai', 'Kekurangan QTY Kirim'])
            ->where(function ($query) {
                $searchTerms = '%' . $this->searchComplete . '%';
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
            ->paginate($this->paginateComplete);

        return view('livewire.follow-up.component.complete-dashboard-index', ['instructionsComplete' => $dataComplete])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function revisiSample()
    {
        $this->validate([
            'alasan_revisi' => 'required',
            // 'filearsiprevisi' => 'required',
        ]);

        $updateAlasanRevisi = Instruction::find($this->selectedInstruction->id);

        if ($this->alasan_revisi) {
            // Ambil alasan pause yang sudah ada dari database
            $existingCatatanAlasanRevisi = json_decode($updateAlasanRevisi->alasan_revisi, true);

            // Tambahkan alasan pause yang baru ke dalam array existingCatatanProsesPengerjaan
            $timestampedKeterangan = $this->alasan_revisi . ' - [' . now() . ']';
            $existingCatatanAlasanRevisi[] = $timestampedKeterangan;

            // Simpan data ke database sebagai JSON
            $updateAlasanRevisi->update([
                'alasan_revisi' => json_encode($existingCatatanAlasanRevisi),
            ]);
        }

        $updateAlasanRevisi->update([
            'count' => $updateAlasanRevisi->count + 1,
        ]);

        if (!empty($this->notes)) {
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

        if (!empty($this->filearsiprevisi)) {
            $folder = 'public/' . $updateAlasanRevisi->spk_number . '/checker';

            $norevisi = Files::where('instruction_id', $updateAlasanRevisi->id)
                ->where('type_file', 'arsip')
                ->count();

            foreach ($this->filearsiprevisi as $file) {

                $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                $fileName = $updateAlasanRevisi->id . '-file-arsip-sample-revisi-customer-' . $norevisi . '.' . $extension;

                Storage::putFileAs($folder, $file, $fileName);
                $norevisi++;

                Files::create([
                    'instruction_id' => $updateAlasanRevisi->id,
                    'user_id' => Auth()->user()->id,
                    'type_file' => 'arsip',
                    'file_name' => $fileName,
                    'file_path' => $folder,
                ]);
            }
        }

        $dataCurrentWorkStep = WorkStep::where('instruction_id', $updateAlasanRevisi->id)->update([
            'spk_status' => 'Running',
            'state_task' => 'Not Running',
            'status_task' => 'Waiting Running',
            'target_date' => null,
            'schedule_date' => null,
            'flag' => null,
        ]);

        $workStepCurrent = WorkStep::where('instruction_id', $updateAlasanRevisi->id)
            ->where('step', 0)
            ->first();
        $workStepNext = WorkStep::where('instruction_id', $updateAlasanRevisi->id)
            ->where('step', 1)
            ->first();

        $workStepCurrent->update([
            'state_task' => 'Running',
            'status_task' => 'Process',
        ]);

        $workStepNext->update([
            'state_task' => 'Running',
            'status_task' => 'Pending Approved',
            'dikerjakan' => Carbon::now()->toDateTimeString(),
            'schedule_date' => Carbon::now(),
            'target_date' => Carbon::now(),
        ]);

        $dataCurrentWorkStepStatusJob = WorkStep::where('instruction_id', $updateAlasanRevisi->id)->update([
            'status_id' => 1,
            'job_id' => $workStepNext->work_step_list_id,
        ]);

        //notif
        if ($workStepNext->work_step_list_id == 4) {
            $userDestination = User::where('role', 'Stock')->get();
            foreach ($userDestination as $dataUser) {
                $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Revisi Sample', 'instruction_id' => $updateAlasanRevisi->id]);
            }
        } elseif ($workStepNext->work_step_list_id == 5) {
            $userDestination = User::where('role', 'Hitung Bahan')->get();
            foreach ($userDestination as $dataUser) {
                $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Revisi Sample', 'instruction_id' => $updateAlasanRevisi->id]);
            }
        } else {
            $userDestination = User::where('role', 'Penjadwalan')->get();
            foreach ($userDestination as $dataUser) {
                $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Revisi Sample', 'instruction_id' => $updateAlasanRevisi->id]);
            }
        }

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Create Instruksi Kerja',
            'message' => 'Berhasil membuat instruksi kerja',
        ]);

        $this->notes = [];
        $this->alasan_revisi = null;

        $this->dispatchBrowserEvent('close-modal-revisi-sample');
    }

    public function accCustomer()
    {
        $this->validate([
            'filearsipacc' => 'required',
        ]);

        $dataCurrentWorkStepAcc = WorkStep::where('instruction_id', $this->selectedInstruction->id)->update([
            'spk_status' => 'Acc',
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Acc Instruksi Kerja',
            'message' => 'Berhasil Acc instruksi kerja',
        ]);

        $updateAcc = Instruction::find($this->selectedInstruction->id);

        if (!empty($this->filearsipacc)) {
            $folder = 'public/' . $updateAcc->spk_number . '/checker';

            $noarispacc = Files::where('instruction_id', $updateAcc->id)
                ->where('type_file', 'arsip')
                ->count();
            foreach ($this->filearsipacc as $file) {
                $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                $fileName = $updateAcc->id . '-file-arsip-sample-acc-customer-' . $noarispacc . '.' . $extension;
                Storage::putFileAs($folder, $file, $fileName);
                $noarispacc++;

                Files::create([
                    'instruction_id' => $updateAcc->id,
                    'user_id' => Auth()->user()->id,
                    'type_file' => 'arsip',
                    'file_name' => $fileName,
                    'file_path' => $folder,
                ]);
            }
        }

        $this->dispatchBrowserEvent('close-modal-revisi-sample');
    }

    public function modalInstructionDetailsComplete($instructionId)
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

    public function modalInstructionDetailsRevisiSample($instructionId)
    {
        $this->notes = [];
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

    public function modalInstructionDetailsGroupComplete($groupId)
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
