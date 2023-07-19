<?php

namespace App\Http\Livewire\FollowUp\Index;

use Livewire\Component;

class IndexEditInstruction extends Component
{
    public $instructions;

    public function mount($instructionId)
    {
        $this->instructions = $instructionId;
    }

    public function render()
    {

        return view('livewire.follow-up.index.index-edit-instruction', [
            'title' => 'Form Edit Instruksi Kerja'
        ])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Form Edit Instruksi Kerja']);
    }
}
