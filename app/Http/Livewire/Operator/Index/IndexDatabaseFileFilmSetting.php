<?php

namespace App\Http\Livewire\Operator\Index;

use Livewire\Component;

class IndexDatabaseFileFilmSetting extends Component
{
    public function render()
    {
        return view('livewire.operator.index.index-database-file-film-setting')->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Dashboard']);
    }
}
