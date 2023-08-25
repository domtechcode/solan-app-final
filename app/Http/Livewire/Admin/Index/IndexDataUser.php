<?php

namespace App\Http\Livewire\Admin\Index;

use Livewire\Component;

class IndexDataUser extends Component
{
    public function render()
    {
        return view('livewire.admin.index.index-data-user')
            ->extends('layouts.app')
            ->layoutData(['title' => 'Pengajuan Barang Personal']);
    }
}
