<?php

namespace App\Http\Livewire\HitungBahan\Component;

use App\Models\Files;
use App\Models\Catatan;
use App\Models\Machine;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;

class CreateAutomaticFormHitungBahanIndex extends Component
{
    public $currentInstructionId;
    public $instructionData;
    public $contohData;
    public $notereject;
    public $note;
    public $machineData;

    public $layoutSettingType;
    public $layoutBahanType;
    public $mesin;
    public $panjangAreaCetakMinimal = 18;
    public $lebarAreaCetakMinimal = 11.6;
    public $panjangAreaCetakMaximal = 50.5;
    public $lebarAreaCetakMaximal = 34.5;
    public $panjangMaximalBahan = 51.5;
    public $lebarMaximalBahan = 36.2;

    //detail
    public $panjangBarangJadi = 18.1;
    public $lebarBarangJadi = 5;

    public $qtyPermintaan = '1000';
    public $pond = 'Y';
    public $potongJadi = 'N';
    public $jarakPotongJadi = 'N';
    public $jarakPanjangAntarBarang = 0.4;
    public $jarakLebarAntarBarang = 0.4;
    public $jarakAtas = 1;
    public $jarakBawah = 0.5;
    public $jarakSisiKiri = 0.5;
    public $jarakSisiKanan = 0.5;
    public $jarakTambahanVertical = 0;
    public $jarakTambahanHorizontal = 0;
    public $panjangBahan = 109;
    public $lebarBahan = 79;

    //hasil landscape
    public $panjangNaikLandscape;
    public $lebarNaikLandscape;

    public $ukuranPanjangLembarCetakLandscape;
    public $ukuranLebarLembarCetakLandscape;

    //hasil bahan landscape
    public $panjangSisaBahanLandscape;
    public $panjangNaikBahanLandscape;

    public $lebarSisaBahanLandscape;
    public $lebarNaikBahanLandscape;

    public $panjangNaikSisaBahanPanjangLandscape;
    public $lebarNaikSisaBahanPanjangLandscape;

    public function mount($instructionId)
    {
        $this->currentInstructionId = $instructionId;
        $cekGroup = Instruction::where('id', $instructionId)
            ->whereNotNull('group_id')
            ->whereNotNull('group_priority')
            ->first();

        if (!$cekGroup) {
            $this->instructionData = Instruction::where('id', $instructionId)
                ->orderBy('spk_number', 'asc')
                ->get();
            $qtyPermintaanTotal = 0;
            foreach ($this->instructionData as $data) {
                $qtyPermintaanTotal += $data->quantity - $data->stock;
            }

            $this->qtyPermintaan = $qtyPermintaanTotal;
        } else {
            $instructionGroup = Instruction::where('group_id', $cekGroup->group_id)
                ->orderBy('spk_number', 'asc')
                ->get();
            $this->instructionData = Instruction::whereIn('id', $instructionGroup->pluck('id'))
                ->orderBy('spk_number', 'asc')
                ->get();

            $qtyPermintaanTotal = 0;
            foreach ($this->instructionData as $data) {
                $qtyPermintaanTotal += $data->quantity - $data->stock;
            }

            $this->qtyPermintaan = $qtyPermintaanTotal;
        }

        $this->contohData = Files::where('instruction_id', $instructionId)
            ->where('type_file', 'contoh')
            ->get();

        $this->stateWorkStepPlate = WorkStep::where('instruction_id', $instructionId)
            ->where('work_step_list_id', 7)
            ->first();
        $this->stateWorkStepSablon = WorkStep::where('instruction_id', $instructionId)
            ->where('work_step_list_id', 23)
            ->first();
        $this->stateWorkStepPond = WorkStep::where('instruction_id', $instructionId)
            ->where('work_step_list_id', 24)
            ->first();
        $this->stateWorkStepCetakLabel = WorkStep::where('instruction_id', $instructionId)
            ->where('work_step_list_id', 12)
            ->first();
        $this->workSteps = WorkStep::where('instruction_id', $instructionId)
            ->with('workStepList')
            ->get();

        $this->note = Catatan::where('instruction_id', $instructionId)
            ->where('kategori', 'catatan')
            ->where('tujuan', 5)
            ->get();
        $this->notereject = Catatan::where('instruction_id', $instructionId)
            ->where('kategori', 'reject')
            ->where('tujuan', 5)
            ->get();

        $this->machineData = Machine::where('type', 'Mesin Cetak')->get();
    }

