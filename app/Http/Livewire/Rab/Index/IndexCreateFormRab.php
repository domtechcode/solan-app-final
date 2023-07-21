<?php

namespace App\Http\Livewire\Rab\Index;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\WorkStep;

class IndexCreateFormRab extends Component
{
    public $instructionSelectedId;

    public function mount($instructionId)
    {
        $this->instructionSelectedId = $instructionId;
        $updateUserWorkStep = WorkStep::where('instruction_id', $this->instructionSelectedId)->where('work_step_list_id', 3)->update([
            'user_id' => Auth()->user()->id,
            'dikerjakan' => Carbon::now()->toDateTimeString(),
        ]);

        $updateJobStatus = WorkStep::where('instruction_id', $this->instructionSelectedId)->update([
            'status_id' => 2,
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
