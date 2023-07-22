<?php

namespace App\Http\Livewire\Operator\Index;

use Livewire\Component;

class IndexWorkStep extends Component
{
    public function render()
    {
        return view('livewire.operator.index.index-work-step', [
            'title' => 'Order SPK'
        ])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Order SPK']);
    }
}
