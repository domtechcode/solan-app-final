<?php

namespace App\Http\Livewire\Rab\Component;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Catatan;
use App\Models\FormRab;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use App\Models\LayoutBahan;
use App\Models\KeteranganPlate;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;

class EditFormRabIndex extends Component
{
    public $rabItems = [];
    public $instructionItems = [];
    public $workSteps;
    public $keteranganReject;
    public $currentInstructionId;
    public $notes = [];

    public function addRAB()
    {
        $this->rabItems[] = [
            'jenisPengeluaran' => '',
            'rab' => '',
        ];
    }

    public function removeRAB($index)
    {
        unset($this->rabItems[$index]);
        $this->rabItems = array_values($this->rabItems);
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
        
        $cekGroup = Instruction::where('id', $instructionId)
            ->whereNotNull('group_id')
            ->whereNotNull('group_priority')
            ->first();

        if (!$cekGroup){
            $this->instructionData = Instruction::where('id', $instructionId)->get();
            foreach ($this->instructionData as $instruction) {
                $this->instructionItems[] = [
                    'spk_number' => $instruction->spk_number,
                    'price' => currency_idr($instruction->price),
                ];
            }
        }else{
            $instructionGroup = Instruction::where('group_id', $cekGroup->group_id)->get();
            $this->instructionData = Instruction::whereIn('id', $instructionGroup->pluck('id'))->get();
            foreach ($this->instructionData as $instruction) {
                $this->instructionItems[] = [
                    'spk_number' => $instruction->spk_number,
                    'price' => currency_idr($instruction->price),
                ];
            }
        }

        $this->workSteps = WorkStep::where('instruction_id', $instructionId)->with('workStepList')->get();

        $formRab = FormRab::where('instruction_id', $instructionId)->get();

        $newHargaBahan = LayoutBahan::where('instruction_id', $instructionId)->sum('harga_bahan');
        $newJumlahBahan = LayoutBahan::where('instruction_id', $instructionId)->sum('jumlah_bahan');
        $newTotalHargaBahan = $newHargaBahan * $newJumlahBahan;

        if(isset($formRab)){
            foreach($formRab as $dataRab){
                if($dataRab['jenis_pengeluaran'] == 'Bahan Baku'){
                    $rab = [
                        'jenisPengeluaran' => $dataRab['jenis_pengeluaran'],
                        'rab' => currency_idr($newTotalHargaBahan),
                    ];
                }else{
                    $rab = [
                        'jenisPengeluaran' => $dataRab['jenis_pengeluaran'],
                        'rab' => currency_idr($dataRab['rab']),
                    ];
                }
                
                $this->rabItems[] = $rab;
            }
            
        }

    }

    public function render()
    {
        return view('livewire.rab.component.edit-form-rab-index')->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Form Edit RAB']);
    }

