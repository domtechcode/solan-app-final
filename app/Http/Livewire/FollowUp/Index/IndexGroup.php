<?php

namespace App\Http\Livewire\FollowUp\Index;

use Livewire\Component;

class IndexGroup extends Component
{
    public function render()
    {
        return view('livewire.follow-up.index.index-group', [
            'title' => 'Form Group',
        ])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Form Group']);
    }
}
