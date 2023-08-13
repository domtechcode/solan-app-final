<?php

namespace App\Http\Livewire\HitungBahan\Index;

use Livewire\Component;

class IndexPengajuanBarangSpk extends Component
{
    public function render()
    {
        return view('livewire.hitung-bahan.index.index-pengajuan-barang-spk')
            ->extends('layouts.app')
            ->layoutData(['title' => 'Pengajuan Barang SPK']);
    }
}
