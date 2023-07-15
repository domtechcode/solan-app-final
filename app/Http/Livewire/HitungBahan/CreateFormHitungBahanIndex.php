<?php

namespace App\Http\Livewire\HitungBahan;

use Livewire\Component;
use App\Models\Keterangan;
use App\Models\LayoutSetting;
use Livewire\WithFileUploads;

class CreateFormHitungBahanIndex extends Component
{
    use WithFileUploads;
    public $filerincian = [];
    public $layoutSettings = [];
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

    public function addFormKeterangan($index)
    {
        $this->keterangans[$index][] = [
            'plate' => [],
            'pond' => [],
            'fileRincian' => [],
            'rincianPlate' => [],
            'notes' => '',
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
            $this->keterangans[0][] = [
                'plate' => [],
                'pond' => [],
                'fileRincian' => [],
                'rincianPlate' => [],
                'notes' => '',
            ];
        }
    }

    public function render()
    {
        return view('livewire.hitung-bahan.create-form-hitung-bahan-index')->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Form Hitung Bahan']);
    }
    
    public function save()
    {
        if($this->layoutSettings){
            foreach ($this->layoutSettings as $key => $layoutSettingData) {
                // Buat instance model LayoutSetting
                $layoutSetting = LayoutSetting::create([
                    'form_id' => $key,
                    'panjang_barang_jadi' => $layoutSettingData['panjang_barang_jadi'],
                    'lebar_barang_jadi' => $layoutSettingData['lebar_barang_jadi'],
                    'panjang_bahan_cetak' => $layoutSettingData['panjang_bahan_cetak'],
                    'lebar_bahan_cetak' => $layoutSettingData['lebar_bahan_cetak'],
                    'dataURL' => $layoutSettingData['dataURL'],
                    'dataJSON' => $layoutSettingData['dataJSON'],
                ]);
            }
        }
        
        if($this->keterangans){
            foreach ($this->keterangans as $index => $keteranganData) {
                foreach ($keteranganData as $key => $data) {
                    $keterangan = Keterangan::create([
                        'form_id' => $key,
                        'notes' => $data['notes'],
                    ]);
            
                    foreach ($data['plate'] as $plate) {
                        // Buat instance model Keterangan
                        $keteranganPlate = $keterangan->keteranganPlate()->create([
                            'state_plate' => $plate['state'],
                            'jumlah_plate' => $plate['jumlah_plate'],
                            'ukuran_plate' => $plate['ukuran_plate'],
                        ]);
                    }
            
                    foreach ($data['pond'] as $pond) {
                        // Buat instance model Keterangan
                        $keteranganPisauPond = $keterangan->keteranganPisauPond()->create([
                            'state_pisau' => $pond['state'],
                            'jumlah_pisau' => $pond['jumlah_pisau'],
                        ]);
                    }
            
                    foreach ($data['rincianPlate'] as $rincianPlate) {
                        // Buat instance model Keterangan
                        $rincianPlate = $keterangan->rincianPlate()->create([
                            'state' => $rincianPlate['state'],
                            'plate' => $rincianPlate['plate'],
                            'jumlah_lembar_cetak' => $rincianPlate['jumlah_lembar_cetak'],
                            'waste' => $rincianPlate['waste'],
                        ]);
                    }
                }
            }
        }
        
        

        session()->flash('success', 'Instruksi kerja berhasil disimpan.');
        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Create Instruksi Kerja',
            'message' => 'Berhasil membuat instruksi kerja',
        ]);

        return redirect()->route('hitungBahan.createFormHitungBahan');
    }

    
    








}
