<?php

namespace App\Http\Livewire\Admin\Index;

use Livewire\Component;
use App\Models\Instruction;

class IndexDashboard extends Component
{
    public function render()
    {   
        return view('livewire.admin.index.index-dashboard')->extends('layouts.app')
        ->section('content')->layoutData(['title' => 'Dashboard']);
    }
}
