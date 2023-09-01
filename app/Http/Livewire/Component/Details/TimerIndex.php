<?php

namespace App\Http\Livewire\Component\Details;

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
    public $workStepData;

    public function mount($instructionId, $workStepId)
    {
        $this->currentInstructionId = $instructionId;
        $this->currentWorkStepId = $workStepId;
        $this->workStepData = WorkStep::find($this->currentWorkStepId);
        $this->timerDataWorkStep = $this->workStepData->timer;
    }

    public function render()
    {
        return view('livewire.component.details.timer-index');
    }
}
