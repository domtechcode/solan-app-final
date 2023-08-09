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

        $updateReject = WorkStep::find($this->tujuanReject);

        $updateReject->update([
            'reject_from_id' => $this->currentWorkStepId, 
            'reject_from_status' => $dataWorkStep->status_id, 
            'reject_from_job' => $dataWorkStep->job_id, 
            'state_task' => 'Running', 
            'status_task' => 'Reject Requirements', 
            'count_reject' => $updateReject->count_reject + 1,
        ]);

        $updateJobStatus = WorkStep::where('instruction_id', $this->currentInstructionId)->update([
            'status_id' => 22,
            'job_id' => $updateReject->work_step_list_id,
        ]);

        $createCatatan = Catatan::create([
            'user_id' => Auth()->user()->id,
            'instruction_id' => $this->currentInstructionId,
            'catatan' => $this->keteranganReject,
            'tujuan' => $updateReject->work_step_list_id,
            'kategori' => 'reject',
        ]);

        if($this->keteranganReject){
            $dataketeranganReject = WorkStep::find($this->tujuanReject);
            $dataketeranganRejectSource = WorkStep::find($this->currentWorkStepId);

            // Ambil alasan pause yang sudah ada dari database
            $existingketeranganReject = json_decode($dataketeranganReject->keterangan_reject, true);

            // Tambahkan alasan pause yang baru ke dalam array existingketeranganReject
            $timestampedKeterangan = $this->keteranganReject . ' - [' . now() . '] - [' .$dataketeranganRejectSource->workStepList->name. ']';
            $existingketeranganReject[] = $timestampedKeterangan;

            // Simpan data ke database sebagai JSON
            $updateCatatanPengerjaan = WorkStep::where('id', $this->tujuanReject)->update([
                'keterangan_reject' => json_encode($existingketeranganReject),
            ]);
        }

        $this->messageSent(['conversation' => 'SPK di reject oleh '. $dataWorkStep->user->name, 'instruction_id' => $this->currentInstructionId, 'receiver' => $updateReject->user_id]);
        event(new IndexRenderEvent('refresh'));

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

        event(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, $receiverUser));
    }
}
