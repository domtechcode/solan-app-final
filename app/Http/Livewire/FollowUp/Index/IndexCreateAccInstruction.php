<?php

namespace App\Http\Livewire\FollowUp\Index;

use Livewire\Component;

class IndexCreateAccInstruction extends Component
{
    public $instructions;

    public function mount($instructionId)
    {
        $this->instructions = $instructionId;
    }

    public function render()
    {
        return view('livewire.follow-up.index.index-create-acc-instruction', [
            'title' => 'Form Edit Instruksi Kerja',
        ])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Form Edit Instruksi Kerja']);
    }
}
