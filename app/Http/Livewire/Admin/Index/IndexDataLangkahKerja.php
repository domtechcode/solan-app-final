<?php

namespace App\Http\Livewire\Admin\Index;

use Livewire\Component;

class IndexDataLangkahKerja extends Component
{
    public function render()
    {
        return view('livewire.admin.index.index-data-langkah-kerja')
            ->extends('layouts.app')
            ->layoutData(['title' => 'Pengajuan Barang Personal']);
    }
}
