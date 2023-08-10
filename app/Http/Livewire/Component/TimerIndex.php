<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use App\Models\WorkStep;

class TimerIndex extends Component
{
    public $timer;
    public $alasanPause;
    public $timerDataWorkStep;
    public $alasanPauseData;
    public $currentInstructionId;
    public $currentWorkStepId;

    protected $listeners = ['saveDataTimer', 'saveDataTimerPause'];

    public function mount($instructionId, $workStepId)
    {
        $this->currentInstructionId = $instructionId;
        $this->currentWorkStepId = $workStepId;
        $workStepData = WorkStep::find($workStepId);
        $this->timerDataWorkStep = $workStepData->timer ?? '00:00:00';   
        $this->alasanPauseData = $workStepData->alasan_pause;   
    }

    public function saveDataTimer($formattedTime)
    {
        $this->timer = $formattedTime;
        $updateTimer = WorkStep::where('id', $this->currentWorkStepId)->update([
            'timer' => $this->timer,
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
            'timer' => $this->timer,
            'alasan_pause' => json_encode($existingAlasanPause),
        ]);

        $this->alasanPause = '';

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Timer Pause',
            'message' => 'Pause Timer Berhasil',
        ]);        
    }

    public function saveSplitTimer($formattedTime)
    {
        
    }


    public function render()
    {
        return view('livewire.component.timer-index');
    }
}
