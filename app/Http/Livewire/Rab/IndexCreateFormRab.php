<?php

namespace App\Http\Livewire\Rab;

use Livewire\Component;

class IndexCreateFormRab extends Component
{
    public $instructionSelectedId;

    public function mount($instructionId)
    {
        $this->instructionSelectedId = $instructionId;
    }

    public function render()
    {
        return view('livewire.rab.index-create-form-rab', [
            'title' => 'Form Rab'
        ])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Form Rab']);
    }
}
