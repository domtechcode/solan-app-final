<?php

namespace App\Http\Livewire\Stock\Component;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\Customer;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CompleteDashboardIndex extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginateComplete = 10;
    public $searchComplete = '';

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
    public $catatanHitungBahan;

    protected $listeners = ['indexRender' => '$refresh'];

    public function updatingSearchComplete()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->searchComplete = request()->query('search', $this->searchComplete);
    }

    public function render()
    {
        $dataComplete = WorkStep::where('work_step_list_id', 4)
            ->where('state_task', 'Complete')
            ->whereIn('status_task', ['Complete'])
            ->whereNotIn('spk_status', ['Hold', 'Cancel', 'Hold', 'Hold RAB', 'Hold Waiting Qty QC', 'Hold Qc', 'Failed Waiting Qty QC', 'Deleted', 'Acc', 'Close PO', 'Training Program'])
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

        return view('livewire.stock.component.complete-dashboard-index', ['instructionsComplete' => $dataComplete])
            ->extends('layouts.app')
            ->section('content');
    }

    public function save()
    {
        $this->validate(
            [
                'stock' => 'required|numeric',
            ],
            [
                'stock.required' => 'Setidaknya stock harus diisi.',
            ],
        );

        // dd($this->stock);
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

            if (isset($this->catatanHitungBahan)) {
                $catatan = Catatan::create([
                    'tujuan' => 5,
                    'catatan' => $this->catatanHitungBahan,
                    'kategori' => 'catatan',
                    'instruction_id' => $this->selectedInstruction->id,
                    'user_id' => Auth()->user()->id,
                ]);
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

    public function sampleRecord()
    {
        $customer = Customer::find($this->selectedInstruction->customer);
        $customer_name = $customer ? $customer->name : '';

        $reader = IOFactory::createReader('Xlsx');
        $reader->setLoadSheetsOnly('Sheet1');
        $spreadsheet = $reader->load('samplerecord.xlsx');

        $spreadsheet->getActiveSheet()->setCellValue('B4', $this->selectedInstruction->order_date);
        $spreadsheet->getActiveSheet()->setCellValue('J4', $this->selectedInstruction->spk_number);
        $spreadsheet->getActiveSheet()->setCellValue('C5', $this->selectedInstruction->order_name);
        $spreadsheet->getActiveSheet()->setCellValue('I5', $customer_name);

        // Generate the Excel file in memory
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        // Set the response headers for download
        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="Sample-Record-' . $this->selectedInstruction->spk_number . '.xlsx"');
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }
}
