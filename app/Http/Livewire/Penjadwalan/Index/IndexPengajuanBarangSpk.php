<?php

namespace App\Http\Livewire\Penjadwalan\Index;

use Livewire\Component;

class IndexPengajuanBarangSpk extends Component
{
    public function render()
    {
        return view('livewire.penjadwalan.index.index-pengajuan-barang-spk')
            ->extends('layouts.app')
            ->layoutData(['title' => 'Pengajuan Barang SPK']);
    }
}
