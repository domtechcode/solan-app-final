<?php

namespace App\Http\Livewire\HitungBahan;

use Livewire\Component;
use App\Models\Keterangan;
use App\Models\LayoutBahan;
use Illuminate\Support\Arr;
use App\Models\LayoutSetting;
use Livewire\WithFileUploads;

class EditFormHitungBahanIndex extends Component
{
    use WithFileUploads;
    public $filerincian = [];
    public $layoutSettings = [];
    public $layoutBahans = [];
    public $keterangans = [];
    // public $instruction_id = 1;

    public function addFormSetting()
    {
        $this->layoutSettings[] = [
            'panjang_barang_jadi' => '',
            'lebar_barang_jadi' => '',
            'panjang_bahan_cetak' => '',
            'lebar_bahan_cetak' => '',
            'dataURL' => '',
            'dataJSON' => '',
        ];
    }

    public function removeFormSetting($indexSetting)
    {
        unset($this->layoutSettings[$indexSetting]);
        $this->layoutSettings = array_values($this->layoutSettings);
    }

    public function addFormBahan()
    {
        $this->layoutBahans[] = [
            'panjang_barang_jadi' => '',
            'lebar_barang_jadi' => '',
            'panjang_bahan_cetak' => '',
            'lebar_bahan_cetak' => '',
            'dataURL' => '',
            'dataJSON' => '',
        ];
    }

    public function removeFormBahan($indexBahan)
    {
        unset($this->layoutBahans[$indexBahan]);
        $this->layoutBahans = array_values($this->layoutBahans);
    }

    public function addFormKeterangan()
    {
        $this->keterangans[] = [
            'plate' => [],
            'pond' => [],
            'fileRincian' => [],
            'rincianPlate' => [],
            'notes' => '',
        ];
    }

    public function removeFormKeterangan($keteranganIndex)
    {
        unset($this->keterangans[$keteranganIndex]);
        $this->keterangans = array_values($this->keterangans);
    }


    public function addRincianPlate($keteranganIndex)
    {
        $this->keterangans[$keteranganIndex]['rincianPlate'][] = '';
    }

    public function removeRincianPlate($index, $keteranganIndex, $rincianIndex)
    {
        unset($this->keterangans[$keteranganIndex]['rincianPlate'][$rincianIndex]);
        $this->keterangans[$keteranganIndex]['rincianPlate'] = array_values($this->keterangans[$keteranganIndex]['rincianPlate']);
    }
    
    public function mount()
    {
        $layoutSettingData = LayoutSetting::all();
        foreach($layoutSettingData as $dataLayoutSetting){
            $this->layoutSettings[] = [
                'panjang_barang_jadi' => $dataLayoutSetting['panjang_barang_jadi'],
                'lebar_barang_jadi' => $dataLayoutSetting['lebar_barang_jadi'],
                'panjang_bahan_cetak' => $dataLayoutSetting['panjang_bahan_cetak'],
                'lebar_bahan_cetak' => $dataLayoutSetting['lebar_bahan_cetak'],
                'dataURL' => $dataLayoutSetting['dataURL'],
                'dataJSON' => $dataLayoutSetting['dataJSON'],
            ];
        }

        $keteranganData = Keterangan::with('keteranganPlate', 'keteranganPisauPond', 'rincianPlate')->get();
        foreach($keteranganData as $dataKeterangan){
            $keterangan = [
                'fileRincian' => [],
                'notes' => $dataKeterangan['notes'],
            ];

            foreach($dataKeterangan['keteranganPlate'] as $dataPlate){
                $keterangan['plate'][] = [
                    "state_plate" => $dataPlate['state_plate'],
                    "jumlah_plate" => $dataPlate['jumlah_plate'],
                    "ukuran_plate" => $dataPlate['ukuran_plate']
                ];
            }

            foreach($dataKeterangan['keteranganPisauPond'] as $dataPisau){
                $keterangan['pond'][] = [
                    "state_pisau" => $dataPisau['state_pisau'],
                    "jumlah_pisau" => $dataPisau['jumlah_pisau'],
                ];
            }

            foreach($dataKeterangan['rincianPlate'] as $dataRincianPlate){
                $keterangan['rincianPlate'][] = [
                    "state" => $dataRincianPlate['state'],
                    "plate" => $dataRincianPlate['plate'],
                    "jumlah_lembar_cetak" => $dataRincianPlate['jumlah_lembar_cetak'],
                    "waste" => $dataRincianPlate['waste'],
                ];
            }
            
            $this->keterangans[] = $keterangan;
        }
        
        $layoutBahanData = LayoutBahan::all();
        foreach($layoutBahanData as $dataLayoutBahan){
            $this->layoutBahans[] = [
                'panjang_barang_jadi' => $dataLayoutBahan['panjang_barang_jadi'],
                'lebar_barang_jadi' => $dataLayoutBahan['lebar_barang_jadi'],
                'panjang_bahan_cetak' => $dataLayoutBahan['panjang_bahan_cetak'],
                'lebar_bahan_cetak' => $dataLayoutBahan['lebar_bahan_cetak'],
                'dataURL' => $dataLayoutBahan['dataURL'],
                'dataJSON' => $dataLayoutBahan['dataJSON'],
            ];
        }

        if (empty($this->layoutSettings)) {
            $this->layoutSettings[] = [
                'panjang_barang_jadi' => '',
                'lebar_barang_jadi' => '',
                'panjang_bahan_cetak' => '',
                'lebar_bahan_cetak' => '',
                'dataURL' => '',
                'dataJSON' => '',
            ];
        }
        if (empty($this->keterangans)) {
            $this->keterangans[] = [
                'plate' => [],
                'pond' => [],
                'fileRincian' => [],
                'rincianPlate' => [],
                'notes' => '',
            ];
        }
        if (empty($this->layoutBahans)) {
            $this->layoutBahans[] = [
                'panjang_barang_jadi' => '',
                'lebar_barang_jadi' => '',
                'panjang_bahan_cetak' => '',
                'lebar_bahan_cetak' => '',
                'dataURL' => '',
                'dataJSON' => '',
            ];
        }
        
        
    }

    public function render()
    {
        return view('livewire.hitung-bahan.edit-form-hitung-bahan-index')->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Form Edit Hitung Bahan']);
    }
    
    public function update()
    {
        // dd($this->keterangans);
        return redirect()->route('hitungBahan.editFormHitungBahan');
    }


}
