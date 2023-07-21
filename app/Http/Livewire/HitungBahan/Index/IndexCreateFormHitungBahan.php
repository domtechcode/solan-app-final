<?php

namespace App\Http\Livewire\HitungBahan\Index;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\WorkStep;

class IndexCreateFormHitungBahan extends Component
{
    public $instructionSelectedId;

    public function mount($instructionId)
    {
        $this->instructionSelectedId = $instructionId;

        $this->instructionSelectedId = $instructionId;
        $updateUserWorkStep = WorkStep::where('instruction_id', $this->instructionSelectedId)->where('work_step_list_id', 5)->update([
            'user_id' => Auth()->user()->id,
            'dikerjakan' => Carbon::now()->toDateTimeString(),
        ]);
    }

    public function render()
    {
        return view('livewire.hitung-bahan.index.index-create-form-hitung-bahan', [
            'title' => 'Form Hitung Bahan'
        ])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Form Hitung Bahan']);
    }
}
