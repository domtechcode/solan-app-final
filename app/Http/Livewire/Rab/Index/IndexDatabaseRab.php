<?php

namespace App\Http\Livewire\Rab\Index;

use Livewire\Component;

class IndexDatabaseRab extends Component
{
    public function render()
    {
        return view('livewire.rab.index.index-database-rab')->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Database Rab']);
    }
}
