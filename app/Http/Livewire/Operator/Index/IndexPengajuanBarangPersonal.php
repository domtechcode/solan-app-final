<?php

namespace App\Http\Livewire\Operator\Index;

use Livewire\Component;

class IndexPengajuanBarangPersonal extends Component
{
    public function render()
    {
        return view('livewire.operator.index.index-pengajuan-barang-personal')
            ->extends('layouts.app')
            ->layoutData(['title' => 'Pengajuan Barang Personal']);
    }
}
