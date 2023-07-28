<?php

namespace App\Http\Livewire\Operator\Index;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\WorkStep;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;

class IndexWorkStep extends Component
{
    public $instructionSelectedId;
    public $workStepSelectedId;
    public $workStepData;

    public function mount($instructionId, $workStepId)
    {
        $this->instructionSelectedId = $instructionId;
        $this->workStepSelectedId = $workStepId;
        $dataWorkStep = WorkStep::find($this->workStepSelectedId);
        $dataWorkStep->update([
            'dikerjakan' => Carbon::now()->toDateTimeString(),
        ]);

        $updateJobStatus = WorkStep::where('instruction_id', $this->instructionSelectedId)->update([
            'status_id' => 2,
        ]);

        $this->workStepData = WorkStep::find($this->workStepSelectedId);

        $userDestination = User::where('role', 'Penjadwalan')->get();
        foreach($userDestination as $dataUser){
            $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Sedang dikerjakan ' .Auth()->user()->jobdesk, 'instruction_id' => $this->instructionSelectedId]);
        }
        broadcast(new IndexRenderEvent('refresh'));
    }

    public function messageSent($arguments)
    {
        $createdMessage = "info";
        $selectedConversation = $arguments['conversation'];
        $receiverUser = $arguments['receiver'];
        $instruction_id = $arguments['instruction_id'];

        broadcast(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, $receiverUser));
    }

    public function render()
    {
        return view('livewire.operator.index.index-work-step', [
            'title' => 'Order SPK'
        ])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Order SPK']);
    }
}
