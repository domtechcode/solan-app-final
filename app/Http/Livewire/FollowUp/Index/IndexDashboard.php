<?php

namespace App\Http\Livewire\FollowUp\Index;

use Livewire\Component;
use App\Models\Instruction;
use App\Events\NotificationSent;

class IndexDashboard extends Component
{
    public function render()
    {
        return view('livewire.follow-up.index.index-dashboard')
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }
}
