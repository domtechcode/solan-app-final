<?php

namespace App\Http\Livewire\FollowUp\Index;

use Livewire\Component;

class IndexCreatePengajuanKekuranganQc extends Component
{
    public $instructions;

    public function mount($instructionId)
    {
        $this->instructions = $instructionId;
    }

    public function render()
    {
        return view('livewire.follow-up.index.index-create-pengajuan-kekurangan-qc', [
            'title' => 'Form Instruksi Kerja Kekurangan',
        ])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Form Instruksi Kerja Kekurangan']);
    }
}
