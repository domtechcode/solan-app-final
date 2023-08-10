<?php

namespace App\Http\Livewire\Rab\Index;

use Carbon\Carbon;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\WorkStep;

class IndexEditFormRab extends Component
{
    public $instructionSelectedId;
    public $workStepSelectedId;
    public $notereject;

    public function mount($instructionId, $workStepId)
    {
        $this->instructionSelectedId = $instructionId;
        $this->workStepSelectedId = $workStepId;
        $updateUserWorkStep = WorkStep::where('instruction_id', $this->instructionSelectedId)->where('work_step_list_id', 3)->first();
        $updateUserWorkStep->update([
            'user_id' => Auth()->user()->id,
            'dikerjakan' => Carbon::now()->toDateTimeString(),
        ]);
        
        $this->notereject = Catatan::where('instruction_id', $instructionId)->where('kategori', 'reject')->where('tujuan', 5)->with('user')->get();
        
    }

    public function render()
    {
        return view('livewire.rab.index.index-edit-form-rab', [
            'title' => 'Edit Form Rab'
        ])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Edit Form Rab']);
    }
}
