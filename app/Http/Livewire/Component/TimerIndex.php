<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use App\Models\WorkStep;

class TimerIndex extends Component
{
    public $timer;
    public $alasanPause;
    public $timerData = "00:00:23";


    public function save()
    {
        WorkStep::where('id', 1)->update([
            'target_time' => $this->timer,
        ]);
    }


    public function render()
    {
        return view('livewire.component.timer-index');
    }
}
