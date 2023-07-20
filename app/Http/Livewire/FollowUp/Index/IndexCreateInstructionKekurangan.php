<?php

namespace App\Http\Livewire\FollowUp\Index;

use Livewire\Component;

class IndexCreateInstructionKekurangan extends Component
{
    public function render()
    {
        return view('livewire.follow-up.index.index-create-instruction-kekurangan', [
            'title' => 'Form Instruksi Kerja Kekurangan'
        ])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Form Instruksi Kerja Kekurangan']);
    }
}
