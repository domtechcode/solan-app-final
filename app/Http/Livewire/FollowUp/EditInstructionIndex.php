<?php

namespace App\Http\Livewire\FollowUp;

use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\Customer;
use App\Models\WorkStep;
use App\Models\Instruction;
use App\Models\WorkStepList;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditInstructionIndex extends Component
{
    use WithFileUploads;
    public $filecontoh = [];
    public $filearsip = [];
    public $fileaccounting = [];
    public $notes = [];

    public $instructions;
    public $spk_type;
    public $customer;
    public $customerCurrent;
    public $taxes_type;
    public $sub_spk;
    public $spk_parent;
    public $spk_number;
    public $spk_fsc;
    public $fsc_type;
    public $spk_number_fsc;
    public $order_date;
    public $shipping_date;
    public $shipping_date_change;
    public $customer_number;
    public $order_name;
    public $code_style;
    public $quantity;
    public $price;
    public $follow_up;
    public $type_ppn;
    public $ppn = 11.2 / 100;
    public $spk_layout_number;
    public $spk_sample_number;

    //data
    public $datacustomers = [];
    public $dataparents = [];
    public $datalayouts = [];
    public $datasamples = [];
    public $dataworksteplists = [];

    public $workSteps = [];
    
    public $filecontohCurrent;
    public $filearsipCurrent;
    public $fileaccountingCurrent;

    public $currentInstructionId;


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

    public function mount($instructionId)
    {
        $this->currentInstructionId = $instructionId;
        $this->datacustomers = Customer::all();
        $this->dataparents = Instruction::where('spk_number', 'LIKE', '%-A')->orderByDesc('created_at')->get();
        $this->datalayouts = Instruction::where('spk_type', 'layout')->orderByDesc('created_at')->get();
        $this->datasamples = Instruction::where('spk_type', 'sample')->orderByDesc('created_at')->get();
        $this->dataworksteplists = WorkStepList::whereNotIn('name', ['Follow Up', 'Penjadwalan', 'RAB'])->get();

        $this->instructions = Instruction::findorfail($instructionId);
        $this->spk_type = $this->instructions->type_order;
        $this->sub_spk = $this->instructions->sub_spk;
        $this->customerCurrent = Customer::where('name', $this->instructions->customer_name)->where('taxes', $this->instructions->taxes_type)->first();
        $this->customer = $this->customerCurrent->id;
        $this->spk_parent = $this->instructions->spk_parent;
        $this->spk_number = $this->instructions->spk_number;
        $this->spk_fsc = $this->instructions->spk_fsc;
        $this->fsc_type = $this->instructions->fsc_type;
        $this->spk_number_fsc = $this->instructions->spk_number_fsc;
        $this->order_date = $this->instructions->order_date;
        $this->shipping_date = $this->instructions->shipping_date_first;
        $this->shipping_date_change = $this->instructions->shipping_date;
        $this->customer_number = $this->instructions->customer_number;
        $this->order_name = $this->instructions->order_name;
        $this->code_style = $this->instructions->code_style;
        $this->quantity = currency_idr($this->instructions->quantity);
        $this->price = currency_idr($this->instructions->price);
        $this->follow_up = $this->instructions->follow_up;
        $this->type_ppn = $this->instructions->type_ppn;
        $this->spk_layout_number = $this->instructions->spk_layout_number;
        $this->spk_sample_number = $this->instructions->spk_sample_number;

        $dataWorkStep = WorkStep::where('instruction_id', $instructionId)
            ->whereNotIn('work_step_list_id', [1, 2, 3])
            ->with('workStepList')
            ->get();

        $this->workSteps = [];

        foreach ($dataWorkStep as $workStep) {
            $this->workSteps[] = [
                "name" => $workStep->workStepList->name,
                "id" => $workStep->work_step_list_id
            ];
        }

        $this->filecontohCurrent = Files::where('instruction_id', $instructionId)->where('type_file', 'contoh')->get();
        $this->filearsipCurrent = Files::where('instruction_id', $instructionId)->where('type_file', 'arsip')->get();
        $this->fileaccountingCurrent = Files::where('instruction_id', $instructionId)->where('type_file', 'accounting')->get();

        $dataNotes = Catatan::where('instruction_id', $instructionId)->where('kategori', 'catatan')->where('user_id', 1)->get();
        $this->notes = [];

        foreach($dataNotes as $note) {
            $this->notes[] = [
                "tujuan" => $note->tujuan,
                "catatan" => $note->catatan,
            ];
        }
        
        $this->select2();
    }

    public function render()
    {
        return view('livewire.follow-up.edit-instruction-index', [
            'title' => 'Form Edit Instruksi Kerja'
        ])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Form Edit Instruksi Kerja']);
    }

    public function update()
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
        $dataInstruction = Instruction::where('customer_number', $this->customer_number)->first();

        if($this->spk_type == 'stock'){
            $this->spk_type = 'production';
            $this->taxes_type = 'nonpajak';
            $this->type_order = 'stock';
        }else{
            $this->taxes_type = $customerList->taxes;
            $this->type_order = $this->spk_type;
        }

        if($dataInstruction != null){
            $instruction = Instruction::where('id', $this->currentInstructionId)->update([
                'spk_type' => $this->spk_type,
                'spk_number' => $this->spk_number,
                'order_date' => $this->order_date,
                'shipping_date' => $this->shipping_date_change,
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

            $lastWorkStep = WorkStep::where('instruction_id', $this->currentInstructionId)->get();

            // $this->workSteps = array_map(function ($workSteps) {
            //     $workSteps['user_id'] = null;
            //     return $workSteps;
            // }, $this->workSteps);

            // if($this->spk_type == 'layout'){
            //     // Menambahkan elemen sebelum array indeks 0
            //     array_unshift($this->workSteps, [
            //         "name" => "Follow Up",
            //         "id" => "1",
            //         "user_id" => "2"
            //     ], [
            //         "name" => "Penjadwalan",
            //         "id" => "2",
            //         "user_id" => "4"
            //     ]);
            // }else{
            //     // Menambahkan elemen sebelum array indeks 0
            //     array_unshift($this->workSteps, [
            //         "name" => "Follow Up",
            //         "id" => "1",
            //         "user_id" => "2"
            //     ], [
            //         "name" => "Penjadwalan",
            //         "id" => "2",
            //         "user_id" => "4"
            //     ]);

                
            //     $index = array_search("Hitung Bahan", array_column($this->workSteps, "name"));
            //     if ($index !== false) {
            //         array_splice($this->workSteps, $index + 1, 0, [
            //             [
            //                 "name" => "RAB",
            //                 "id" => "3",
            //                 "user_id" => null
            //             ]
            //         ]);
            //     }                
            // }
            
            // $no = 0;
            // foreach ($this->workSteps as $step) {
            //     WorkStep::create([
            //         'instruction_id' => $instruction->id,
            //         'work_step_list_id' => $step['id'],
            //         'state_task' => 'Not Running',
            //         'status_task' => 'Waiting',
            //         'step' => $no,
            //         'task' => 'Running',
            //         'user_id' => $step['user_id'],
            //     ]);
            //     $no++;
            // }

            // //update selesai
            // WorkStep::where('instruction_id', $instruction->id)->where('step', 0)
            //     ->update([
            //         'state_task' => 'Complete',
            //         'status_task' => 'Complete',
            //         'target_date' => Carbon::now(),
            //         'schedule_date' => Carbon::now(),
            //         'dikerjakan' => Carbon::now()->toDateTimeString(),
            //         'selesai' => Carbon::now()->toDateTimeString()
            //     ]);
            
            // $firstWorkStep = WorkStep::where('instruction_id', $instruction->id)->where('step', 2)->first();
            // $workStepList = WorkStepList::find($firstWorkStep->work_step_list_id);

            // if($workStepList->name == 'Cari/Ambil Stock'){
            //     $statusId = 1;
            //     $JobId = 7;
            // }else if($workStepList->name == 'Hitung Bahan'){
            //     $statusId = 1;
            //     $JobId = 3;
            // // }else if($workStepList->name == 'Setting'){
            // //     $statusId = 1;
            // //     $JobId = 8;
            // }else{
            //     $statusId = 1;
            //     $JobId = 2;
            // }

            // //cari no 1 langkah kerjanya
            // WorkStep::where('instruction_id', $instruction->id)->where('step', 2)
            //     ->update([
            //         'state_task' => 'Running',
            //         'status_task' => 'Pending Approved',
            //         'dikerjakan' => Carbon::now()->toDateTimeString(),
            //     ]);

            // WorkStep::where('instruction_id', $instruction->id)
            //     ->update([
            //         'status_id' => $statusId,
            //         'job_id' => $JobId,
            //     ]);

            
            // if ($this->spk_layout_number) {
            //     $selectedLayout = Instruction::where('spk_number', $this->spk_layout_number)->first();
            //     $files = Files::where('instruction_id', $selectedLayout->id)->where('type_file', 'layout')->get();
            //     $folder = "public/".$this->spk_number."/follow-up";

            //     if($files){
            //         foreach ($files as $file) {
            //             $sourcePath = $file->file_path.'/'.$file->file_name;
            //             $newFileName = $file->file_name;
                
            //             if (!Storage::exists($folder.'/'.$newFileName)) {
            //                 // Copy the file to the destination folder with the new name
            //                 Storage::copy($sourcePath, $folder.'/'.$newFileName);
                    
            //                 Files::create([
            //                     'instruction_id' => $instruction->id,
            //                     "user_id" => "2",
            //                     "type_file" => "layout",
            //                     "file_name" => $newFileName,
            //                     "file_path" => $folder,
            //                 ]);
            //             }
            //         }
            //     }
            // }    

            
            // if ($this->spk_sample_number) {
            //     $selectedSample = Instruction::where('spk_number', $this->spk_sample_number)->first();
            //     $files = Files::where('instruction_id', $selectedSample->id)->where('type_file', 'sample')->get();
            //     $folder = "public/".$this->spk_number."/follow-up";

            //     if($files){
            //         foreach ($files as $file) {
            //             $sourcePath = $file->file_path.'/'.$file->file_name;
            //             $newFileName = $file->file_name;
                
            //             if (!Storage::exists($folder.'/'.$newFileName)) {
            //                 // Copy the file to the destination folder with the new name
            //                 Storage::copy($sourcePath, $folder.'/'.$newFileName);
                    
            //                 Files::create([
            //                     'instruction_id' => $instruction->id,
            //                     "user_id" => "2",
            //                     "type_file" => "sample",
            //                     "file_name" => $newFileName,
            //                     "file_path" => $folder,
            //                 ]);
            //             }
            //         }
            //     }
            // }    

            // if($this->uploadFiles($instruction->id)){
            //     $this->uploadFiles($instruction->id);
            // }
            
            // if($this->notes){
            //     foreach ($this->notes as $input) {
            //         $catatan = Catatan::create([
            //             'tujuan' => $input['tujuan'],
            //             'catatan' => $input['catatan'],
            //             'kategori' => 'catatan',
            //             'instruction_id' => $instruction->id,
            //             'user_id' => 1,
            //         ]);
            //     }
            // }
            
            // // Setelah data disimpan, reset array $workSteps
            // $this->workSteps = [];

            session()->flash('success', 'Instruksi kerja berhasil disimpan.');
            $this->emit('flashMessage', [
                'type' => 'success',
                'title' => 'Create Instruksi Kerja',
                'message' => 'Berhasil membuat instruksi kerja',
            ]);

            // $this->reset();
            // $this->dispatchBrowserEvent('pondReset');
            // return redirect()->route('dashboard');
            
        }else{

            $this->emit('flashMessage', [
                'type' => 'error',
                'title' => 'Error Instruksi Kerja',
                'message' => 'Instruksi kerja pernah dibuat sebelumnya, karena po konsumen sudah terpakai',
            ]);
        }
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

    public function deleteFileContoh($fileId)
    {
        $file = Files::find($fileId);

        if ($file) {
            Storage::delete($file->file_path.'/'.$file->file_name);
            $file->delete();
            $this->filecontohCurrent = $this->filecontohCurrent->where('id', '!=', $fileId);

            $this->emit('flashMessage', [
                'type' => 'success',
                'title' => 'Delete File Contoh',
                'message' => 'Berhasil hapus file contoh',
            ]);
        }
    }

    public function deleteFileArsip($fileId)
    {
        $file = Files::find($fileId);

        if ($file) {
            Storage::delete($file->file_path.'/'.$file->file_name);
            $file->delete();
            $this->filearsipCurrent = $this->filearsipCurrent->where('id', '!=', $fileId);

            $this->emit('flashMessage', [
                'type' => 'success',
                'title' => 'Delete File Contoh',
                'message' => 'Berhasil hapus file contoh',
            ]);
        }
    }

    public function deleteFileAccounting($fileId)
    {
        $file = Files::find($fileId);

        if ($file) {
            Storage::delete($file->file_path.'/'.$file->file_name);
            $file->delete();
            $this->fileaccountingCurrent = $this->fileaccountingCurrent->where('id', '!=', $fileId);
        }
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
