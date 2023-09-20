<?php

namespace App\Http\Livewire\FollowUp\Index;

use Livewire\Component;

class IndexUpdateQtyInstruction extends Component
{
    public $instructions;

    public function mount($instructionId)
    {
        $this->instructions = $instructionId;
    }

    public function render()
    {
        return view('livewire.follow-up.index.index-update-qty-instruction', [
            'title' => 'Form Update QTY Instruksi Kerja',
        ])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Form Update QTY Instruksi Kerja']);
    }
}
