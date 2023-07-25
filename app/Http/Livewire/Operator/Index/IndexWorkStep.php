<?php

namespace App\Http\Livewire\Operator\Index;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\WorkStep;

class IndexWorkStep extends Component
{
    public $instructionSelectedId;
    public $workStepSelectedId;
    public $workStepData;

    public function mount($instructionId, $workStepId)
    {
        $this->instructionSelectedId = $instructionId;
        $this->workStepSelectedId = $workStepId;
        $updateUserWorkStep = WorkStep::where('id', $this->workStepSelectedId)->update([
            'dikerjakan' => Carbon::now()->toDateTimeString(),
        ]);

        $updateJobStatus = WorkStep::where('instruction_id', $this->instructionSelectedId)->update([
            'status_id' => 2,
        ]);

        $this->workStepData = WorkStep::find($this->workStepSelectedId);
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
