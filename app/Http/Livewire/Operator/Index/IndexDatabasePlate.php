<?php

namespace App\Http\Livewire\Operator\Index;

use Livewire\Component;

class IndexDatabasePlate extends Component
{
    public function render()
    {
        return view('livewire.operator.index.index-database-plate')->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Dashboard']);
    }
}
