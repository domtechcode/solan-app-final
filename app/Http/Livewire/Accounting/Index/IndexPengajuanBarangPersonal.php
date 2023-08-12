<?php

namespace App\Http\Livewire\Accounting\Index;

use Livewire\Component;

class IndexPengajuanBarangPersonal extends Component
{
    public function render()
    {
        return view('livewire.accounting.index.index-pengajuan-barang-personal')
            ->extends('layouts.app')
            ->layoutData(['title' => 'Pengajuan Barang Personal']);
    }
}
