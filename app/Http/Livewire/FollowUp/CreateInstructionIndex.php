<?php

namespace App\Http\Livewire\FollowUp;

use Carbon\Carbon;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\Customer;
use App\Models\WorkStep;
use App\Models\Instruction;
use Illuminate\Support\Str;
use App\Models\WorkStepList;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CreateInstructionIndex extends Component
{
    use WithFileUploads;
    public $fileContoh = [];
    public $fileArsip = [];
    public $fileArsipAccounting = [];
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
    public $sub_spk;
    public $spk_parent;
    public $follow_up;

    public $fsc_type;
    public $spk_number_fsc;
    public $spk_fsc;

    public $spk_layout_number;
    public $spk_sample_number;

    public $type_ppn;
    public $ppn = 11.2 / 100;

    //data
    public $datacustomers = [];
    public $dataparents = [];
    public $datalayouts = [];
    public $datasamples = [];
    public $dataworksteplists = [];

    // protected $rules = [
    //     'spk_type' => 'required',
    //     'spk_number' => 'required',
    //     'customer' => 'required',
    //     'order_date' => 'required',
    //     'shipping_date' => 'required',
    //     'order_name' => 'required',
    //     'quantity' => 'required',
    // ];

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

        return view('livewire.follow-up.create-instruction-index')->extends('layouts.main')->layoutData(['title' => 'Form Instruksi Kerja']);
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

    public function uploadFiles()
    {
        $folder = $this->spk_number."/followup";

        $nocontoh = 1;
        foreach ($this->fileContoh as $file) {
            $fileName = $this->spk_number . '-file-contoh-'.$nocontoh . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs('public/'.$folder, $file, $fileName);
            $nocontoh ++;
        }

        $noarsip = 1;
        foreach ($this->fileArsip as $file) {
            $fileName = $this->spk_number . '-file-arsip-'.$noarsip . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs('public/'.$folder, $file, $fileName);
            $noarsip ++;
        }

        $noarsipaccounting = 1;
        foreach ($this->fileArsipAccounting as $file) {
            $fileName = $this->spk_number . '-file-arsip-accounting-'.$noarsipaccounting . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs('public/'.$folder, $file, $fileName);
            $noarsipaccounting ++;
        }
    }

    public function save()
    {
        if (empty($this->workSteps)) {
            session()->flash('error', 'Langkah harus dipilih..');
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
        }else{
            $this->taxes_type = $customerList->taxes;
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
                'quantity' => $this->quantity,
                'price' => $this->price,
                'tgl_kirim_update' => $this->shipping_date,
                'spk_status' => 'New',
                'spk_state' => 'Running',
                'sub_spk' => $this->sub_spk,
                'spk_parent' => $this->spk_parent,
                'fsc_type' => $this->fsc_type,
                'spk_number_fsc' => $this->spk_number_fsc,
                'follow_up' => $this->follow_up,
                'spk_layout_number' => $this->spk_layout_number,
                'spk_sample_number' => $this->spk_sample_number,
                'type_ppn' => $this->type_ppn,
                'ppn' => $this->ppn,
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
                    "user_id" => "2"
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
                    "user_id" => "2"
                ], [
                    "name" => "Penjadwalan",
                    "id" => "2",
                    "user_id" => "4"
                ]);

                // Menambahkan elemen setelah "Hitung Bahan" (sebagai gantinya)
                $index = array_search("Hitung Bahan", array_column($this->workSteps, "name"));
                array_splice($this->workSteps, $index + 1, 0, [[
                    "name" => "RAB",
                    "id" => "3",
                    "user_id" => null
                ]]);
            }
            
            $no = 0;
            foreach ($this->workSteps as $step) {
                WorkStep::create([
                    'instruction_id' => $instruction->id,
                    'work_step_list_id' => $step['id'],
                    'status_id' => 1,
                    'job_id' => 2,
                    'state' => 'Not Running',
                    'status' => 'Waiting',
                    'step' => $no,
                    'task' => 'Running',
                    'user_id' => $step['user_id'],
                ]);
                $no++;
            }

            //update selesai
            WorkStep::where('instruction_id', $instruction->id)->where('work_step_list_id', 1)
                ->update([
                    'dikerjakan' => Carbon::now()->toDateTimeString(),
                    'selesai' => Carbon::now()->toDateTimeString()
                ]);

            if($this->uploadFiles()){
                $this->uploadFiles();
            }
            
            if($this->notes){
                foreach ($this->notes as $input) {
                    $catatan = Catatan::create([
                        'tujuan' => $input['tujuan'],
                        'catatan' => $input['catatan'],
                        'kategori' => 'catatan',
                        'instruction_id' => $instruction->id,
                        // 'user_id' => 1,
                    ]);
                }
            }
            
            // Setelah data disimpan, reset array $workSteps
            $this->workSteps = [];

            session()->flash('success', 'Instruksi kerja berhasil disimpan.');
            
            $this->reset();
            $this->mount();
            // $this->dispatchBrowserEvent('reset-select2');
            // $this->reset(['customer', 'spk_parent', 'spk_layout_number', 'spk_sample_number']);
            // $this->emit('resetSelect2');
            // $this->emit('saved'); // Panggil event 'saved'

        }else{
            session()->flash('error', 'Instruksi kerja pernah dibuat sebelumnya, karena po konsumen sudah pernah dibuatkan spk.');
        }
        
        
    }

    public function generateCode()
    {   
        $this->validate([
            'spk_type' => 'required',
            'customer' => 'required',
        ]);


        if($this->spk_type == 'layout' || $this->spk_type == 'sample'){
            $count_spk = Instruction::whereIn('spk_type', ['layout', 'sample'])->count();
            $this->spk_number = 'P-' . sprintf("1%04d", $count_spk + 1);
        }else if($this->spk_type == 'production'){
            $datacustomerlist = Customer::find($this->customer);

            if(isset($this->spk_parent)){
                $nomor_spk_parent = Instruction::where('spk_parent', $this->spk_parent)
                                        ->where('spk_type', $this->spk_type)
                                        ->where('taxes_type', $datacustomerlist->taxes)
                                        ->latest('spk_number')->first();
                $nomor_parent = Str::between($this->spk_parent, '-', '-');
            }else{
                $nomor_spk = Instruction::where('spk_type', $this->spk_type)
                                    ->where('spk_parent', NULL)
                                    ->where('taxes_type', $datacustomerlist->taxes)
                                    ->count();
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

        }if($this->spk_type == 'stock'){
            $nomor_spk = Instruction::where('spk_type', $this->spk_type)
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
