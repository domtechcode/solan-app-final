<?php

namespace App\Http\Livewire\Penjadwalan\Index;

use Livewire\Component;

class IndexGroup extends Component
{
    public function render()
    {
        return view('livewire.penjadwalan.index.index-group', [
            'title' => 'Form Group'
        ])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Form Group']);
    }
}
