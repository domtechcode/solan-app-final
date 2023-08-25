<?php

namespace App\Http\Livewire\Admin\Index;

use Livewire\Component;

class IndexDataMachine extends Component
{
    public function render()
    {
        return view('livewire.admin.index.index-data-machine')
            ->extends('layouts.app')
            ->layoutData(['title' => 'Pengajuan Barang Personal']);
    }
}
