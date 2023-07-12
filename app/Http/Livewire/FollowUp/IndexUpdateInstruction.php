<?php

namespace App\Http\Livewire\FollowUp;

use Livewire\Component;

class IndexUpdateInstruction extends Component
{
    public $instructions;

    public function mount($instructionId)
    {
        $this->instructions = $instructionId;
    }

    public function render()
    {

        return view('livewire.follow-up.index-update-instruction', [
            'title' => 'Form Update Instruksi Kerja'
        ])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Form Update Instruksi Kerja']);
    }
}
