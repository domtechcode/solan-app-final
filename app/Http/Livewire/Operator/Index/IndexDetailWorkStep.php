<?php

namespace App\Http\Livewire\Operator\Index;

use Livewire\Component;
use App\Models\WorkStep;

class IndexDetailWorkStep extends Component
{
    public $instructionSelectedId;
    public $workStepSelectedId;
    public $workStepData;

    public function mount($instructionId, $workStepId)
    {
        $this->instructionSelectedId = $instructionId;
        $this->workStepSelectedId = $workStepId;
        $this->workStepData = WorkStep::find($this->workStepSelectedId);
    }

    public function render()
    {
        return view('livewire.operator.index.index-detail-work-step')
            ->extends('layouts.app')
            ->layoutData(['title' => 'Detail Data Langkah Kerja']);
    }
}
