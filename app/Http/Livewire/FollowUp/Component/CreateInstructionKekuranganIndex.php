<?php

namespace App\Http\Livewire\FollowUp\Component;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\Customer;
use App\Models\WorkStep;
use App\Models\Instruction;
use Illuminate\Support\Str;
use App\Models\WorkStepList;
use Livewire\WithFileUploads;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreateInstructionKekuranganIndex extends Component
{
    use WithFileUploads;
    public $notes = [];

    public $title;

    //instruksi kerja form
    public $requestKekurangan;
    public $spkSelected;
    public $spk_number;
    public $shipping_date;
    public $quantity;
    public $type_order;

    //data
    public $dataInstructions = [];
    public $dataworksteplists = [];

    public $workSteps = [];

    public function addField($name, $id)
    {
        $this->workSteps[] = ['name' => $name, 'id' => $id];
    }
    
    public function removeField($index)
    {
        unset($this->workSteps[$index]);
        $this->workSteps = array_values($this->workSteps);
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
        $this->select2();
    }
    
    public function render()
    {
        $this->dataInstructions = Instruction::where('spk_type', 'production')->where('request_kekurangan', NULL)->get();
        $this->dataworksteplists = WorkStepList::whereNotIn('name', ['Follow Up', 'Penjadwalan', 'RAB'])->get();

        if($this->spkSelected && empty($this->workSteps)){
            $dataWorkStep = WorkStep::where('instruction_id', $this->spkSelected)
            ->whereNotIn('work_step_list_id', [1, 2, 3])
            ->with('workStepList')
            ->get();

            foreach ($dataWorkStep as $workStep) {
                $this->workSteps[] = [
                    "name" => $workStep->workStepList->name,
                    "id" => $workStep->work_step_list_id,
                    "user_id" => $workStep->user_id
                ];
            }
        }
        
        return view('livewire.follow-up.component.create-instruction-kekurangan-index')->extends('layouts.app')->layoutData(['title' => 'Form Instruksi Kerja Kekurangan']);
    }

    public function select2()
    {
        // Init Event
        $this->dispatchBrowserEvent('pharaonic.select2.init');
        
        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target'    => '#spkSelected'
        ]);
        
    }

    public function save()
    {        
        if (empty($this->workSteps)) {
            $this->emit('flashMessage', [
                'type' => 'error',
                'title' => 'Error Instruksi Kerja',
                'message' => 'Langkah Kerja Harus Dipilih',
            ]);
        }

        $this->validate([
            'requestKekurangan' => 'required',
            'spkSelected' => 'required',
            'spk_number' => 'required',
            'shipping_date' => 'required',
            'quantity' => 'required',
            'workSteps' => 'required',
        ]);


        // Copy the Instruction
        $instruction = Instruction::where('id', $this->spkSelected)->first()->replicate();
        $instruction->request_kekurangan = $instruction->spk_number;
        $instruction->spk_number = $this->spk_number;
        if ($this->requestKekurangan == 'Pemesan') {
            $instruction->spk_state = 'Kekurangan Request Pemesan';
        } else if ($this->requestKekurangan == 'QC') {
            $instruction->spk_state = 'Kekurangan QC';
        } else if ($this->requestKekurangan == 'Kekurangan Bahan') {
            $instruction->spk_state = 'Kekurangan Bahan';
        }
        $instruction->save();

        $files = Files::where('instruction_id', $this->spkSelected)->get();
        if ($files) {
                $folder = "public/".$instruction->spk_number."/follow-up";
                if($files){
                    foreach ($files as $file) {
                        $sourcePath = $file->file_path.'/'.$file->file_name;
                        $newFileName = $file->file_name;
                        if (!Storage::exists($folder.'/'.$newFileName)) {
                            Storage::copy($sourcePath, $folder.'/'.$newFileName);
                            Files::create([
                                'instruction_id' => $instruction->id,
                                "user_id" => Auth()->user()->id,
                                "type_file" => $file->type_file,
                                "file_name" => $newFileName,
                                "file_path" => $folder,
                            ]);
                        }
                    }
                }
        }  
         
        // Menambahkan elemen sebelum array indeks 0
        array_unshift($this->workSteps, [
            "name" => "Follow Up",
            "id" => "1",
            "user_id" => Auth()->user()->id
        ]);
        
        $indexHitungBahan = array_search("Hitung Bahan", array_column($this->workSteps, "name"));
        $indexRAB = array_search("RAB", array_column($this->workSteps, "name"));
        $indexCariStock = array_search("Cari/Ambil Stock", array_column($this->workSteps, "name"));
        
        if ($indexHitungBahan !== false) {
            // Elemen "Hitung Bahan" ditemukan
            array_splice($this->workSteps, $indexHitungBahan + 1, 0, [
                [
                    "name" => "RAB",
                    "id" => "3",
                    "user_id" => null
                ]
            ]);
            $indexRAB = array_search("RAB", array_column($this->workSteps, "name"));
            if ($indexRAB !== false) {
                // Elemen "RAB" ditemukan setelah "Hitung Bahan"
                array_splice($this->workSteps, $indexRAB + 1, 0, [
                    [
                        "name" => "Penjadwalan",
                        "id" => "2",
                        "user_id" => "4"
                    ]
                ]);
            }
        } elseif ($indexRAB !== false) {
            // Elemen "Hitung Bahan" tidak ditemukan, tetapi elemen "RAB" ditemukan
            array_splice($this->workSteps, $indexRAB + 1, 0, [
                [
                    "name" => "Penjadwalan",
                    "id" => "2",
                    "user_id" => "4"
                ]
            ]);
        } else {
            // Tidak ada elemen "Hitung Bahan" atau "RAB"
            $indexFollowUp = array_search("Follow Up", array_column($this->workSteps, "name"));
            $indexCariStock = array_search("Cari/Ambil Stock", array_column($this->workSteps, "name"));
            
            if ($indexFollowUp !== false && $indexCariStock !== false && $indexCariStock > $indexFollowUp) {
                // Elemen "Cari/Ambil Stock" ditemukan setelah "Follow Up"
                array_splice($this->workSteps, $indexCariStock + 1, 0, [
                    [
                        "name" => "Penjadwalan",
                        "id" => "2",
                        "user_id" => "4"
                    ]
                ]);
            } else {
                // Tidak ada elemen "Cari/Ambil Stock" atau "Cari/Ambil Stock" sebelum "Follow Up"
                if ($indexFollowUp !== false) {
                    array_splice($this->workSteps, $indexFollowUp + 1, 0, [
                        [
                            "name" => "Penjadwalan",
                            "id" => "2",
                            "user_id" => "4"
                        ]
                    ]);
                }
            }
        }

        $no = 0;
            foreach ($this->workSteps as $step) {
                $inserWorkStep = WorkStep::create([
                    'instruction_id' => $instruction->id,
                    'work_step_list_id' => $step['id'],
                    'state_task' => 'Not Running',
                    'status_task' => 'Waiting',
                    'step' => $no,
                    'user_id' => $step['user_id'],
                    'task_priority' => 'Normal',
                    'spk_status' => 'Running',
                ]);
                $no++;
            }

            $updateFollowUp = WorkStep::where('instruction_id', $instruction->id)->where('step', 0)
                ->update([
                    'state_task' => 'Running',
                    'status_task' => 'Process',
                    'target_date' => Carbon::now(),
                    'schedule_date' => Carbon::now(),
                    'dikerjakan' => Carbon::now()->toDateTimeString(),
                    'selesai' => Carbon::now()->toDateTimeString()
                ]);
            
            $firstWorkStep = WorkStep::where('instruction_id', $instruction->id)->where('step', 1)->first();

            $updateNextStep = WorkStep::where('instruction_id', $instruction->id)->where('step', 1)
                ->update([
                    'state_task' => 'Running',
                    'status_task' => 'Pending Approved',
                    'dikerjakan' => Carbon::now()->toDateTimeString(),
                    'schedule_date' => Carbon::now(),
                    'target_date' => Carbon::now(),
                ]);

            $updateStatus = WorkStep::where('instruction_id', $instruction->id)
                ->update([
                    'status_id' => 1,
                    'job_id' => $firstWorkStep->work_step_list_id,
                ]);
            
            
            if($this->notes){
                foreach ($this->notes as $input) {
                    $catatan = Catatan::create([
                        'tujuan' => $input['tujuan'],
                        'catatan' => $input['catatan'],
                        'kategori' => 'catatan',
                        'instruction_id' => $instruction->id,
                        'user_id' => Auth()->user()->id,
                    ]);
                }
            }
            
            $this->workSteps = [];

            //notif
            if ($firstWorkStep->work_step_list_id == 4) {
                $this->messageSent(['receiver' => 9, 'instruction_id' => $instruction->id]);
            } else if ($firstWorkStep->work_step_list_id == 5) {
                $this->messageSent(['receiver' => 5, 'instruction_id' => $instruction->id]);
                $this->messageSent(['receiver' => 6, 'instruction_id' => $instruction->id]);
            } else {
                $this->messageSent(['receiver' => 2, 'instruction_id' => $instruction->id]);
            }

            session()->flash('success', 'Instruksi kerja berhasil disimpan.');
            $this->emit('flashMessage', [
                'type' => 'success',
                'title' => 'Create Instruksi Kerja',
                'message' => 'Berhasil membuat instruksi kerja',
            ]);

            $this->reset();     
        
    }

    public function messageSent($arguments)
    {
        $createdMessage = "success";
        $selectedConversation = "message conversation";
        $receiverUser = $arguments['receiver'];
        $instruction_id = $arguments['instruction_id'];

        broadcast(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, $receiverUser));
        broadcast(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, Auth()->user()->id));
    }

    public function generateCode()
    {   
        $this->validate([
            'requestKekurangan' => 'required',
            'spkSelected' => 'required',
        ]);

        $selectedInstruction = Instruction::find($this->spkSelected);

        if ($this->requestKekurangan == 'Pemesan') {
            $spkKekuranganCount = Instruction::where('spk_state', 'Kekurangan Request Pemesan')
                ->where('request_kekurangan', $selectedInstruction->spk_number)
                ->count();
            $this->spk_number = $selectedInstruction->spk_number . '.K' . ($spkKekuranganCount + 1);
        } else if ($this->requestKekurangan == 'QC') {
            $spkKekuranganCount = Instruction::where('spk_state', 'Kekurangan QC')
                ->where('request_kekurangan', $selectedInstruction->spk_number)
                ->count();
            $this->spk_number = $selectedInstruction->spk_number . '.GC' . ($spkKekuranganCount + 1);
        } else if ($this->requestKekurangan == 'Kekurangan Bahan') {
            $spkKekuranganCount = Instruction::where('spk_state', 'Kekurangan Bahan')
                ->where('request_kekurangan', $selectedInstruction->spk_number)
                ->count();
            $this->spk_number = $selectedInstruction->spk_number . '.KB' . ($spkKekuranganCount + 1);
        }
        

        // Perbarui nilai input text
        $this->dispatchBrowserEvent('generated', ['code' => $this->spk_number]);
    }

}
