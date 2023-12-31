<?php

namespace App\Http\Livewire\Rab\Index;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\WorkStep;

class IndexCreateFormRab extends Component
{
    public $instructionSelectedId;
    public $workStepSelectedId;

    public function mount($instructionId, $workStepId)
    {
        $this->instructionSelectedId = $instructionId;
        $this->workStepSelectedId = $workStepId;
        $updateUserWorkStep = WorkStep::where('instruction_id', $this->instructionSelectedId)->where('work_step_list_id', 3)->update([
            'user_id' => Auth()->user()->id,
            'dikerjakan' => Carbon::now()->toDateTimeString(),
        ]);

        $updateJobStatus = WorkStep::where('instruction_id', $this->instructionSelectedId)->update([
            'status_id' => 2,
            'spk_status' => 'Running',
        ]);
    }

    public function render()
    {
        return view('livewire.rab.index.index-create-form-rab', [
            'title' => 'Form Rab'
        ])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Form Rab']);
    }
}
