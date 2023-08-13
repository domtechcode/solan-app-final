<?php

namespace App\Http\Livewire\Operator\Index;

use Livewire\Component;

class IndexPengajuanBarangSpk extends Component
{
    public function render()
    {
        return view('livewire.operator.index.index-pengajuan-barang-spk')
            ->extends('layouts.app')
            ->layoutData(['title' => 'Pengajuan Barang SPK']);
    }
}
