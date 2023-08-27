<?php

namespace App\Http\Livewire\Operator\Index;

use Livewire\Component;

class IndexDatabaseFileLayoutSetting extends Component
{
    public function render()
    {
        return view('livewire.operator.index.index-database-file-layout-setting')->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Dashboard']);
    }
}
