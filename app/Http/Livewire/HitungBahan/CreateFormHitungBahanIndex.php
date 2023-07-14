<?php

namespace App\Http\Livewire\HitungBahan;

use Livewire\Component;

class CreateFormHitungBahanIndex extends Component
{
    public $layoutSettings = [];
    public $keterangans = [];

    public function addFormSetting()
    {
        $this->layoutSettings[] = ['size' => ''];
    }

    public function addFormKeterangan($index)
    {
        $this->keterangans[$index][] = [
            'panjang' => '',
            'lebar' => '',
            'rincianPlate' => [],
        ];
    }

    public function addRincianPlate($index, $keteranganIndex)
    {
        $this->keterangans[$index][$keteranganIndex]['rincianPlate'][] = '';
    }

    public function removeFormSetting($index)
    {
        unset($this->layoutSettings[$index]);
        $this->layoutSettings = array_values($this->layoutSettings);
    }

    public function removeFormKeterangan($parentIndex, $index)
    {
        unset($this->keterangans[$parentIndex][$index]);
        $this->keterangans[$parentIndex] = array_values($this->keterangans[$parentIndex]);
    }

    public function removeRincianPlate($index, $keteranganIndex, $rincianIndex)
    {
        unset($this->keterangans[$index][$keteranganIndex]['rincianPlate'][$rincianIndex]);
        $this->keterangans[$index][$keteranganIndex]['rincianPlate'] = array_values($this->keterangans[$index][$keteranganIndex]['rincianPlate']);
    }
    
    public function mount()
    {
         // Cek apakah array layoutSettings dan keterangans kosong
    if (empty($this->layoutSettings)) {
        $this->layoutSettings[] = ['size' => ''];
    }
    if (empty($this->keterangans)) {
        $this->keterangans[0][] = [
            'panjang' => '',
            'lebar' => '',
            'rincianPlate' => [],
        ];
    }
    }

    public function render()
    {
        return view('livewire.hitung-bahan.create-form-hitung-bahan-index')->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Form Hitung Bahan']);
    }
}
