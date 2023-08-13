<?php

namespace App\Http\Livewire\HitungBahan\Index;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\WorkStep;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;

class IndexDetailDatabaseHitungBahan extends Component
{
    public $instructionSelectedId;
    public $workStepSelectedId;
    public $workStepData;

    public function mount($instructionId, $workStepId)
    {
        $this->instructionSelectedId = $instructionId;
        $this->workStepSelectedId = $workStepId;
        $dataWorkStep = WorkStep::find($this->workStepSelectedId);
        $this->workStepData = WorkStep::find($this->workStepSelectedId);
        $workStepDataCurrent = WorkStep::find($this->workStepSelectedId);
    }

    public function render()
    {
        return view('livewire.hitung-bahan.index.index-detail-database-hitung-bahan', [
            'title' => 'Order SPK'
        ])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Order SPK']);
    }
}
