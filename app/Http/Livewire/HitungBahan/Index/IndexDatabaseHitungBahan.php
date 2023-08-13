<?php

namespace App\Http\Livewire\HitungBahan\Index;

use Livewire\Component;

class IndexDatabaseHitungBahan extends Component
{
    public function render()
    {
        return view('livewire.hitung-bahan.index.index-database-hitung-bahan')->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Dashboard']);
    }
}
