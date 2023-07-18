<?php

namespace App\Http\Livewire\HitungBahan;

use Livewire\Component;

class IndexEditFormHitungBahan extends Component
{
    public $instructionSelectedId;

    public function mount($instructionId)
    {
        $this->instructionSelectedId = $instructionId;
    }
    
    public function render()
    {
        return view('livewire.hitung-bahan.index-edit-form-hitung-bahan', [
            'title' => 'Form Edit Hitung Bahan'
        ])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Form Edit Hitung Bahan']);
    }
}
