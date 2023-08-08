<?php

namespace App\Http\Livewire\FollowUp\Component;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\Customer;
use App\Models\WorkStep;
use App\Models\Instruction;
use Illuminate\Support\Str;
use App\Models\WorkStepList;
use Livewire\WithFileUploads;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
    public $keteranganReject;
    public $keteranganCatatan;
    public $qtyState;


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
        $this->keteranganReject = Catatan::where('instruction_id', $this->currentInstructionId)->where('tujuan', 1)->where('kategori', 'reject')->get();
        $this->keteranganCatatan = Catatan::where('instruction_id', $this->currentInstructionId)->where('tujuan', 1)->where('kategori', 'catatan')->get();
        $this->datacustomers = Customer::all();
        $this->dataparents = Instruction::where('spk_parent', null)->where('sub_spk', 'sub')->orderByDesc('created_at')->get();
        $this->datalayouts = Instruction::where('spk_type', 'layout')->orderByDesc('created_at')->get();
        $this->datasamples = Instruction::where('spk_type', 'sample')->orderByDesc('created_at')->get();
        $this->dataworksteplists = WorkStepList::whereNotIn('name', ['Follow Up', 'Penjadwalan', 'RAB'])->get();

        $this->instructions = Instruction::findorfail($instructionId);
        $this->spk_type = $this->instructions->type_order;
        $this->sub_spk = $this->instructions->sub_spk;
        $this->customerCurrent = Customer::where('name', $this->instructions->customer_name)->where('taxes', $this->instructions->taxes_type)->first();
        if(isset($this->customerCurrent)){
	
	$this->customer = $this->customerCurrent->id;
	}else{
	$this->customer = '';
	}
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
        return view('livewire.follow-up.component.edit-instruction-index', [
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
            'qtyState' => 'required',
            'price' => 'numeric|regex:/^\d*(\.\d{1,2})?$/',
        ], [
            'price.numeric' => 'Price harus berupa angka/tidak boleh ada tanda koma(,).',
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
                'price' => $this->price,
                'shipping_date_first' => $this->shipping_date,
                'spk_state' => 'New',
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
        
            $lastWorkStep = WorkStep::where('instruction_id', $this->currentInstructionId)->get();
            $deleteWorkStep = WorkStep::where('instruction_id', $this->currentInstructionId)->delete();

            $no = 0;
            foreach ($this->workSteps as $step) {
            $newWorkStep =  WorkStep::create([
                    'instruction_id' => $this->currentInstructionId,
                    'work_step_list_id' => $step['id'],
                    'state_task' => 'Not Running',
                    'status_task' => 'Waiting',
                    'step' => $no,
                    'task_priority' => 'Normal',
                    'user_id' => $step['user_id'],
                ]);
                $no++;
            }

            
            foreach ($lastWorkStep as $lastwork) {
                $updateWorkStep = WorkStep::where('instruction_id', $this->currentInstructionId)->where('work_step_list_id', $lastwork->work_step_list_id)
                ->update([
                    'user_id' => $lastwork->user_id,
                    'machine_id' => $lastwork->machine_id,
                    'target_date' => $lastwork->target_date,
                    'schedule_date' => $lastwork->schedule_date,
                    'target_time' => $lastwork->target_time,
                    'step' => $lastwork->step,
                    'state_task' => $lastwork->state_task,
                    'status_task' => $lastwork->status_task,
                    'dikerjakan' => $lastwork->dikerjakan,
                    'selesai' => $lastwork->selesai,
                    'task_priority' => $lastwork->task_priority,
                    'spk_status' => $lastwork->spk_status,
                    'reject_from_id' => $lastwork->reject_from_id,
                    'reject_from_status' => $lastwork->reject_from_status,
                    'reject_from_job' => $lastwork->reject_from_job,
                    'count_reject' => $lastwork->count_reject,
                    'count_revisi' => $lastwork->count_revisi,
                    'task_priority' => $lastwork->task_priority,
                    'dikerjakan' => $lastwork->dikerjakan,
                    'selesai' => $lastwork->selesai,
                    'keterangan_reject' => $lastwork->keterangan_reject,
                    'keterangan_reschedule' => $lastwork->keterangan_reschedule,
                    'spk_status' => $lastwork->spk_status,
                ]);
            }

            
            $currentWorkStep = WorkStep::where('instruction_id', $this->currentInstructionId)->where('work_step_list_id', 1)->first();
            $findSourceReject = WorkStep::where('instruction_id', $this->currentInstructionId)->where('work_step_list_id', $currentWorkStep->reject_from_job)->first();
            
            if($this->qtyState == 'Ya'){
                $updateWorkStepEstimator = WorkStep::where('instruction_id', $this->currentInstructionId)->where('work_step_list_id', 5)->update([
                    'state_task' => 'Running',
                    'status_task' => 'Revisi Qty',
                ]);

                $updateWorkStep = WorkStep::where('instruction_id', $this->currentInstructionId)->update([
                    'status_id' => 26,
                    'job_id' => 5,
                    'state_task' => 'Running',
                    'status_task' => 'Process',
                    'spk_status' => 'Running',
                ]);

                $updateWorkStepRab = WorkStep::where('instruction_id', $this->currentInstructionId)->where('work_step_list_id', 3)->update([
                    'state_task' => 'Not Running',
                    'status_task' => 'Waiting',
                ]);

                $userDestinationEstimator = User::where('role', 'Hitung Bahan')->get();
                foreach($userDestinationEstimator as $dataUser){
                    $this->messageSent(['conversation' => 'QTY SPK telah diperbaiki oleh Follow Up', 'receiver' => $dataUser->id, 'instruction_id' => $this->currentInstructionId]);
                }


                $userDestinationEstimator = User::where('role', 'RAB')->get();
                foreach($userDestinationEstimator as $dataUser){
                    $this->messageSent(['conversation' => 'QTY SPK telah diperbaiki oleh Follow Up', 'receiver' => $dataUser->id, 'instruction_id' => $this->currentInstructionId]);
                }
            }else{
                $findSourceReject->update([
                    'status_task' => 'Pending Approved',
                ]);
    
                $updateJobStatus = WorkStep::where('instruction_id', $this->currentInstructionId)->update([
                    'status_id' => $currentWorkStep->reject_from_status,
                    'job_id' => $currentWorkStep->reject_from_job,
                ]);
                
                //notif
                $this->messageSent(['conversation' => 'SPK telah diperbaiki oleh Follow Up', 'receiver' => $findSourceReject->user_id, 'instruction_id' => $this->currentInstructionId]);
                broadcast(new IndexRenderEvent('refresh'));
            }

            $currentWorkStep->update([
                'reject_from_id' => null,
                'reject_from_status' => null,
                'reject_from_job' => null,
                'state_task' => 'Running',
                'status_task' => 'Process',
                'selesai' => Carbon::now()->toDateTimeString()
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
                                'instruction_id' => $this->currentInstructionId,
                                "user_id" => "2",
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
                                'instruction_id' => $this->currentInstructionId,
                                "user_id" => "2",
                                "type_file" => "sample",
                                "file_name" => $newFileName,
                                "file_path" => $folder,
                            ]);
                        }
                    }
                }
            }    

            if($this->uploadFiles($this->currentInstructionId)){
                $this->uploadFiles($this->currentInstructionId);
            }
            
            Catatan::where('user_id', 1)->where('kategori', 'catatan')->where('instruction_id', $this->currentInstructionId)->delete();
            if($this->notes){
                foreach ($this->notes as $input) {
                    $catatan = Catatan::create([
                        'tujuan' => $input['tujuan'],
                        'catatan' => $input['catatan'],
                        'kategori' => 'catatan',
                        'instruction_id' => $this->currentInstructionId,
                        'user_id' => 1,
                    ]);
                }
            }
            
            
            
            $this->emit('flashMessage', [
                'type' => 'success',
                'title' => 'Create Instruksi Kerja',
                'message' => 'Berhasil membuat instruksi kerja',
            ]);

            return redirect()->route('followUp.dashboard');
            
        }else{

            $this->emit('flashMessage', [
                'type' => 'error',
                'title' => 'Error Instruksi Kerja',
                'message' => 'Instruksi kerja pernah dibuat sebelumnya, karena po konsumen sudah terpakai',
            ]);
        }
    }

    public function messageSent($arguments)
    {
        $createdMessage = "info";
        $selectedConversation = $arguments['conversation'];
        $receiverUser = $arguments['receiver'];
        $instruction_id = $arguments['instruction_id'];

        broadcast(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, $receiverUser));
    }

    public function uploadFiles($instructionId)
    {
        $folder = "public/".$this->spk_number."/follow-up";

        
        $nocontoh = Files::where('instruction_id', $instructionId)->where('type_file', 'contoh')->count();
        foreach ($this->filecontoh as $file) {
            $nocontoh ++;
            $fileName = $this->spk_number . '-file-contoh-'.$nocontoh . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs($folder, $file, $fileName);
            
            Files::create([
                'instruction_id' => $instructionId,
                "user_id" => "2",
                "type_file" => "contoh",
                "file_name" => $fileName,
                "file_path" => $folder,
            ]);
        }

        $noarsip = Files::where('instruction_id', $instructionId)->where('type_file', 'arsip')->count();
        foreach ($this->filearsip as $file) {
            $noarsip ++;
            $fileName = $this->spk_number . '-file-arsip-'.$noarsip . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs($folder, $file, $fileName);

            Files::create([
                'instruction_id' => $instructionId,
                "user_id" => "2",
                "type_file" => "arsip",
                "file_name" => $fileName,
                "file_path" => $folder,
            ]);
        }

        $noarsipaccounting = Files::where('instruction_id', $instructionId)->where('type_file', 'accounting')->count();
        foreach ($this->fileaccounting as $file) {
            $noarsipaccounting ++;
            $fileName = $this->spk_number . '-file-arsip-accounting-'.$noarsipaccounting . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs($folder, $file, $fileName);

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
            $nomor_urut = $count_spk + 447;
            $this->spk_number = 'P-' . sprintf("1%04d", $nomor_urut + 1);
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
                $nomor_urut = $nomor_spk + 537;
                $this->spk_number = 'SLN' . date('y') . '-' . sprintf("1%04d", $nomor_urut + 1);
            }else if($datacustomerlist->taxes == 'pajak' && isset($this->sub_spk) && empty($this->spk_parent)){
                $nomor_urut = $nomor_spk + 537;
                $this->spk_number = 'SLN' . date('y') . '-' . sprintf("1%04d", $nomor_urut + 1). '-A';
            }else if($datacustomerlist->taxes == 'pajak' && isset($this->sub_spk) && isset($this->spk_parent)){
                $this->spk_number = 'SLN' . date('y') . '-' . sprintf($nomor_parent) . '-' . sprintf(++$code_alphabet);
            }if($datacustomerlist->taxes == 'nonpajak' && empty($this->sub_spk) && empty($this->spk_parent)){
                $nomor_urut = $nomor_spk + 145;
                $this->spk_number = date('y') . '-' . sprintf("1%04d", $nomor_urut + 1);
            }else if($datacustomerlist->taxes == 'nonpajak' && isset($this->sub_spk) && empty($this->spk_parent)){
                $nomor_urut = $nomor_spk + 145;
                $this->spk_number = date('y') . '-' . sprintf("1%04d", $nomor_urut + 1). '-A';
            }else if($datacustomerlist->taxes == 'nonpajak' && isset($this->sub_spk) && isset($this->spk_parent)){
                $this->spk_number = date('y') . '-' . sprintf($nomor_parent) . '-' . sprintf(++$code_alphabet);
            }

        }else if($this->spk_type == 'stock'){
            if(isset($this->spk_parent)){
                $nomor_spk_parent = Instruction::where('spk_parent', $this->spk_parent)
                                        ->where('spk_type', $this->spk_type)
                                        ->where('taxes_type', $datacustomerlist->taxes)
                                        ->latest('spk_number')->first();
                $nomor_parent = Str::between($this->spk_parent, '-', '-');
            }else{
                $nomor_spk = Instruction::where('spk_type', 'production')
                    ->where('spk_parent', NULL)
                    ->where('taxes_type', 'nonpajak')
                    ->count();
                
            }

            if (isset($nomor_spk_parent)) {
                $code_alphabet = substr($nomor_spk_parent['spk_number'], -1);
            } else {
                $code_alphabet = 'A';
            }
            
            if(empty($this->sub_spk) && empty($this->spk_parent)){
                $nomor_urut = $nomor_spk + 145;
                $this->spk_number = date('y') . '-' . sprintf("1%04d", $nomor_urut + 1). '(STK)';
            }else if(isset($this->sub_spk) && empty($this->spk_parent)){
                $nomor_urut = $nomor_spk + 145;
                $this->spk_number = date('y') . '-' . sprintf("1%04d", $nomor_urut + 1). '-A(STK)';
            }else if(isset($this->sub_spk) && isset($this->spk_parent)){
                $this->spk_number = date('y') . '-' . sprintf($nomor_parent) . '-' . sprintf(++$code_alphabet).'(STK)';
            }
            
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

    public function sampleRecord()
    {
        $this->validate([
            'spk_number' => 'required',
            'customer' => 'required',
            'order_date' => 'required',
            'order_name' => 'required',
        ]);

        $customer = Customer::find($this->customer);
        $customer_name = $customer ? $customer->name : '';

        $reader = IOFactory::createReader('Xlsx');
        $reader->setLoadSheetsOnly('Sheet1');
        $spreadsheet = $reader->load("samplerecord.xlsx");

        $spreadsheet->getActiveSheet()->setCellValue('B4', $this->order_date);
        $spreadsheet->getActiveSheet()->setCellValue('J4', $this->spk_number);
        $spreadsheet->getActiveSheet()->setCellValue('C5', $this->order_name);
        $spreadsheet->getActiveSheet()->setCellValue('I5', $customer_name);

        // Generate the Excel file in memory
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        // Set the response headers for download
        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="Sample-Record-' . $this->spk_number . '.xlsx"');
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }
}
