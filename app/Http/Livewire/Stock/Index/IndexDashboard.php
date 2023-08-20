<?php

namespace App\Http\Livewire\Stock\Index;

use Livewire\Component;

class IndexDashboard extends Component
{
    public function render()
    {
        return view('livewire.stock.index.index-dashboard')->extends('layouts.app')
        ->section('content')->layoutData(['title' => 'Dashboard']);
    }
}
