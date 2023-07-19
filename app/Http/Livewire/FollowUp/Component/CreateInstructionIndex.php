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

class CreateInstructionIndex extends Component
{
    protected $listeners = ['dispatchMessageSent'];

    use WithFileUploads;
    public $filecontoh = [];
    public $filearsip = [];
    public $fileaccounting = [];
    public $notes = [];

    public $title;
    public $no;

    //instruksi kerja form
    public $spk_type;
    public $spk_number;
    public $customer;
    public $taxes_type;
    public $order_date;
    public $shipping_date;
    public $customer_number;
    public $order_name;
    public $code_style;
    public $quantity;
    public $price;
    public $follow_up;
    public $sub_spk;
    public $spk_parent;

    public $fsc_type;
    public $spk_number_fsc;
    public $spk_fsc;

    public $spk_layout_number;
    public $spk_sample_number;

    public $type_ppn;
    public $ppn = 11.2 / 100;
    public $type_order;

    //data
    public $datacustomers = [];
    public $dataparents = [];
    public $datalayouts = [];
    public $datasamples = [];
    public $dataworksteplists = [];

    public $currentInstructionId;

    public $createdMessage;
    public $selectedConversation;
    public $receiverInstance;

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
        $this->datacustomers = Customer::all();
        $this->dataparents = Instruction::where('spk_number', 'LIKE', '%-A')->orderByDesc('created_at')->get();
        $this->datalayouts = Instruction::where('spk_type', 'layout')->orderByDesc('created_at')->get();
        $this->datasamples = Instruction::where('spk_type', 'sample')->orderByDesc('created_at')->get();
        $this->dataworksteplists = WorkStepList::whereNotIn('name', ['Follow Up', 'Penjadwalan', 'RAB'])->get();
        
