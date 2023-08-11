<?php

namespace App\Http\Livewire\HitungBahan\Index;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\WorkStep;
use App\Events\IndexRenderEvent;

class IndexEditFormHitungBahan extends Component
{
    public $instructionSelectedId;

    public function mount($instructionId)
    {
        $this->instructionSelectedId = $instructionId;
        $updateUserWorkStep = WorkStep::where('instruction_id', $this->instructionSelectedId)
            ->where('work_step_list_id', 5)
            ->first();

        if ($updateUserWorkStep->status_task == 'Reject') {
            $updateUserWorkStep->update([
                'user_id' => Auth()->user()->id,
                'dikerjakan' => Carbon::now()->toDateTimeString(),
                'state_task' => 'Running',
                'status_task' => 'Process',
            ]);
        } else {
            $updateUserWorkStep->update([
                'user_id' => Auth()->user()->id,
                'dikerjakan' => Carbon::now()->toDateTimeString(),
                'state_task' => 'Running',
                'status_task' => 'Reject Requirements',
            ]);
        }
        

        if ($updateUserWorkStep->status_id == 1) {
            $updateJobStatus = WorkStep::where('instruction_id', $this->instructionSelectedId)->update([
                'status_id' => 2,
            ]);
        }

        broadcast(new IndexRenderEvent('refresh'));
    }

    public function render()
    {
        return view('livewire.hitung-bahan.index.index-edit-form-hitung-bahan', [
            'title' => 'Form Edit Hitung Bahan',
        ])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Form Edit Hitung Bahan']);
    }
}
