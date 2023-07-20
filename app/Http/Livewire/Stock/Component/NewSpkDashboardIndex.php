<?php

namespace App\Http\Livewire\Stock\Component;

use Carbon\Carbon;
use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Storage;

class NewSpkDashboardIndex extends Component
{
    use WithPagination;
    use WithFileUploads;
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

    public $stock;
    public $fileRincian = [];

    protected $listeners = ['notifSent' => 'refreshIndex'];

    public function refreshIndex($data)
    {
        $this->render();
    }

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }

    public function render()
    {
        return view('livewire.stock.component.new-spk-dashboard-index', [
            'instructions' => $this->search === null ?
                            WorkStep::where('work_step_list_id', 4)
                            ->where('state_task', 'Running')
                            ->whereIn('status_task', ['Pending Approved', 'Process'])
                            ->where('spk_status', 'Running')
                            ->whereIn('status_id', [1, 2])
                            ->whereHas('instruction', function ($query) {
                                $query->orderBy('shipping_date', 'asc');
                            })
                            ->with(['status', 'workStepList'])
                            ->paginate($this->paginate) :
                            WorkStep::where('work_step_list_id', 4)
                                        ->where('state_task', 'Running')
                                        ->whereIn('status_task', ['Pending Approved', 'Process'])
                                        ->where('spk_status', 'Running')
                                        ->whereIn('status_id', [1, 2])
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
                                        ->with(['status', 'workStepList'])
                                        ->paginate($this->paginate)
        ])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Dashboard']);
    }

    public function save()
    {
        $this->validate([
            'stock' => 'required|numeric',
        ], [
            'stock.required' => 'Setidaknya stock harus diisi.',
        ]);

        // dd($this->stock);
        if($this->selectedInstruction->quantity < currency_convert($this->stock)){
            $this->emit('flashMessage', [
                'type' => 'error',
                'title' => 'Error Stock',
                'message' => 'Stock tidak boleh lebih dari quantity',
            ]);
        }else if($this->selectedInstruction->quantity == currency_convert($this->stock)){
            $updateWorkStep = WorkStep::where('instruction_id', $this->selectedInstruction->id)->whereNotIn('work_step_list_id', [2, 35, 36])->update([
                'state_task' => 'Complete',
                'status_task' => 'Complete',
                'selesai' => Carbon::now(),
            ]);

            $updateJadwal = WorkStep::where('instruction_id', $this->selectedInstruction->id)->where('work_step_list_id', 2)->update([
                'state_task' => 'Running',
                'status_task' => 'Process',
                'dikerjakan' => Carbon::now()->toDateTimeString(),
                'schedule_date' => Carbon::now(),
            ]);

            $updateJadwal = WorkStep::where('instruction_id', $this->selectedInstruction->id)->whereIn('work_step_list_id', [35, 36])->update([
                'state_task' => 'Running',
                'status_task' => 'Pending Approved',
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

            $updateJadwal = WorkStep::where('instruction_id', $this->selectedInstruction->id)->where('work_step_list_id', 2)->update([
                'state_task' => 'Running',
                'status_task' => 'Process',
                'dikerjakan' => Carbon::now()->toDateTimeString(),
                'schedule_date' => Carbon::now(),
            ]);

            $updateTask = WorkStep::where('instruction_id', $this->selectedInstruction->id)->where('work_step_list_id', 4)->update([
                'state_task' => 'Complete',
                'status_task' => 'Complete',
                'selesai' => Carbon::now()->toDateTimeString(),
            ]);

            if($this->fileRincian){
                $folder = "public/".$this->selectedInstruction->spk_number."/stock";

                $norincianstock = 1;
                foreach ($this->fileRincian as $file) {
                    $fileName = $this->selectedInstruction->spk_number . '-file-rincian-stock-'.$norincianstock . '.' . $file->getClientOriginalExtension();
                    Storage::putFileAs($folder, $file, $fileName);
                    $norincianstock ++;

                    Files::create([
                        'instruction_id' => $this->selectedInstruction->id,
                        "user_id" => Auth()->user()->id,
                        "type_file" => "rincian-stock",
                        "file_name" => $fileName,
                        "file_path" => $folder,
                    ]);
                }
            }

            $this->messageSent(['receiver' => 2, 'instruction_id' => $this->selectedInstruction->id]);

            $this->emit('flashMessage', [
                'type' => 'success',
                'title' => 'Stock Instruksi Kerja',
                'message' => 'Data berhasil disimpan',
            ]);

            $this->reset();
            $this->dispatchBrowserEvent('pondReset');
            $this->dispatchBrowserEvent('close-modal');
        }else{
            $updateStock = Instruction::where('id', $this->selectedInstruction->id)->update([
                'stock' => currency_convert($this->stock),
            ]);

            $updateTask = WorkStep::where('instruction_id', $this->selectedInstruction->id)->where('work_step_list_id', 4)->update([
                'state_task' => 'Complete',
                'status_task' => 'Complete',
                'selesai' => Carbon::now()->toDateTimeString(),
            ]);

            $updateNextStep = WorkStep::where('instruction_id', $this->selectedInstruction->id)->where('step', $updateTask->step + 1)->update([
                'state_task' => 'Running',
                'status_task' => 'Pending Approved',
                'schedule_date' => Carbon::now(),
            ]);


            if($this->fileRincian){
                $folder = "public/".$this->selectedInstruction->spk_number."/stock";

                $norincianstock = 1;
                foreach ($this->fileRincian as $file) {
                    $fileName = $this->selectedInstruction->spk_number . '-file-rincian-stock-'.$norincianstock . '.' . $file->getClientOriginalExtension();
                    Storage::putFileAs($folder, $file, $fileName);
                    $norincianstock ++;

                    Files::create([
                        'instruction_id' => $this->selectedInstruction->id,
                        "user_id" => Auth()->user()->id,
                        "type_file" => "rincian-stock",
                        "file_name" => $fileName,
                        "file_path" => $folder,
                    ]);
                }
            }

            $this->messageSent(['receiver' => 5, 'instruction_id' => $this->selectedInstruction->id]);
            $this->messageSent(['receiver' => 9, 'instruction_id' => $this->selectedInstruction->id]);

            $this->emit('flashMessage', [
                'type' => 'success',
                'title' => 'Stock Instruksi Kerja',
                'message' => 'Data berhasil disimpan',
            ]);

            $this->reset();
            $this->dispatchBrowserEvent('pondReset');
            $this->dispatchBrowserEvent('close-modal');
        }


    }

    public function messageSent($arguments)
    {
        $createdMessage = "success";
        $selectedConversation = "message conversation";
        $receiverUser = $arguments['receiver'];
        $instruction_id = $arguments['instruction_id'];

        broadcast(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, $receiverUser));
    }

    public function modalInstructionStock($instructionId)
    {
        $updateStatusStock = WorkStep::where('instruction_id', $instructionId)->update([
            'status_id' => 2,
            'status_task' => 'Process',
        ]);

        $this->selectedInstruction = Instruction::find($instructionId);
        $this->selectedWorkStep = WorkStep::where('instruction_id', $instructionId)->with('workStepList', 'user', 'machine')->get();
        $this->selectedFileContoh = Files::where('instruction_id', $instructionId)->where('type_file', 'contoh')->get();
        $this->selectedFileArsip = Files::where('instruction_id', $instructionId)->where('type_file', 'arsip')->get();
        $this->selectedFileAccounting = Files::where('instruction_id', $instructionId)->where('type_file', 'accounting')->get();
        $this->selectedFileLayout = Files::where('instruction_id', $instructionId)->where('type_file', 'layout')->get();
        $this->selectedFileSample = Files::where('instruction_id', $instructionId)->where('type_file', 'sample')->get();

        $this->dispatchBrowserEvent('show-detail-instruction-modal-stock');
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
}
