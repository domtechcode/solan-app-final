<?php

namespace App\Http\Livewire\FollowUp\Index;

use Livewire\Component;

class IndexPengajuanBarangPersonal extends Component
{
    public function render()
    {
        return view('livewire.follow-up.index.index-pengajuan-barang-personal')
            ->extends('layouts.app')
            ->layoutData(['title' => 'Pengajuan Barang Personal']);
    }
}
