<?php

namespace App\Http\Livewire\Accounting\Index;

use Livewire\Component;
use App\Models\Instruction;

class IndexDashboard extends Component
{
    public function render()
    {   
        return view('livewire.accounting.index.index-dashboard')->extends('layouts.app')
        ->section('content')->layoutData(['title' => 'Dashboard']);
    }
}
