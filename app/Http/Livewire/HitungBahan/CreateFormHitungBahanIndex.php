<?php

namespace App\Http\Livewire\HitungBahan;

use Livewire\Component;
use App\Models\Keterangan;
use App\Models\LayoutBahan;
use App\Models\LayoutSetting;
use Livewire\WithFileUploads;

class CreateFormHitungBahanIndex extends Component
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
        return view('livewire.hitung-bahan.create-form-hitung-bahan-index')->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Form Hitung Bahan']);
    }
    
    public function save()
    {
        $this->validate([
            'layoutSettings' => 'required|array|min:1',
            'layoutSettings.*.panjang_barang_jadi' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutSettings.*.lebar_barang_jadi' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutSettings.*.panjang_bahan_cetak' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutSettings.*.lebar_bahan_cetak' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutSettings.*.dataURL' => 'required',
            'layoutSettings.*.dataJSON' => 'required',
    
            'keterangans' => 'required|array|min:1',
            'keterangans.*.notes' => 'required',
            'keterangans.*.plate' => 'required|array|min:1',
            'keterangans.*.plate.*.state_plate' => 'required',
            'keterangans.*.plate.*.jumlah_plate' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'keterangans.*.plate.*.ukuran_plate' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'keterangans.*.pond' => 'required|array|min:1',
            'keterangans.*.pond.*.state_pisau' => 'required',
            'keterangans.*.pond.*.jumlah_pisau' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'keterangans.*.rincianPlate' => 'required|array|min:1',
            'keterangans.*.rincianPlate.*.state' => 'required',
            'keterangans.*.rincianPlate.*.plate' => 'required',
            'keterangans.*.rincianPlate.*.jumlah_lembar_cetak' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'keterangans.*.rincianPlate.*.waste' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
    
            'layoutBahans' => 'required|array|min:1',
            'layoutBahans.*.panjang_barang_jadi' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutBahans.*.lebar_barang_jadi' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutBahans.*.panjang_bahan_cetak' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutBahans.*.lebar_bahan_cetak' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutBahans.*.dataURL' => 'required',
            'layoutBahans.*.dataJSON' => 'required',
        ], [
            'layoutSettings.required' => 'Setidaknya satu layout setting harus diisi.',
            'layoutSettings.min' => 'Setidaknya satu layout setting harus diisi.',
            'layoutSettings.*.panjang_barang_jadi.required' => 'Panjang barang jadi harus diisi.',
            'layoutSettings.*.lebar_barang_jadi.required' => 'Lebar barang jadi harus diisi.',
            'layoutSettings.*.panjang_bahan_cetak.required' => 'Panjang bahan cetak harus diisi.',
            'layoutSettings.*.lebar_bahan_cetak.required' => 'Lebar bahan cetak harus diisi.',
            'layoutSettings.*.panjang_barang_jadi.numeric' => 'Panjang barang jadi harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutSettings.*.lebar_barang_jadi.numeric' => 'Lebar barang jadi harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutSettings.*.panjang_bahan_cetak.numeric' => 'Panjang bahan cetak harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutSettings.*.lebar_bahan_cetak.numeric' => 'Lebar bahan cetak harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutSettings.*.dataURL.required' => 'Gambar harus dibuat terlebih dahulu.',
            'layoutSettings.*.dataJSON.required' => 'Gambar harus dibuat terlebih dahulu.',
    
            'keterangans.*.notes.required' => 'Notes harus diisi pada keterangan.',
            'keterangans.*.plate.required' => 'Setidaknya satu data plate harus diisi pada keterangan.',
            'keterangans.*.plate.min' => 'Setidaknya satu data plate harus diisi pada keterangan.',
            'keterangans.*.plate.*.state_plate.required' => 'State pada data plate harus diisi pada keterangan.',
            'keterangans.*.plate.*.jumlah_plate.required' => 'Jumlah plate harus diisi pada keterangan.',
            'keterangans.*.plate.*.jumlah_plate.numeric' => 'Jumlah plate harus berupa angka/tidak boleh ada tanda koma(,).',
            'keterangans.*.plate.*.ukuran_plate.required' => 'Ukuran plate harus diisi pada keterangan.',
            'keterangans.*.pond.required' => 'Setidaknya satu data pond harus diisi pada keterangan.',
            'keterangans.*.pond.min' => 'Setidaknya satu data pond harus diisi pada keterangan.',
            'keterangans.*.pond.*.state_pisau.required' => 'State pada data pond harus diisi pada keterangan.',
            'keterangans.*.pond.*.jumlah_pisau.required' => 'Jumlah pisau harus diisi pada keterangan.',
            'keterangans.*.pond.*.jumlah_pisau.numeric' => 'Jumlah pisau harus berupa angka/tidak boleh ada tanda koma(,).',
            'keterangans.*.rincianPlate.required' => 'Setidaknya satu data rincian plate harus diisi pada keterangan.',
            'keterangans.*.rincianPlate.min' => 'Setidaknya satu data rincian plate harus diisi pada keterangan.',
            'keterangans.*.rincianPlate.*.state.required' => 'State pada rincian plate harus diisi pada keterangan.',
            'keterangans.*.rincianPlate.*.plate.required' => 'Plate harus diisi pada keterangan.',
            'keterangans.*.rincianPlate.*.jumlah_lembar_cetak.required' => 'Jumlah lembar cetak harus diisi pada keterangan.',
            'keterangans.*.rincianPlate.*.jumlah_lembar_cetak.numeric' => 'Jumlah lembar cetak harus berupa angka/tidak boleh ada tanda koma(,).',
            'keterangans.*.rincianPlate.*.waste.required' => 'Waste harus diisi pada keterangan.',
            'keterangans.*.rincianPlate.*.waste.numeric' => 'Waste harus berupa angka/tidak boleh ada tanda koma(,).',
    
            'layoutBahans.required' => 'Setidaknya satu layout setting harus diisi.',
            'layoutBahans.min' => 'Setidaknya satu layout setting harus diisi.',
            'layoutBahans.*.panjang_barang_jadi.required' => 'Panjang barang jadi harus diisi.',
            'layoutBahans.*.lebar_barang_jadi.required' => 'Lebar barang jadi harus diisi.',
            'layoutBahans.*.panjang_bahan_cetak.required' => 'Panjang bahan cetak harus diisi.',
            'layoutBahans.*.lebar_bahan_cetak.required' => 'Lebar bahan cetak harus diisi.',
            'layoutBahans.*.panjang_barang_jadi.numeric' => 'Panjang barang jadi harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutBahans.*.lebar_barang_jadi.numeric' => 'Lebar barang jadi harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutBahans.*.panjang_bahan_cetak.numeric' => 'Panjang bahan cetak harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutBahans.*.lebar_bahan_cetak.numeric' => 'Lebar bahan cetak harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutBahans.*.dataURL.required' => 'Gambar harus dibuat terlebih dahulu.',
            'layoutBahans.*.dataJSON.required' => 'Gambar harus dibuat terlebih dahulu.',
        ]);

        if ($this->layoutSettings) {
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

        if ($this->keterangans) {
            foreach ($this->keterangans as $index => $keteranganData) {
                    $keterangan = Keterangan::create([
                        'form_id' => $key,
                        'notes' => $keteranganData['notes'],
                    ]);

                    foreach ($keteranganData['plate'] as $plate) {
                        // Buat instance model KeteranganPlate
                        $keteranganPlate = $keterangan->keteranganPlate()->create([
                            'state_plate' => $plate['state_plate'],
                            'jumlah_plate' => $plate['jumlah_plate'],
                            'ukuran_plate' => $plate['ukuran_plate'],
                        ]);
                    }

                    foreach ($keteranganData['pond'] as $pond) {
                        // Buat instance model KeteranganPisauPond
                        $keteranganPisauPond = $keterangan->keteranganPisauPond()->create([
                            'state_pisau' => $pond['state_pisau'],
                            'jumlah_pisau' => $pond['jumlah_pisau'],
                        ]);
                    }

                    foreach ($keteranganData['rincianPlate'] as $rincianPlate) {
                        // Buat instance model RincianPlate
                        $rincianPlate = $keterangan->rincianPlate()->create([
                            'state' => $rincianPlate['state'],
                            'plate' => $rincianPlate['plate'],
                            'jumlah_lembar_cetak' => $rincianPlate['jumlah_lembar_cetak'],
                            'waste' => $rincianPlate['waste'],
                        ]);
                    }
            }
        }

        if ($this->layoutBahans) {
            foreach ($this->layoutBahans as $key => $layoutBahanData) {
                // Buat instance model layoutBahan
                $layoutBahan = LayoutBahan::create([
                    'form_id' => $key,
                    'panjang_barang_jadi' => $layoutBahanData['panjang_barang_jadi'],
                    'lebar_barang_jadi' => $layoutBahanData['lebar_barang_jadi'],
                    'panjang_bahan_cetak' => $layoutBahanData['panjang_bahan_cetak'],
                    'lebar_bahan_cetak' => $layoutBahanData['lebar_bahan_cetak'],
                    'dataURL' => $layoutBahanData['dataURL'],
                    'dataJSON' => $layoutBahanData['dataJSON'],
                ]);
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
