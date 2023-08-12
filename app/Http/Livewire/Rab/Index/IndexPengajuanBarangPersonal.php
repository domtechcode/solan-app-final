<?php

namespace App\Http\Livewire\Rab\Index;

use Livewire\Component;

class IndexPengajuanBarangPersonal extends Component
{
    public function render()
    {
        return view('livewire.rab.index.index-pengajuan-barang-personal')
            ->extends('layouts.app')
            ->layoutData(['title' => 'Pengajuan Barang Personal']);
    }
}
