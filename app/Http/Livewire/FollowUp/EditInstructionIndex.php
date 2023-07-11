<?php

namespace App\Http\Livewire\FollowUp;

use Livewire\Component;
use App\Models\Instruction;

class EditInstructionIndex extends Component
{
    public $instructions;

    public function mount($instructionId)
    {
        $this->instructions = Instruction::findorfail($instructionId);
        $this->spk_type = $this->instructions->type_order;
    }
    
    public function render()
    {
        return view('livewire.follow-up.edit-instruction-index', [
            'title' => 'Form Edit Instruksi Kerja'
        ])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Form Edit Instruksi Kerja']);
    }

    public function update()
    {
        dd($this->spk_type);
    }
}