    public function save()
    {
        $this->validate([
            'rabItems.*.jenisPengeluaran' => 'required',
            'rabItems.*.rab' => 'required',
            'instructionItems.*.price' => 'required',
        ]);
        
        foreach($this->instructionItems as $dataInstructionItem){
            $updatePrice = Instruction::where('spk_number', $dataInstructionItem['spk_number'])->update([
                    'price' => $dataInstructionItem['price'], 
            ]);
        }

        $currentInstructionData = Instruction::find($this->currentInstructionId);
        $dataRabCount = FormRab::where('instruction_id', $currentInstructionData->id)->whereNotNull('updated_count')->count();

        foreach($this->rabItems as $datarabItem){
            $createRab = FormRab::create([
                    'instruction_id' => $this->currentInstructionId,
                    'user_id' => Auth()->user()->id,
                    'jenis_pengeluaran' => $datarabItem['jenisPengeluaran'], 
                    'rab' => $datarabItem['rab'], 
                    'count' => $currentInstructionData['count'], 
                    'updated_count' => $dataRabCount + 1, 
            ]);
        }

        if($this->notes){
            foreach ($this->notes as $input) {
                $catatan = Catatan::create([
                    'tujuan' => $input['tujuan'],
                    'catatan' => $input['catatan'],
                    'kategori' => 'catatan',
                    'instruction_id' => $this->currentInstructionId,
                    'user_id' => Auth()->user()->id,
                ]);
            }
        }

        $updateTask = WorkStep::where('instruction_id', $this->currentInstructionId)
                ->where('work_step_list_id', 3)
                ->first();

        if($updateTask->status_id == 22){
            if ($updateTask) {
                $updateTask->update([
                    'state_task' => 'Complete',
                    'status_task' => 'Complete',
                    'selesai' => Carbon::now()->toDateTimeString(),
                ]);
            
                $updateNextStep = WorkStep::find($updateTask->reject_from_id);
                
                if ($updateNextStep) {
                    $updateNextStep->update([
                        'state_task' => 'Running',
                        'status_task' => 'Pending Approved',
                    ]);

                    $updateStatusJob = WorkStep::where('instruction_id', $this->currentInstructionId)->update([
                        'status_id' => 1,
                        'job_id' => $updateNextStep->work_step_list_id,
                    ]);
                }

                $updateTask->update([
                    'reject_from_id' => NULL,
                    'reject_from_status' => NULL,
                    'reject_from_job' => NULL,
                ]);
            }

            $this->messageSent(['conversation' => 'SPK diperbaiki Hitung Bahan', 'instruction_id' => $this->currentInstructionId, 'receiver' => $updateNextStep->user_id]);
            broadcast(new IndexRenderEvent('refresh'));
        }else{
            if ($updateTask) {
                $updateTask->update([
                    'state_task' => 'Complete',
                    'status_task' => 'Complete',
                    'selesai' => Carbon::now()->toDateTimeString(),
                ]);
            
                $updateNextStep = WorkStep::where('instruction_id', $this->currentInstructionId)
                    ->where('step', $updateTask->step + 1)
                    ->first();
            
                if ($updateNextStep) {
                    $updateNextStep->update([
                        'state_task' => 'Running',
                        'status_task' => 'Pending Approved',
                        'schedule_date' => Carbon::now(),
                    ]);

                    $updateStatusJob = WorkStep::where('instruction_id', $this->currentInstructionId)->update([
                        'status_id' => 1,
                        'job_id' => $updateNextStep->work_step_list_id,
                    ]);
                }
            }

        $this->messageSent(['conversation' => 'SPK selesai di approve RAB', 'instruction_id' => $this->currentInstructionId, 'receiver' => $updateNextStep->user_id]);
        

        $userDestination = User::where('role', 'Accounting')->get();
                foreach($userDestination as $dataUser){
                    $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK RAB', 'instruction_id' => $this->currentInstructionId]);
                }

        broadcast(new IndexRenderEvent('refresh'));

        }
            

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Create Instruksi Kerja',
            'message' => 'Berhasil membuat instruksi kerja',
        ]);

        session()->flash('success', 'Instruksi kerja berhasil disimpan.');

        return redirect()->route('rab.dashboard');
        
    }

    public function backBtn()
    {
        $updateJobStatus = WorkStep::where('instruction_id', $this->currentInstructionId)->update([
            'status_id' => 22,
        ]);

        return redirect()->route('rab.dashboard');
    }

    public function rejectRAB()
    {
        $this->validate([
            'keteranganReject' => 'required',
        ]);

        $currentWorkStep = WorkStep::where('instruction_id', $this->currentInstructionId)->where('work_step_list_id', 3)->first();
        if($currentWorkStep){
            $currentWorkStep->update([
                'state_task' => 'Running',
                'status_task' => 'Pending Perbaikan',
                'selesai' => Carbon::now()->toDateTimeString(),
            ]);
        }

        $updateReject = WorkStep::where('instruction_id', $this->currentInstructionId)->where('work_step_list_id', 5)->first();

        $updateReject->update([
            'state_task' => 'Running',
            'status_task' => 'Reject Requirements', 
            'count_reject' => $updateReject->count_reject + 1,
            'status_id' => 22,
            'job_id' => 5,
            'reject_from_id' => $currentWorkStep->reject_from_id,
            'reject_from_status' => $currentWorkStep->reject_from_status,
            'reject_from_job' => $currentWorkStep->reject_from_job,
        ]);

        $updateJobStatus = WorkStep::where('instruction_id', $this->currentInstructionId)->update([
            'status_id' => 22,
            'job_id' => 5,
        ]);
        
        $createKeteranganReject = Catatan::create([
                    'tujuan' => 5,
                    'catatan' => $this->keteranganReject,
                    'kategori' => 'reject',
                    'instruction_id' => $this->currentInstructionId,
                    'user_id' => Auth()->user()->id,
        ]);

        $this->messageSent(['receiver' => $updateReject->user_id, 'conversation' => 'SPK reject oleh RAB', 'instruction_id' => $this->currentInstructionId]);
        broadcast(new IndexRenderEvent('refresh'));

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Reject Instruksi Kerja',
            'message' => 'Berhasil reject instruksi kerja',
        ]);

        

        return redirect()->route('rab.dashboard');
    }

    public function holdRAB()
    {
        $currentWorkStep = WorkStep::where('instruction_id', $this->currentInstructionId)->update([
            'spk_status' => 'Hold RAB',
        ]);

        broadcast(new IndexRenderEvent('refresh'));
        $this->messageSent(['conversation' => 'SPK Hold oleh RAB', 'instruction_id' => $this->currentInstructionId, 'receiver' => 2]);

        if($this->notes){
            foreach ($this->notes as $input) {
                $catatan = Catatan::create([
                    'tujuan' => $input['tujuan'],
                    'catatan' => $input['catatan'],
                    'kategori' => 'catatan',
                    'instruction_id' => $this->currentInstructionId,
                    'user_id' => Auth()->user()->id,
                ]);
            }
        }

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Hold Instruksi Kerja',
            'message' => 'Berhasil Hold instruksi kerja',
        ]);

        return redirect()->route('rab.dashboard');
    }

    public function holdQC()
    {
        $currentWorkStep = WorkStep::where('instruction_id', $this->currentInstructionId)->update([
            'spk_status' => 'Hold QC',
        ]);

        broadcast(new IndexRenderEvent('refresh'));
        $this->messageSent(['conversation' => 'SPK Hold oleh RAB', 'instruction_id' => $this->currentInstructionId, 'receiver' => 2]);

        if($this->notes){
            foreach ($this->notes as $input) {
                $catatan = Catatan::create([
                    'tujuan' => $input['tujuan'],
                    'catatan' => $input['catatan'],
                    'kategori' => 'catatan',
                    'instruction_id' => $this->currentInstructionId,
                    'user_id' => Auth()->user()->id,
                ]);
            }
        }

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Hold Instruksi Kerja',
            'message' => 'Berhasil Hold instruksi kerja',
        ]);

        return redirect()->route('rab.dashboard');
    }

    public function messageSent($arguments)
    {
        $createdMessage = "info";
        $selectedConversation = $arguments['conversation'];
        $receiverUser = $arguments['receiver'];
        $instruction_id = $arguments['instruction_id'];

        broadcast(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, $receiverUser));
    }
}
