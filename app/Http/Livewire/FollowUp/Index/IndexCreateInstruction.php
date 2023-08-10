<?php

namespace App\Http\Livewire\FollowUp\Index;

use Livewire\Component;

class IndexCreateInstruction extends Component
{
    public function render()
    {
        return view('livewire.follow-up.index.index-create-instruction', [
            'title' => 'Form Instruksi Kerja',
        ])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Form Instruksi Kerja']);
    }
}
