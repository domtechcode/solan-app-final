<?php

namespace App\Http\Livewire\Component;

use App\Models\Catatan;
use Livewire\Component;
use App\Models\WorkStep;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;

class RejectOperatorIndex extends Component
{
    public $currentInstructionId;
    public $currentWorkStepId;
    public $tujuanReject;
    public $keteranganReject;
    public $operatorReject;

    public function mount($instructionId, $workStepId)
    {
        $this->currentInstructionId = $instructionId;
        $this->currentWorkStepId = $workStepId;
        $workStepData = WorkStep::find($workStepId);
        $this->operatorReject = WorkStep::where('instruction_id', $this->currentInstructionId)->where('step', '<', $workStepData->step)->where('work_step_list_id', '!=', 3)->with('workStepList')->get();      
    }

    public function rejectWorkStep($dataTujuan, $dataKeterangan)
    {
        $this->validate([
            'tujuanReject' => 'required',
            'keteranganReject' => 'required',
        ]);

        $dataWorkStep = WorkStep::find($this->currentWorkStepId);
        $updateWaiting = WorkStep::where('id', $this->currentWorkStepId)->update([
            'status_task' => 'Waiting Repair',
        ]);

        $updateReject = WorkStep::where('instruction_id', $this->currentInstructionId)->where('work_step_list_id', $this->tujuanReject)->first();

        $updateReject->update([
            'reject_from_id' => $this->currentWorkStepId, 
            'reject_from_status' => $dataWorkStep->status_id, 
            'reject_from_job' => $dataWorkStep->job_id, 
            'state_task' => 'Running', 
            'status_task' => 'Reject Requirements', 
            'status_id' => 22,
            'job_id' => $this->tujuanReject,
            'count_reject' => $updateReject->count_reject + 1,
        ]);

        $createCatatan = Catatan::create([
            'user_id' => Auth()->user()->id,
            'instruction_id' => $this->currentInstructionId,
            'catatan' => $this->keteranganReject,
            'tujuan' => $this->tujuanReject,
            'kategori' => 'reject',
        ]);

        $this->messageSent(['conversation' => 'SPK di reject oleh '. $dataWorkStep->user->name, 'instruction_id' => $this->currentInstructionId, 'receiver' => $updateReject->user_id]);
        broadcast(new IndexRenderEvent('refresh'));

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Reject Instruksi Kerja',
            'message' => 'Berhasil reject instruksi kerja',
        ]);

        return redirect()->route('operator.dashboard');
    }

    public function render()
    {
        return view('livewire.component.reject-operator-index');
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
