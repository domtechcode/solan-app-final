<?php

namespace App\Http\Livewire\HitungBahan\Index;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\WorkStep;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;

class IndexCreateFormHitungBahan extends Component
{
    public $instructionSelectedId;

    public function mount($instructionId)
    {
        $this->instructionSelectedId = $instructionId;
        $updateUserWorkStep = WorkStep::where('instruction_id', $this->instructionSelectedId)
            ->where('work_step_list_id', 5)
            ->first();

        if($updateUserWorkStep->status_task == 'Pending Approved'){
            $updateUserWorkStep->update([
                'user_id' => Auth()->user()->id,
                'dikerjakan' => Carbon::now()->toDateTimeString(),
                'state_task' => 'Running',
                'status_task' => 'Process',
            ]);    
        }else{
            $updateUserWorkStep->update([
                'user_id' => Auth()->user()->id,
                'dikerjakan' => Carbon::now()->toDateTimeString(),
                'state_task' => 'Running',
                'status_task' => 'Revisi Qty',
            ]);    
        }

        if ($updateUserWorkStep->status_id == 1) {
            $updateJobStatus = WorkStep::where('instruction_id', $this->instructionSelectedId)->update([
                'status_id' => 2,
            ]);
        }

        event(new IndexRenderEvent('refresh'));
    }

    public function render()
    {
        return view('livewire.hitung-bahan.index.index-create-form-hitung-bahan', [
            'title' => 'Form Hitung Bahan',
        ])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Form Hitung Bahan']);
    }

    public function messageSent($arguments)
    {
        $createdMessage = $arguments['createdMessage'];
        $selectedConversation = $arguments['selectedConversation'];
        $receiverUser = $arguments['receiverUser'];
        $instruction_id = $arguments['instruction_id'];

        event(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, $receiverUser));
    }
}
