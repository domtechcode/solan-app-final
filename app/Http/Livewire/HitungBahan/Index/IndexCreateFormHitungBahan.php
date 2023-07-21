<?php

namespace App\Http\Livewire\HitungBahan\Index;

use Livewire\Component;

class IndexCreateFormHitungBahan extends Component
{
    public $instructionSelectedId;

    public function mount($instructionId)
    {
        $this->instructionSelectedId = $instructionId;
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
