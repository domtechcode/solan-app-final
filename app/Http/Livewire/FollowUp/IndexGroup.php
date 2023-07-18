<?php

namespace App\Http\Livewire\FollowUp;

use Livewire\Component;

class IndexGroup extends Component
{
    public function render()
    {
        return view('livewire.follow-up.index-group', [
            'title' => 'Form Group'
        ])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Form Group']);
    }
}
