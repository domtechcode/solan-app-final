<?php

namespace App\Http\Livewire\Component;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;

class HistoryPengajuanBarangPersonalIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginateAcc = 10;
    public $searchAcc = '';
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
    public $alasan_revisi;
    public $workSteps;

    protected $listeners = ['indexRender' => '$refresh'];

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
        $this->searchAcc = request()->query('search', $this->searchAcc);
    }

    public function render()
    {
        $dataAcc = PengajuanBarang::where('user_id', Auth()->user()->id)
            ->orWhere('spk_number', 'like', $searchTerms)
            ->orWhere('spk_type', 'like', $searchTerms)
            ->orWhere('customer_name', 'like', $searchTerms)
            ->orWhere('order_name', 'like', $searchTerms)
            ->orWhere('customer_number', 'like', $searchTerms)
            ->orWhere('code_style', 'like', $searchTerms)
            ->orWhere('shipping_date', 'like', $searchTerms)
            ->orderBy('tgl_pengajuan', 'asc')
            ->paginate($this->paginateAcc);

        return view('livewire.component.history-pengajuan-barang-personal-index', ['instructionsAcc' => $dataAcc])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function revisiSample()
    {
        $this->validate([
            'alasan_revisi' => 'required',
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

        $dataCurrentWorkStep = WorkStep::where('instruction_id', $updateAlasanRevisi->id)->update([
            'spk_status' => 'Running',
            'state_task' => 'Not Running',
            'status_task' => 'Waiting Running',
            'target_date' => null,
            'schedule_date' => null,
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
}
