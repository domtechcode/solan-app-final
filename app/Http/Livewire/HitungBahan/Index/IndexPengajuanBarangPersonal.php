<?php

namespace App\Http\Livewire\HitungBahan\Index;

use Livewire\Component;

class IndexPengajuanBarangPersonal extends Component
{
    public function render()
    {
        return view('livewire.hitung-bahan.index.index-pengajuan-barang-personal')
            ->extends('layouts.app')
            ->layoutData(['title' => 'Pengajuan Barang Personal']);
    }
}
