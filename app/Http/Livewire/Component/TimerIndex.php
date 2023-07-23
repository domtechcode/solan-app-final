<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use App\Models\WorkStep;

class TimerIndex extends Component
{
    public $timer;
    public $alasanPause;
    public $timerData;
    public $currentInstructionId;
    public $currentWorkStepId;

    public function mount($instructionId, $workStepId)
    {
        $this->currentInstructionId = $instructionId;
        $this->currentWorkStepId = $workStepId;
        $workStepData = WorkStep::find($workStepId);
        $this->timerData = $workStepData->timer ?? '00:00:00';   
    }

    public function saveDataTimer()
    {
        $updateTimer = WorkStep::where('id', $this->currentWorkStepId)->update([
            'timer' => $this->timer,
        ]);
    }

    public function saveDataTimerPause()
    {

        $updatePauase = WorkStep::where('id', $this->currentWorkStepId)->update([
            'timer' => $this->timer,
            'alasan_pause' => $this->alasanPause,
        ]);

        $this->alasanPause = '';

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Timer Pause',
            'message' => 'Pause Timer Berhasil',
        ]);        
    }


    public function render()
    {
        return view('livewire.component.timer-index');
    }
}
