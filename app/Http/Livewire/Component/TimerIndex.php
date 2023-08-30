<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use App\Models\WorkStep;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;

class TimerIndex extends Component
{
    public $timer;
    public $alasanPause;
    public $timerDataWorkStep;
    public $alasanPauseData;
    public $currentInstructionId;
    public $currentWorkStepId;

    protected $listeners = ['handleSaveDataTimer' => 'saveDataTimer', 'handleSaveDataTimerPause' => 'saveDataTimerPause', 'handleAutoSaveDataTimer' => 'autoSaveDataTimer'];

    public function mount($instructionId, $workStepId)
    {
        $this->currentInstructionId = $instructionId;
        $this->currentWorkStepId = $workStepId;

        $workStepData = WorkStep::find($this->currentWorkStepId);

        if ($workStepData->timer == null) {
            $this->timerDataWorkStep = '00:00:00';
        } elseif ($workStepData->timer == 'aN:aN:aN') {
            if ($workStepData->auto_save_timer == null) {
                $this->timerDataWorkStep = '00:00:00';
            } else {
                $this->timerDataWorkStep = $workStepData->auto_save_timer;
            }
        } else {
            $this->timerDataWorkStep = $workStepData->timer;
        }

        $this->alasanPauseData = $workStepData->alasan_pause;
    }

    public function saveDataTimer($formattedTime)
    {
        $this->timer = $formattedTime;
        $updateTimer = WorkStep::where('id', $this->currentWorkStepId)->update([
            'timer' => $formattedTime,
        ]);
    }

    public function autoSaveDataTimer($formattedTime)
    {
        $this->timer = $formattedTime;
        $updateTimer = WorkStep::where('id', $this->currentWorkStepId)->update([
            'auto_save_timer' => $formattedTime,
        ]);
    }

    public function saveDataTimerPause($formattedTime)
    {
        $this->timer = $formattedTime;

        $dataAlasanPause = WorkStep::find($this->currentWorkStepId);

        // Ambil alasan pause yang sudah ada dari database
        $existingAlasanPause = json_decode($dataAlasanPause->alasan_pause, true);

        // Tambahkan alasan pause yang baru ke dalam array existingAlasanPause
        $timestampedKeterangan = $this->alasanPause . ' - [' . now() . ']';
        $existingAlasanPause[] = $timestampedKeterangan;

        // Simpan data ke database sebagai JSON
        $updatePause = WorkStep::where('id', $this->currentWorkStepId)->update([
            'timer' => $formattedTime,
            'alasan_pause' => json_encode($existingAlasanPause),
        ]);

        $this->alasanPause = '';

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Timer Pause',
            'message' => 'Pause Timer Berhasil',
        ]);
    }

    public function splitTime()
    {
        $workStepData = WorkStep::find($this->currentWorkStepId);
        $workStepData->update([
            'flag' => 'Split',
        ]);

        $workStepSplit = WorkStep::where('instruction_id', $this->currentInstructionId)
            ->where('step', $workStepData->step + 1)
            ->first();

        $workStepSplit->update([
            'state_task' => 'Running',
            'status_task' => 'Pending Approved',
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Split SPK',
            'message' => 'Split SPK Berhasil',
        ]);

        if (isset($workStepSplit->user_id)) {
            $this->messageSent(['conversation' => 'SPK Baru', 'instruction_id' => $this->currentInstructionId, 'receiver' => $workStepSplit->user_id]);
            event(new IndexRenderEvent('refresh'));
        }
    }

    public function render()
    {
        return view('livewire.component.timer-index');
    }

    public function messageSent($arguments)
    {
        $createdMessage = 'info';
        $selectedConversation = $arguments['conversation'];
        $receiverUser = $arguments['receiver'];
        $instruction_id = $arguments['instruction_id'];

        event(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, $receiverUser));
    }
}
