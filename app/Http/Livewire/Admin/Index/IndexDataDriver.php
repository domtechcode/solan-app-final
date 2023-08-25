<?php

namespace App\Http\Livewire\Admin\Index;

use Livewire\Component;

class IndexDataDriver extends Component
{
    public function render()
    {
        return view('livewire.admin.index.index-data-driver')
            ->extends('layouts.app')
            ->layoutData(['title' => 'Data Driver']);
    }
}