    public function render()
    {
        return view('livewire.hitung-bahan.component.create-automatic-form-hitung-bahan-index')
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Form Hitung Bahan']);
    }

    public function generate()
    {
        // $this->validate([
        //     'panjangBarangJadi' => 'required',
        //     'lebarBarangJadi' => 'required',
        //     'qtyPermintaan' => 'required',
        //     'mesin' => 'required',
        //     'pond' => 'required',
        //     'potongJadi' => 'required',
        //     'jarakPotongJadi' => 'required',
        //     'layoutSettingType' => 'required',
        //     'layoutBahanType' => 'required',
        // ]);

        // //hitungJarakAntarBarang
        if ($this->pond == 'Y' && $this->potongJadi == 'N' && $this->jarakPotongJadi == 'N') {
            $this->jarakPanjangAntarBarang = 0.4;
            $this->jarakLebarAntarBarang = 0.4;
        } elseif ($this->pond == 'Y' && $this->potongJadi == 'Y' && $this->jarakPotongJadi == 'N') {
            $this->jarakPanjangAntarBarang = 0.2;
            $this->jarakLebarAntarBarang = 0.2;
        } elseif ($this->pond == 'Y' && $this->potongJadi == 'Y' && $this->jarakPotongJadi == 'Y') {
            $this->jarakPanjangAntarBarang = 0.2;
            $this->jarakLebarAntarBarang = 0.2;
        } elseif ($this->pond == 'N' && $this->potongJadi == 'Y' && $this->jarakPotongJadi == 'Y') {
            $this->jarakPanjangAntarBarang = 0.2;
            $this->jarakLebarAntarBarang = 0.2;
        } elseif ($this->pond == 'N' && $this->potongJadi == 'Y' && $this->jarakPotongJadi == 'N') {
            $this->jarakPanjangAntarBarang = 0;
            $this->jarakLebarAntarBarang = 0;
        } else {
            $this->jarakPanjangAntarBarang = 0;
            $this->jarakLebarAntarBarang = 0;
        }

        //Menentukan Panjang Naik Landscape
        $resultsPanjangNaikLandscape = []; // Membuat array untuk menyimpan hasil formula

        $panjangBarangJadi = $this->panjangBarangJadi;
        $jarakSisiKiri = $this->jarakSisiKiri;
        $jarakSisiKanan = $this->jarakSisiKanan;

        $incrementPanjangNaikLandscape = 1; // Mulai dari increment 1
        while (true) {
            $jarakPanjangAntarBarang = $this->jarakPanjangAntarBarang; // Hitung jarak antar barang
            $totalPanjangLembarCetakLandscape = $panjangBarangJadi * $incrementPanjangNaikLandscape + ($jarakPanjangAntarBarang * ($incrementPanjangNaikLandscape - 1) + $jarakSisiKiri + $jarakSisiKanan);

            if ($totalPanjangLembarCetakLandscape >= $this->panjangAreaCetakMaximal) {
                break; // Menghentikan perulangan jika totalPanjangLembarCetakLandscape mendekati panjangAreaCetakMaximal
            }

            if ($totalPanjangLembarCetakLandscape >= $this->panjangAreaCetakMinimal && $totalPanjangLembarCetakLandscape <= $this->panjangAreaCetakMaximal) {
                $resultsPanjangNaikLandscape[] = [
                    'ukuran_panjang_lembar_cetak' => $totalPanjangLembarCetakLandscape,
                    'panjang_naik' => $incrementPanjangNaikLandscape,
                ];
            }

            $incrementPanjangNaikLandscape++; // Menambahkan increment
        }

        $maxUkuranPanjangLembarCetakLandscape = 0; // Variabel untuk menyimpan nilai terbesar
        $panjangNaikLandscape = 0; // Variabel untuk menyimpan panjang_naik yang sesuai

        foreach ($resultsPanjangNaikLandscape as $item) {
            $ukuranPanjangLembarCetak = $item['ukuran_panjang_lembar_cetak'];

            if ($ukuranPanjangLembarCetak > $maxUkuranPanjangLembarCetakLandscape) {
                $maxUkuranPanjangLembarCetakLandscape = $ukuranPanjangLembarCetak;
                $panjangNaikLandscape = $item['panjang_naik'];
            }
        }

        $this->ukuranPanjangLembarCetakLandscape = $maxUkuranPanjangLembarCetakLandscape;
        $this->panjangNaikLandscape = $panjangNaikLandscape;
        //selesai Menentukan Panjang Naik Landscape

        //Menentukan Lebar Naik Landscape
        $resultsLebarNaikLandscape = []; // Membuat array untuk menyimpan hasil formula

        $lebarBarangJadi = $this->lebarBarangJadi;
        $jarakAtas = $this->jarakAtas;
        $jarakBawah = $this->jarakBawah;

        $incrementLebarNaikLandscape = 1; // Mulai dari increment 1
        while (true) {
            $jarakLebarAntarBarang = $this->jarakLebarAntarBarang; // Hitung jarak antar barang
            $totalLebarLembarCetakLandscape = $lebarBarangJadi * $incrementLebarNaikLandscape + ($jarakLebarAntarBarang * ($incrementLebarNaikLandscape - 1) + $jarakAtas + $jarakBawah);

            if ($totalLebarLembarCetakLandscape >= $this->lebarAreaCetakMaximal) {
                break; // Menghentikan perulangan jika totalPanjangLembarCetakLandscape mendekati panjangAreaCetakMaximal
            }

            if ($totalLebarLembarCetakLandscape >= $this->lebarAreaCetakMinimal && $totalLebarLembarCetakLandscape <= $this->lebarAreaCetakMaximal) {
                $resultsLebarNaikLandscape[] = [
                    'ukuran_lebar_lembar_cetak' => $totalLebarLembarCetakLandscape,
                    'lebar_naik' => $incrementLebarNaikLandscape,
                ];
            }

            $incrementLebarNaikLandscape++; // Menambahkan increment
        }

        $maxUkuranLebarLembarCetakLandscape = 0; // Variabel untuk menyimpan nilai terbesar
        $lebarNaikLandscape = 0; // Variabel untuk menyimpan panjang_naik yang sesuai

        foreach ($resultsLebarNaikLandscape as $item) {
            $ukuranLebarLembarCetak = $item['ukuran_lebar_lembar_cetak'];

            if ($ukuranLebarLembarCetak > $maxUkuranLebarLembarCetakLandscape) {
                $maxUkuranLebarLembarCetakLandscape = $ukuranLebarLembarCetak;
                $lebarNaikLandscape = $item['lebar_naik'];
            }
        }

        $this->ukuranLebarLembarCetakLandscape = $maxUkuranLebarLembarCetakLandscape;
        $this->lebarNaikLandscape = $lebarNaikLandscape;
        //selesai Menentukan Lebar Naik Landscape

        //Menentukan Panjang Naik Landscape Bahan
        $resultsPanjangNaikLandscapeBahan = []; // Membuat array untuk menyimpan hasil formula

        $panjangBahan = $this->panjangBahan;
        $ukuranPanjangLembarCetakLandscape = $this->ukuranPanjangLembarCetakLandscape;

        $incrementPanjangNaikLandscapeBahan = 1; // Mulai dari increment 1
        while (true) {
            $totalNaikPanjangLembarCetakLandscape = $panjangBahan - $ukuranPanjangLembarCetakLandscape * $incrementPanjangNaikLandscapeBahan;

            if ($totalNaikPanjangLembarCetakLandscape < 0) {
                break; // Menghentikan perulangan jika $totalNaikPanjangLembarCetakLandscape menjadi negatif
            }

            if ($totalNaikPanjangLembarCetakLandscape >= 0) {
                $resultsPanjangNaikLandscapeBahan[] = [
                    'panjang_sisa_bahan' => $totalNaikPanjangLembarCetakLandscape,
                    'panjang_naik_bahan' => $incrementPanjangNaikLandscapeBahan,
                ];
            }

            $incrementPanjangNaikLandscapeBahan++; // Menambahkan increment
        }

        $panjangSisaBahanLandscape = null;
        $panjangNaikBahanLandscape = null;

        foreach ($resultsPanjangNaikLandscapeBahan as $data) {
            if ($panjangSisaBahanLandscape === null || $data['panjang_sisa_bahan'] < $panjangSisaBahanLandscape) {
                $panjangSisaBahanLandscape = $data['panjang_sisa_bahan'];
                $panjangNaikBahanLandscape = $data['panjang_naik_bahan'];
            }
        }


        $this->panjangNaikBahanLandscape = $panjangNaikBahanLandscape;
        //selesai Menentukan Panjang Naik Landscape Bahan

        //Menentukan Panjang Naik Landscape Bahan
        $resultsLebarNaikLandscapeBahan = []; // Membuat array untuk menyimpan hasil formula

        $lebarBahan = $this->lebarBahan;
        $ukuranLebarLembarCetakLandscape = $this->ukuranLebarLembarCetakLandscape;

        $incrementLebarNaikLandscapeBahan = 1; // Mulai dari increment 1
        while (true) {
            $totalNaikLebarLembarCetakLandscape = $lebarBahan - ($ukuranLebarLembarCetakLandscape * $incrementLebarNaikLandscapeBahan);

            if ($totalNaikLebarLembarCetakLandscape < 0) {
                break; // Menghentikan perulangan jika $totalNaikLebarLembarCetakLandscape menjadi negatif
            }

            if ($totalNaikLebarLembarCetakLandscape >= 0) {
                $resultsLebarNaikLandscapeBahan[] = [
                    'lebar_sisa_bahan' => $totalNaikLebarLembarCetakLandscape,
                    'lebar_naik_bahan' => $incrementLebarNaikLandscapeBahan,
                ];
            }

            $incrementLebarNaikLandscapeBahan++; // Menambahkan increment
        }

        $lebarSisaBahanLandscape = null;
        $lebarNaikBahanLandscape = null;

        foreach ($resultsLebarNaikLandscapeBahan as $data) {
            if ($lebarSisaBahanLandscape === null || $data['lebar_sisa_bahan'] < $lebarSisaBahanLandscape) {
                $lebarSisaBahanLandscape = $data['lebar_sisa_bahan'];
                $lebarNaikBahanLandscape = $data['lebar_naik_bahan'];
            }
        }

        $this->lebarNaikBahanLandscape = $lebarNaikBahanLandscape;
        //selesai Menentukan Panjang Naik Landscape Bahan

        $this->panjangSisaBahanLandscape = $panjangSisaBahanLandscape;
        $lebarSisaBahanLandscape = $this->lebarBahan;

        $this->lebarSisaBahanLandscape = $lebarSisaBahanLandscape;

        if($this->panjangSisaBahanLandscape >= $this->ukuranLebarLembarCetakLandscape){
            $resultsPanjangNaikLandscapeBahanSisa = []; // Membuat array untuk menyimpan hasil formula

            $sisaPanjangBahanPanjang = $this->panjangSisaBahanLandscape;
            $ukuranLebarLembarCetakLandscape = $this->ukuranLebarLembarCetakLandscape;

            $incrementPanjangNaikLandscapeBahan = 1; // Mulai dari increment 1
            while (true) {
                $totalNaikPanjangLembarCetakLandscapeSisaBahanPanjang = $sisaPanjangBahanPanjang - $ukuranLebarLembarCetakLandscape * $incrementPanjangNaikLandscapeBahan;

                if ($totalNaikPanjangLembarCetakLandscapeSisaBahanPanjang < 0) {
                    break; // Menghentikan perulangan jika $totalNaikPanjangLembarCetakLandscapeSisaBahanPanjang menjadi negatif
                }

                if ($totalNaikPanjangLembarCetakLandscapeSisaBahanPanjang >= 0) {
                    $resultsPanjangNaikLandscapeBahanSisa[] = [
                        'panjang_sisa_bahan' => $totalNaikPanjangLembarCetakLandscapeSisaBahanPanjang,
                        'panjang_naik_bahan' => $incrementPanjangNaikLandscapeBahan,
                    ];
                }

                $incrementPanjangNaikLandscapeBahan++; // Menambahkan increment
            }

            $panjangSisaBahanLandscape = null;
            $panjangNaikBahanLandscape = null;

            foreach ($resultsPanjangNaikLandscapeBahanSisa as $data) {
                if ($panjangSisaBahanLandscape === null || $data['panjang_sisa_bahan'] < $panjangSisaBahanLandscape) {
                    $panjangSisaBahanLandscape = $data['panjang_sisa_bahan'];
                    $panjangNaikBahanLandscape = $data['panjang_naik_bahan'];
                }
            }


            $this->panjangNaikSisaBahanPanjangLandscape = $panjangNaikBahanLandscape;


            $resultsLebarNaikLandscapeBahanSisa = []; // Membuat array untuk menyimpan hasil formula

            $sisaLebarBahanPanjang = $this->lebarBahan;
            $ukuranPanjangLembarCetakLandscape = $this->ukuranPanjangLembarCetakLandscape;

            $incrementPanjangNaikLandscapeBahan = 1; // Mulai dari increment 1
            while (true) {
                $totalNaikPanjangLembarCetakLandscapeSisaBahanPanjang = $sisaLebarBahanPanjang - $ukuranPanjangLembarCetakLandscape * $incrementPanjangNaikLandscapeBahan;

                if ($totalNaikPanjangLembarCetakLandscapeSisaBahanPanjang < 0) {
                    break; // Menghentikan perulangan jika $totalNaikPanjangLembarCetakLandscapeSisaBahanPanjang menjadi negatif
                }

                if ($totalNaikPanjangLembarCetakLandscapeSisaBahanPanjang >= 0) {
                    $resultsLebarNaikLandscapeBahanSisa[] = [
                        'panjang_sisa_bahan' => $totalNaikPanjangLembarCetakLandscapeSisaBahanPanjang,
                        'panjang_naik_bahan' => $incrementPanjangNaikLandscapeBahan,
                    ];
                }

                $incrementPanjangNaikLandscapeBahan++; // Menambahkan increment
            }

            $panjangSisaBahanLandscape = null;
            $panjangNaikBahanLandscape = null;

            foreach ($resultsLebarNaikLandscapeBahanSisa as $data) {
                if ($panjangSisaBahanLandscape === null || $data['panjang_sisa_bahan'] < $panjangSisaBahanLandscape) {
                    $panjangSisaBahanLandscape = $data['panjang_sisa_bahan'];
                    $panjangNaikBahanLandscape = $data['panjang_naik_bahan'];
                }
            }


            $this->lebarNaikSisaBahanPanjangLandscape = $panjangNaikBahanLandscape;

        }else{
            $this->panjangNaikSisaBahanPanjangLandscape = 0;
            $this->lebarNaikSisaBahanPanjangLandscape = 0;
        }

        $this->emit('updateCanvasSettingLandscape', $this->ukuranPanjangLembarCetakLandscape, $this->ukuranLebarLembarCetakLandscape, $this->panjangBarangJadi, $this->lebarBarangJadi, $this->jarakPanjangAntarBarang, $this->lebarNaikLandscape, $this->panjangNaikLandscape, $this->jarakSisiKiri, $this->jarakAtas);
        $this->emit('updateCanvasBahanLandscape', $this->ukuranPanjangLembarCetakLandscape, $this->ukuranLebarLembarCetakLandscape, $this->panjangBahan, $this->lebarBahan, $this->lebarNaikBahanLandscape, $this->panjangNaikBahanLandscape, $this->panjangNaikSisaBahanPanjangLandscape, $this->lebarNaikSisaBahanPanjangLandscape);
    }
}
