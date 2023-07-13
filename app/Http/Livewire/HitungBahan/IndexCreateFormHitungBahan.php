<?php

namespace App\Http\Livewire\HitungBahan;

use Livewire\Component;

class IndexCreateFormHitungBahan extends Component
{
    public function render()
    {
        return view('livewire.hitung-bahan.index-create-form-hitung-bahan', [
            'title' => 'Form Hitung Bahan'
        ])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Form Hitung Bahan']);
    }
}