        return view('livewire.follow-up.component.create-instruction-index')->extends('layouts.app')->layoutData(['title' => 'Form Instruksi Kerja']);
    }

    public function select2()
    {
        // Init Event
        $this->dispatchBrowserEvent('pharaonic.select2.init');
        
        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target'    => '#customer'
        ]);
        
        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target'    => '#spk_parent'
        ]);
        
        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target'    => '#spk_layout_number'
        ]);
        
        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target'    => '#spk_parent'
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
            'spk_type' => 'required',
            'spk_number' => 'required',
            'customer' => 'required',
            'order_date' => 'required',
            'shipping_date' => 'required',
            'order_name' => 'required',
            'quantity' => 'required',
            'workSteps' => 'required',
        ]);

        $customerList = Customer::find($this->customer);
        $dataInstruction = Instruction::whereNotNull('customer_number')->where('customer_number', $this->customer_number)->first();
        
        
        if($this->spk_type == 'stock'){
            $this->spk_type = 'production';
            $this->taxes_type = 'nonpajak';
            $this->type_order = 'stock';
        }else{
            $this->taxes_type = $customerList->taxes;
            $this->type_order = $this->spk_type;
        }

        if($dataInstruction == null){
            $instruction = Instruction::create([
                'spk_type' => $this->spk_type,
                'spk_number' => $this->spk_number,
                'order_date' => $this->order_date,
                'shipping_date' => $this->shipping_date,
                'customer_name' => $customerList->name,
                'taxes_type' => $this->taxes_type,
                'customer_number' => $this->customer_number,
                'order_name' => $this->order_name,
                'code_style' => $this->code_style,
                'quantity' => currency_convert($this->quantity),
                'price' => currency_convert($this->price),
                'shipping_date_first' => $this->shipping_date,
                'spk_status' => 'New',
                'spk_state' => 'Running',
                'sub_spk' => $this->sub_spk,
                'spk_parent' => $this->spk_parent,
                'spk_fsc' => $this->spk_fsc,
                'fsc_type' => $this->fsc_type,
                'spk_number_fsc' => $this->spk_number_fsc,
                'follow_up' => $this->follow_up,
                'spk_layout_number' => $this->spk_layout_number,
                'spk_sample_number' => $this->spk_sample_number,
                'type_ppn' => $this->type_ppn,
                'ppn' => $this->ppn,
                'type_order' => $this->type_order,
            ]);

            $this->workSteps = array_map(function ($workSteps) {
                $workSteps['user_id'] = null;
                return $workSteps;
            }, $this->workSteps);

            if($this->spk_type == 'layout'){
                // Menambahkan elemen sebelum array indeks 0
                array_unshift($this->workSteps, [
                    "name" => "Follow Up",
                    "id" => "1",
                    "user_id" => Auth()->user()->id
                ], [
                    "name" => "Penjadwalan",
                    "id" => "2",
                    "user_id" => "4"
                ]);
            }else{
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
            }
            
            $no = 0;
            foreach ($this->workSteps as $step) {
                WorkStep::create([
                    'instruction_id' => $instruction->id,
                    'work_step_list_id' => $step['id'],
                    'state_task' => 'Not Running',
                    'status_task' => 'Waiting',
                    'step' => $no,
                    'task' => 'Running',
                    'user_id' => $step['user_id'],
                ]);
                $no++;
            }

            //update selesai
            WorkStep::where('instruction_id', $instruction->id)->where('step', 0)
                ->update([
                    'state_task' => 'Complete',
                    'status_task' => 'Complete',
                    'target_date' => Carbon::now(),
                    'schedule_date' => Carbon::now(),
                    'dikerjakan' => Carbon::now()->toDateTimeString(),
                    'selesai' => Carbon::now()->toDateTimeString()
                ]);
            
            $firstWorkStep = WorkStep::where('instruction_id', $instruction->id)->where('step', 1)->first();
            $workStepList = WorkStepList::find($firstWorkStep->work_step_list_id);
            $jobList = Job::where('desc_job', $workStepList->name)->first();
            $statusId = 1;
            $JobId = $jobList->id;

            //cari no 1 langkah kerjanya
            WorkStep::where('instruction_id', $instruction->id)->where('step', 1)
                ->update([
                    'state_task' => 'Running',
                    'status_task' => 'Pending Approved',
                    'dikerjakan' => Carbon::now()->toDateTimeString(),
                ]);

            WorkStep::where('instruction_id', $instruction->id)
                ->update([
                    'status_id' => $statusId,
                    'job_id' => $JobId,
                ]);

            
            if ($this->spk_layout_number) {
                $selectedLayout = Instruction::where('spk_number', $this->spk_layout_number)->first();
                $files = Files::where('instruction_id', $selectedLayout->id)->where('type_file', 'layout')->get();
                $folder = "public/".$this->spk_number."/follow-up";

                if($files){
                    foreach ($files as $file) {
                        $sourcePath = $file->file_path.'/'.$file->file_name;
                        $newFileName = $file->file_name;
                
                        if (!Storage::exists($folder.'/'.$newFileName)) {
                            // Copy the file to the destination folder with the new name
                            Storage::copy($sourcePath, $folder.'/'.$newFileName);
                    
                            Files::create([
                                'instruction_id' => $instruction->id,
                                "user_id" => Auth()->user()->id,
                                "type_file" => "layout",
                                "file_name" => $newFileName,
                                "file_path" => $folder,
                            ]);
                        }
                    }
                }
            }    

            
            if ($this->spk_sample_number) {
                $selectedSample = Instruction::where('spk_number', $this->spk_sample_number)->first();
                $files = Files::where('instruction_id', $selectedSample->id)->where('type_file', 'sample')->get();
                $folder = "public/".$this->spk_number."/follow-up";

                if($files){
                    foreach ($files as $file) {
                        $sourcePath = $file->file_path.'/'.$file->file_name;
                        $newFileName = $file->file_name;
                
                        if (!Storage::exists($folder.'/'.$newFileName)) {
                            // Copy the file to the destination folder with the new name
                            Storage::copy($sourcePath, $folder.'/'.$newFileName);
                    
                            Files::create([
                                'instruction_id' => $instruction->id,
                                "user_id" => Auth()->user()->id,
                                "type_file" => "sample",
                                "file_name" => $newFileName,
                                "file_path" => $folder,
                            ]);
                        }
                    }
                }
            }    

            if($this->uploadFiles($instruction->id)){
                $this->uploadFiles($instruction->id);
            }
            
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

            session()->flash('success', 'Instruksi kerja berhasil disimpan.');
            $this->emit('flashMessage', [
                'type' => 'success',
                'title' => 'Create Instruksi Kerja',
                'message' => 'Berhasil membuat instruksi kerja',
            ]);

            $this->messageSent();
            $this->reset();
            $this->dispatchBrowserEvent('pondReset');
            return redirect()->route('followUp.createInstruction');
            
        }else{

            $this->emit('flashMessage', [
                'type' => 'error',
                'title' => 'Error Instruksi Kerja',
                'message' => 'Instruksi kerja pernah dibuat sebelumnya, karena po konsumen sudah terpakai',
            ]);
        }
        
        
    }

    public function messageSent()
    {
        $this->createdMessage = "success";
        $this->selectedConversation = "message conversation";
        $this->receiverInstance = Auth()->user()->id;
        broadcast(new NotificationSent(Auth()->user()->id, $this->createdMessage, $this->selectedConversation, $this->receiverInstance));
    }

    public function uploadFiles($instructionId)
    {
        $folder = "public/".$this->spk_number."/follow-up";

        $nocontoh = 1;
        foreach ($this->filecontoh as $file) {
            $fileName = $this->spk_number . '-file-contoh-'.$nocontoh . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs($folder, $file, $fileName);
            $nocontoh ++;

            Files::create([
                'instruction_id' => $instructionId,
                "user_id" => "2",
                "type_file" => "contoh",
                "file_name" => $fileName,
                "file_path" => $folder,
            ]);
        }

        $noarsip = 1;
        foreach ($this->filearsip as $file) {
            $fileName = $this->spk_number . '-file-arsip-'.$noarsip . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs($folder, $file, $fileName);
            $noarsip ++;

            Files::create([
                'instruction_id' => $instructionId,
                "user_id" => "2",
                "type_file" => "arsip",
                "file_name" => $fileName,
                "file_path" => $folder,
            ]);
        }

        $noarsipaccounting = 1;
        foreach ($this->fileaccounting as $file) {
            $fileName = $this->spk_number . '-file-arsip-accounting-'.$noarsipaccounting . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs($folder, $file, $fileName);
            $noarsipaccounting ++;

            Files::create([
                'instruction_id' => $instructionId,
                "user_id" => "2",
                "type_file" => "accounting",
                "file_name" => $fileName,
                "file_path" => $folder,
            ]);
        }
    }

    public function generateCode()
    {   
        $this->validate([
            'spk_type' => 'required',
            'customer' => 'required',
        ]);

        $datacustomerlist = Customer::find($this->customer);

        if($this->spk_type == 'layout' || $this->spk_type == 'sample'){
            $count_spk = Instruction::whereIn('spk_type', ['layout', 'sample'])->count();
            $this->spk_number = 'P-' . sprintf("1%04d", $count_spk + 1);
        }else if($this->spk_type == 'production'){
            if(isset($this->spk_parent)){
                $nomor_spk_parent = Instruction::where('spk_parent', $this->spk_parent)
                                        ->where('spk_type', $this->spk_type)
                                        ->where('taxes_type', $datacustomerlist->taxes)
                                        ->latest('spk_number')->first();
                $nomor_parent = Str::between($this->spk_parent, '-', '-');
            }else{
                if($datacustomerlist->taxes == 'pajak'){
                    $nomor_spk = Instruction::where('spk_type', $this->spk_type)
                    ->where('spk_parent', NULL)
                    ->where('taxes_type', 'pajak')
                    ->count();
                }else{
                    $nomor_spk = Instruction::where('spk_type', $this->spk_type)
                    ->where('spk_parent', NULL)
                    ->where('taxes_type', 'nonpajak')
                    ->count();
                }
                
            }

            if (isset($nomor_spk_parent)) {
                $code_alphabet = substr($nomor_spk_parent['spk_number'], -1);
            } else {
                $code_alphabet = 'A';
            }

            
            if($datacustomerlist->taxes == 'pajak' && empty($this->sub_spk) && empty($this->spk_parent)){
                $nomor_urut = $nomor_spk + 534;
                $this->spk_number = 'SLN' . date('y') . '-' . sprintf("1%04d", $nomor_urut + 1);
            }else if($datacustomerlist->taxes == 'pajak' && isset($this->sub_spk) && empty($this->spk_parent)){
                $nomor_urut = $nomor_spk + 534;
                $this->spk_number = 'SLN' . date('y') . '-' . sprintf("1%04d", $nomor_urut + 1). '-A';
            }else if($datacustomerlist->taxes == 'pajak' && isset($this->sub_spk) && isset($this->spk_parent)){
                $this->spk_number = 'SLN' . date('y') . '-' . sprintf($nomor_parent) . '-' . sprintf(++$code_alphabet);
            }if($datacustomerlist->taxes == 'nonpajak' && empty($this->sub_spk) && empty($this->spk_parent)){
                $nomor_urut = $nomor_spk + 153;
                $this->spk_number = date('y') . '-' . sprintf("1%04d", $nomor_urut + 1);
            }else if($datacustomerlist->taxes == 'nonpajak' && isset($this->sub_spk) && empty($this->spk_parent)){
                $nomor_urut = $nomor_spk + 153;
                $this->spk_number = date('y') . '-' . sprintf("1%04d", $nomor_urut + 1). '-A';
            }else if($datacustomerlist->taxes == 'nonpajak' && isset($this->sub_spk) && isset($this->spk_parent)){
                $this->spk_number = date('y') . '-' . sprintf($nomor_parent) . '-' . sprintf(++$code_alphabet);
            }

        }else if($this->spk_type == 'stock'){
            $nomor_spk = Instruction::where('spk_type', 'production')
                                    ->where('spk_parent', NULL)
                                    ->where('taxes_type', 'nonpajak')
                                    ->count();
            $nomor_urut = $nomor_spk + 153;
            $this->spk_number = date('y') . '-' . sprintf("1%04d", $nomor_urut + 1). '(STK)';
        }

        // Perbarui nilai input text
        $this->dispatchBrowserEvent('generated', ['code' => $this->spk_number]);
    }

    public function generateCodeFsc()
    {   
        $this->validate([
            'fsc_type' => 'required',
            'spk_fsc' => 'required',
        ], [
            'fsc_type.required' => 'Tipe FSC harus dipilih.',
            'spk_fsc.required' => 'SFC harus dipilih.',
        ]);


        $this->spk_number_fsc = 'FSC-' . sprintf($this->spk_number) . '(' . sprintf($this->fsc_type) . ')';

        // Perbarui nilai input text
        $this->dispatchBrowserEvent('generatedfsc', ['codefsc' => $this->spk_number_fsc]);

    }
}