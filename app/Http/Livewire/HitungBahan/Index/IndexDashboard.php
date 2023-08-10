<?php

namespace App\Http\Livewire\HitungBahan\Index;

use Livewire\Component;
use App\Models\Instruction;

class IndexDashboard extends Component
{
    public function render()
    {
        return view('livewire.hitung-bahan.index.index-dashboard')
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }
}
