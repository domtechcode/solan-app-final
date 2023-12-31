<?php

namespace App\Http\Livewire\Penjadwalan\Component;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Files;
use App\Models\Catatan;
use App\Models\Machine;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use App\Models\WorkStepList;
use Livewire\WithPagination;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use App\Models\PengajuanBarangSpk;

class NewSpkDashboardIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginateNewSpk = 10;
    public $searchNewSpk = '';

    public $dataWorkSteps;
    public $dataUsers;
    public $dataMachines;
    public $workSteps = [];

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
    public $workStepHitungBahan;
    public $notes;
    public $tujuanReject;
    public $keteranganReject;

    public $pengajuanBarang;
    public $historyPengajuanBarang;

    public $sendNotes = [];
    public $historyCatatan = [];

    protected $listeners = ['indexRender' => '$refresh'];

    public function updatingSearchNewSpk()
    {
        $this->resetPage();
    }

    public function addEmptyNote()
    {
        $this->sendNotes[] = '';
    }

    public function removeNote($index)
    {
        unset($this->sendNotes[$index]);
        $this->sendNotes = array_values($this->sendNotes);
    }

    public function addField($index)
    {
        array_splice($this->workSteps, $index + 1, 0, [
            [
                'work_step_list_id' => null,
                'target_date' => null,
                'schedule_date' => null,
                'target_time' => null,
                'user_id' => null,
                'machine_id' => null,
                'state_task' => 'Not Running',
                'status_task' => 'Pending Start',
            ],
        ]);

        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target' => '#work_step_list_id-' . $index,
        ]);

        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target' => '#user_id-' . $index,
        ]);

        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target' => '#machine_id-' . $index,
        ]);
    }

    public function removeField($index)
    {
        unset($this->workSteps[$index]);
        $this->workSteps = array_values($this->workSteps);
    }

    public function addPengajuanBarang($workStepListId)
    {
        $dataWorkStepList = WorkStepList::find($workStepListId);
        $this->pengajuanBarang[] = [
            'work_step_list' => $dataWorkStepList->name,
            'work_step_list_id' => $dataWorkStepList->id,
            'nama_barang' => '',
            'tgl_target_datang' => '',
            'qty_barang' => '',
            'keterangan' => '',
            'status_id' => '8',
            'status' => 'Pending',
            'state_pengajuan' => 'New',
        ];
    }

    public function removePengajuanBarang($indexBarang)
    {
        unset($this->pengajuanBarang[$indexBarang]);
        $this->pengajuanBarang = array_values($this->pengajuanBarang);
    }

    public function mount()
    {
        $this->searchNewSpk = request()->query('search', $this->searchNewSpk);
    }

    // public function sumGroup($groupId)
    // {
    //     $totalQuantityGroup = Instruction::where('group_id', $groupId)->sum('quantity');
    //     $totalStockGroup = Instruction::where('group_id', $groupId)->sum('stock');
    //     $totalQuantity = $totalQuantityGroup - $totalStockGroup;
    //     return $totalQuantity;
    // }

    public function render()
    {
        // Init Event
        $this->dispatchBrowserEvent('pharaonic.select2.init');

        $dataNewSpk = WorkStep::where('work_step_list_id', 2)
            ->where('state_task', 'Running')
            ->whereIn('status_task', ['Pending Approved'])
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Close PO', 'Training Program'])
            ->whereIn('status_id', [1])
            ->whereIn('job_id', [2])
            ->where(function ($query) {
                $searchTerms = '%' . $this->searchNewSpk . '%';
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
                    })
                    ->where(function ($subQuery) {
                        $subQuery->where('group_priority', '!=', 'child')->orWhereNull('group_priority');
                    });
            })
            ->join('instructions', 'work_steps.instruction_id', '=', 'instructions.id')
            ->select('work_steps.*')
            ->with(['status', 'job', 'workStepList', 'instruction', 'instruction.layoutBahan'])
            ->orderBy('instructions.shipping_date', 'asc')
            ->paginate($this->paginateNewSpk);

        return view('livewire.penjadwalan.component.new-spk-dashboard-index', ['instructionsNewSpk' => $dataNewSpk])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function save()
    {
        $this->validate([
            'workSteps.*.work_step_list_id' => 'required',
            'workSteps.*.schedule_date' => 'required',
            'workSteps.*.target_date' => 'required',
            'workSteps.*.target_time' => 'required',
            'workSteps.*.user_id' => 'required',
        ]);

        $lastDataWorkStep = WorkStep::where('instruction_id', $this->selectedInstruction->id)->get();
        $firstWorkStep = WorkStep::where('instruction_id', $this->selectedInstruction->id)
            ->where('work_step_list_id', 2)
            ->first();
        $lastWorkStep = WorkStep::where('instruction_id', $this->selectedInstruction->id)
            ->orderBy('step', 'asc')
            ->get();

        $deleteWorkSteps = WorkStep::where('instruction_id', $this->selectedInstruction->id)
            ->where('step', '>', $firstWorkStep->step)
            ->get();

        if ($deleteWorkSteps) {
            foreach ($deleteWorkSteps as $dataDeleted) {
                WorkStep::where('id', $dataDeleted->id)->delete();
            }
        }

        // Insert new work steps starting from firstWorkStep->step + 1
        $stepToAdd = $firstWorkStep->step + 1;
        // $newWorkSteps = [];

        // // Buat array dengan work_step_list_id yang ingin dihapus
        $workStepListIdsToRemove = [1, 2, 3, 4, 5];

        // // Gunakan array_filter untuk menyaring array dan hanya menyimpan elemen-elemen yang tidak memiliki work_step_list_id dalam $workStepListIdsToRemove
        $this->workSteps = array_filter($this->workSteps, function ($item) use ($workStepListIdsToRemove) {
            return !in_array($item['work_step_list_id'], $workStepListIdsToRemove);
        });


        foreach ($this->workSteps as $index => $workStepData) {
            $stepCount = $stepToAdd++;
            $inserWorkStep = WorkStep::create([
                'instruction_id' => $this->selectedInstruction->id,
                'work_step_list_id' => $workStepData['work_step_list_id'],
                'target_date' => $workStepData['target_date'],
                'schedule_date' => $workStepData['schedule_date'],
                'target_time' => $workStepData['target_time'],
                'user_id' => $workStepData['user_id'],
                'machine_id' => $workStepData['machine_id'],
                'step' => $stepCount,
                'state_task' => $workStepData['state_task'],
                'status_task' => $workStepData['status_task'],
                'spk_status' => 'Running',
            ]);
        }

        $newDataWorkStep = WorkStep::where('instruction_id', $this->selectedInstruction->id)
            ->whereNotIn('work_step_list_id', [1, 2, 3, 4, 5])
            ->get();

        foreach ($lastDataWorkStep as $lastData) {
            $updateNewWorkStep = WorkStep::where('instruction_id', $this->selectedInstruction->id)
                ->where('work_step_list_id', $lastData->work_step_list_id)
                ->where('status_task', $lastData->status_task)
                ->where('state_task', $lastData->state_task)
                ->update([
                    'flag' => $lastData['flag'],
                    'timer' => $lastData['timer'],
                    'auto_save_timer' => $lastData['auto_save_timer'],
                    'alasan_pause' => $lastData['alasan_pause'],
                    'catatan_proses_pengerjaan' => $lastData['catatan_proses_pengerjaan'],
                    'reject_from_id' => $lastData['reject_from_id'],
                    'reject_from_status' => $lastData['reject_from_status'],
                    'reject_from_job' => $lastData['reject_from_job'],
                    'count_reject' => $lastData['count_reject'],
                    'count_revisi' => $lastData['count_revisi'],
                    'task_priority' => $lastData['task_priority'],
                    'dikerjakan' => $lastData['dikerjakan'],
                    'selesai' => $lastData['selesai'],
                    'keterangan_reject' => $lastData['keterangan_reject'],
                    'keterangan_reschedule' => $lastData['keterangan_reschedule'],
                ]);
        }

        $nextWorkStep = WorkStep::where('instruction_id', $this->selectedInstruction->id)
            ->where('step', $firstWorkStep->step + 1)
            ->update([
                'state_task' => 'Not Running',
                'status_task' => 'Pending Start',
            ]);

        $updateJobStatus = WorkStep::where('instruction_id', $this->selectedInstruction->id)->update([
            'job_id' => $firstWorkStep->work_step_list_id,
            'status_id' => 2,
        ]);

        $firstWorkStep->update([
            'status_task' => 'Process',
        ]);

        $dataGroup = Instruction::find($this->selectedInstruction->id);
        if (isset($dataGroup->group_id) && isset($dataGroup->group_priority)) {
            $datachild = Instruction::where('group_id', $dataGroup->group_id)
                ->where('group_priority', 'child')
                ->get();
            foreach ($datachild as $datachild) {
                $deleteWorkStep = WorkStep::where('instruction_id', $datachild['id'])->delete();

                $parentWorkStep = WorkStep::where('instruction_id', $dataGroup->id)->get();
                foreach ($parentWorkStep as $key => $item) {
                    $childWorkStep = $item->replicate();
                    $childWorkStep->instruction_id = $datachild['id'];
                    $childWorkStep->save();
                }
            }
        }

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Jadwal Instruksi Kerja',
            'message' => 'Data jadwal berhasil disimpan',
        ]);
        $this->workSteps = [];
        $this->emit('indexRender');
        $this->dispatchBrowserEvent('close-modal-new-spk');
    }

    public function sendNote()
    {
        if (isset($this->sendNotes)) {
            $this->validate([
                'sendNotes.*.tujuan' => 'required',
                'sendNotes.*.catatan' => 'required',
            ]);

            foreach ($this->sendNotes as $input) {
                if($input['tujuan'] == 'semua') {
                    foreach ($this->workSteps as $item) {
                        $catatanSemua = Catatan::create([
                            'tujuan' => $item['work_step_list_id'],
                            'catatan' => $input['catatan'],
                            'kategori' => 'catatan',
                            'instruction_id' => $this->selectedInstruction->id,
                            'user_id' => Auth()->user()->id,
                        ]);
                    }
                }else{
                    $catatan = Catatan::create([
                        'tujuan' => $input['tujuan'],
                        'catatan' => $input['catatan'],
                        'kategori' => 'catatan',
                        'instruction_id' => $this->selectedInstruction->id,
                        'user_id' => Auth()->user()->id,
                    ]);
                }
            }
        }

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Jadwal Instruksi Kerja',
            'message' => 'Data jadwal berhasil disimpan',
        ]);

        $this->workSteps = [];
        $this->sendNotes = [];
        $this->emit('indexRender');
        $this->dispatchBrowserEvent('close-modal-new-spk');
    }

    public function ajukanBarang()
    {
        $this->validate([
            'pengajuanBarang' => 'required|array|min:1',
            'pengajuanBarang.*.nama_barang' => 'required',
            'pengajuanBarang.*.tgl_target_datang' => 'required',
            'pengajuanBarang.*.qty_barang' => 'required',
            'pengajuanBarang.*.keterangan' => 'required',
        ]);

        if (isset($this->pengajuanBarang)) {
            foreach ($this->pengajuanBarang as $key => $item) {
                if ($item['state_pengajuan'] == 'New') {
                    $createPengajuan = PengajuanBarangSpk::create([
                        'instruction_id' => $this->selectedInstruction->id,
                        'work_step_list_id' => $item['work_step_list_id'],
                        'nama_barang' => $item['nama_barang'],
                        'user_id' => Auth()->user()->id,
                        'tgl_pengajuan' => Carbon::now(),
                        'tgl_target_datang' => $item['tgl_target_datang'],
                        'qty_barang' => $item['qty_barang'],
                        'keterangan' => $item['keterangan'],
                        'status_id' => $item['status_id'],
                        'state' => 'Purchase',
                    ]);
                }
            }
        }

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Pengajuan Barang Instruksi Kerja',
            'message' => 'Data Pengajuan Barang berhasil disimpan',
        ]);

        $userDestination = User::where('role', 'Purchase')->get();
        foreach ($userDestination as $dataUser) {
            $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'Pengajuan Barang SPK', 'instruction_id' => $this->selectedInstruction->id]);
        }

        $this->dispatchBrowserEvent('close-modal-new-spk');
    }

    public function modalInstructionDetailsNewSpk($instructionId)
    {
        $this->workSteps = [];
        $this->pengajuanBarang = [];
        $this->historyPengajuanBarang = [];
        $this->historyCatatan = [];
        $this->historyCatatan = Catatan::where('instruction_id', $instructionId)->where('user_id', Auth()->user()->id)->where('kategori', 'catatan')->get();
        $this->dataWorkSteps = WorkStepList::whereNotIn('id', [1, 2, 3])->get();
        $this->dataUsers = User::whereNotIn('role', ['Admin', 'Follow Up', 'Penjadwalan', 'RAB', 'Purchase', 'Accounting'])->get();
        $this->dataMachines = Machine::all();
        $this->selectedInstruction = Instruction::find($instructionId);
        $this->selectedWorkStep = WorkStep::where('instruction_id', $instructionId)
            ->whereNotIn('work_step_list_id', [1, 2, 3])
            ->with('workStepList', 'user', 'machine')
            ->orderBy('step', 'asc')
            ->get();

        $dataworkStepHitungBahan = WorkStep::where('instruction_id', $instructionId)
            ->where('work_step_list_id', 5)
            ->first();

        $dataPengajuanBarang = PengajuanBarangSpk::where('instruction_id', $instructionId)
            ->where('user_id', Auth()->user()->id)
            ->with('workStepList', 'status')
            ->get();

        if (isset($dataPengajuanBarang)) {
            foreach ($dataPengajuanBarang as $key => $dataBarang) {
                $dataPengajuan = [
                    'work_step_list' => $dataBarang->workStepList->name,
                    'work_step_list_id' => $dataBarang->work_step_list_id,
                    'nama_barang' => $dataBarang->nama_barang,
                    'tgl_target_datang' => $dataBarang->tgl_target_datang,
                    'qty_barang' => $dataBarang->qty_barang,
                    'keterangan' => $dataBarang->keterangan,
                    'status_id' => $dataBarang->status_id,
                    'status' => $dataBarang->status->desc_status,
                ];

                $this->historyPengajuanBarang[] = $dataPengajuan;
            }
        }

        if (empty($this->historyPengajuanBarang)) {
            $this->historyPengajuanBarang = [];
        }

        if (isset($dataworkStepHitungBahan)) {
            $this->workStepHitungBahan = $dataworkStepHitungBahan->id;
        }

        foreach ($this->selectedWorkStep as $key => $dataSelected) {
            $workSteps = [
                'work_step_list_id' => $dataSelected['work_step_list_id'],
                'target_date' => $dataSelected['target_date'],
                'schedule_date' => $dataSelected['schedule_date'],
                'target_time' => $dataSelected['target_time'],
                'user_id' => $dataSelected['user_id'],
                'machine_id' => $dataSelected['machine_id'],
                'status_task' => $dataSelected['status_task'],
                'state_task' => $dataSelected['state_task'],
                'keterangan_reject' => $dataSelected['keterangan_reject'],
            ];
            $this->workSteps[] = $workSteps;

            // Load Event
            $this->dispatchBrowserEvent('pharaonic.select2.load', [
                'component' => $this->id,
                'target' => '#work_step_list_id-' . $key,
            ]);

            // Load Event
            $this->dispatchBrowserEvent('pharaonic.select2.load', [
                'component' => $this->id,
                'target' => '#user_id-' . $key,
            ]);

            // Load Event
            $this->dispatchBrowserEvent('pharaonic.select2.load', [
                'component' => $this->id,
                'target' => '#machine_id-' . $key,
            ]);
        }

        if (isset($this->historyCatatan)) {
            $this->historyCatatan = collect($this->historyCatatan)->map(function ($dataCatatan) {
                $cariWorkStepList = WorkStepList::where('id', $dataCatatan['tujuan'])->first();
                return [
                    'tujuan' => optional($cariWorkStepList)->name,
                    'catatan' => $dataCatatan['catatan'],
                ];
            })->toArray();
        } else {
            $this->historyCatatan = [];
        }



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

        $this->notes = Catatan::where('instruction_id', $instructionId)
            ->where('kategori', 'catatan')
            ->where('tujuan', 2)
            ->get();
    }

    public function modalInstructionDetailsGroupNewSpk($groupId)
    {
        $this->workSteps = [];

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

    public function rejectSpk()
    {
        $this->validate([
            'tujuanReject' => 'required',
            'keteranganReject' => 'required',
        ]);

        $workStepCurrent = WorkStep::where('instruction_id', $this->selectedInstruction->id)
            ->where('work_step_list_id', 2)
            ->first();

        $workStepDestination = WorkStep::where('instruction_id', $this->selectedInstruction->id)
            ->where('work_step_list_id', $this->tujuanReject)
            ->first();

        $workStepDestination->update([
            'state_task' => 'Running',
            'status_task' => 'Reject',
            'reject_from_id' => $workStepCurrent->id,
            'reject_from_status' => 1,
            'reject_from_job' => 2,
            'count_reject' => $workStepDestination->count_reject + 1,
        ]);

        $updateJobStatus = WorkStep::where('instruction_id', $this->selectedInstruction->id)->update([
            'status_id' => 3,
            'job_id' => $workStepDestination->work_step_list_id,
        ]);

        $updateKeterangan = Catatan::create([
            'tujuan' => $this->tujuanReject,
            'catatan' => $this->keteranganReject,
            'kategori' => 'reject',
            'instruction_id' => $this->selectedInstruction->id,
            'user_id' => Auth()->user()->id,
        ]);

        $workStepCurrent->update([
            'user_id' => Auth()->user()->id,
            // 'status_task' => 'Waiting For Repair',
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Reject Instruksi Kerja',
            'message' => 'Berhasil reject instruksi kerja',
        ]);
        $this->messageSent(['receiver' => $workStepDestination->user_id, 'conversation' => 'SPK Reject dari Penjadwalan', 'instruction_id' => $this->selectedInstruction->id]);
        $this->tujuanReject = null;
        $this->keteranganReject = null;
        $this->dispatchBrowserEvent('close-modal-new-spk');
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
