<?php

namespace App\Http\Livewire\HitungBahan\Index;

use Livewire\Component;

class IndexAutomaticSpk extends Component
{
    public $mesin = 52;
    public $panjangAreaCetakMinimal = 18;
    public $lebarAreaCetakMinimal = 11.6;
    public $panjangAreaCetakMaximal = 50.5;
    public $lebarAreaCetakMaximal = 34.5;
    public $panjangMaximalBahan = 51.5;
    public $lebarMaximalBahan = 36.2;

    //detail
    public $panjangBarangJadi = 18.5;
    public $lebarBarangJadi = 5;
    public $qtyPermintaan = 50000;
    public $pond = 'Y';
    public $potongJadi = 'Y';
    public $jarakPotongJadi = 'Y';
    public $jarakPanjangAntarBarang;
    public $jarakLebarAntarBarang = 0.2;
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

    // public function hitungJarakAntarBarang()
    // {
    //     if ($this->pond == 'Y' && $this->potongJadi == 'N' && $this->jarakPotongJadi == 'N') {
    //         $this->jarakPanjangAntarBarang = 0.4;
    //     } elseif ($this->pond == 'Y' && $this->potongJadi == 'Y' && $this->jarakPotongJadi == 'N') {
    //         $this->jarakPanjangAntarBarang = 0.2;
    //     } elseif ($this->pond == 'Y' && $this->potongJadi == 'Y' && $this->jarakPotongJadi == 'Y') {
    //         $this->jarakPanjangAntarBarang = 0.2;
    //     } elseif ($this->pond == 'N' && $this->potongJadi == 'Y' && $this->jarakPotongJadi == 'Y') {
    //         $this->jarakPanjangAntarBarang = 0.2;
    //     } elseif ($this->pond == 'N' && $this->potongJadi == 'Y' && $this->jarakPotongJadi == 'N') {
    //         $this->jarakPanjangAntarBarang = 0;
    //     } else {
    //         $this->jarakPanjangAntarBarang = 0;
    //     }

    //     return $this->jarakPanjangAntarBarang;
    // }

    // public function hitungPanjangNaikLandscape()
    // {
    //     $results = [];  // Membuat array untuk menyimpan hasil formula

    //     $panjangBarangJadi = $this->panjangBarangJadi;
    //     $jarakSisiKiri = $this->jarakSisiKiri;
    //     $jarakSisiKanan = $this->jarakSisiKanan;

    //     $increment = 1; // Mulai dari increment 1
    //     while (true) {
    //         $jarakPanjangAntarBarang = $this->jarakPanjangAntarBarang; // Hitung jarak antar barang
    //         $hasilFormula = $panjangBarangJadi * $increment + ($jarakPanjangAntarBarang * ($increment - 1) + $jarakSisiKiri + $jarakSisiKanan);

    //         if ($hasilFormula >= $this->panjangAreaCetakMaximal - 1) {
    //             break; // Menghentikan perulangan jika hasilFormula mendekati panjangAreaCetakMaximal
    //         }

    //         if ($hasilFormula >= $this->panjangAreaCetakMinimal && $hasilFormula <= $this->panjangAreaCetakMaximal) {
    //             $results[] = [
    //                 'ukuran_panjang_lembar_cetak' => $hasilFormula,
    //                 'panjang_naik' => $increment,
    //             ];
    //         }

    //         $increment++; // Menambahkan increment
    //     }

    //     $maxUkuranPanjangLembarCetak = 0; // Variabel untuk menyimpan nilai terbesar
    //     $panjangNaik = 0; // Variabel untuk menyimpan panjang_naik yang sesuai

    //     foreach ($results as $item) {
    //         $ukuranPanjangLembarCetak = $item['ukuran_panjang_lembar_cetak'];

    //         if ($ukuranPanjangLembarCetak > $maxUkuranPanjangLembarCetak) {
    //             $maxUkuranPanjangLembarCetak = $ukuranPanjangLembarCetak;
    //             $panjangNaik = $item['panjang_naik'];
    //         }
    //     }

    //     $ukuranPanjangLembarCetak = $maxUkuranPanjangLembarCetak;
    //     //selesai Menentukan Panjang Naik Landscape
    // }

    public function render()
    {
        //hitungJarakAntarBarang
        if ($this->pond == 'Y' && $this->potongJadi == 'N' && $this->jarakPotongJadi == 'N') {
            $this->jarakPanjangAntarBarang = 0.4;
        } elseif ($this->pond == 'Y' && $this->potongJadi == 'Y' && $this->jarakPotongJadi == 'N') {
            $this->jarakPanjangAntarBarang = 0.2;
        } elseif ($this->pond == 'Y' && $this->potongJadi == 'Y' && $this->jarakPotongJadi == 'Y') {
            $this->jarakPanjangAntarBarang = 0.2;
        } elseif ($this->pond == 'N' && $this->potongJadi == 'Y' && $this->jarakPotongJadi == 'Y') {
            $this->jarakPanjangAntarBarang = 0.2;
        } elseif ($this->pond == 'N' && $this->potongJadi == 'Y' && $this->jarakPotongJadi == 'N') {
            $this->jarakPanjangAntarBarang = 0;
        } else {
            $this->jarakPanjangAntarBarang = 0;
        }

        //Menentukan Panjang Naik Landscape
        $resultsPanjangNaikLandscape = [];  // Membuat array untuk menyimpan hasil formula

        $panjangBarangJadi = $this->panjangBarangJadi;
        $jarakSisiKiri = $this->jarakSisiKiri;
        $jarakSisiKanan = $this->jarakSisiKanan;

        $incrementPanjangNaikLandscape = 1; // Mulai dari increment 1
        while (true) {
            $jarakPanjangAntarBarang = $this->jarakPanjangAntarBarang; // Hitung jarak antar barang
            $totalPanjangLembarCetakLandscape = $panjangBarangJadi * $incrementPanjangNaikLandscape + ($jarakPanjangAntarBarang * ($incrementPanjangNaikLandscape - 1) + $jarakSisiKiri + $jarakSisiKanan);

            if ($totalPanjangLembarCetakLandscape >= $this->panjangAreaCetakMaximal - 1) {
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
        $resultsLebarNaikLandscape = [];  // Membuat array untuk menyimpan hasil formula

        $lebarBarangJadi = $this->lebarBarangJadi;
        $jarakAtas = $this->jarakAtas;
        $jarakBawah = $this->jarakBawah;

        $incrementLebarNaikLandscape = 1; // Mulai dari increment 1
        while (true) {
            $jarakLebarAntarBarang = $this->jarakLebarAntarBarang; // Hitung jarak antar barang
            $totalLebarLembarCetakLandscape = $lebarBarangJadi * $incrementLebarNaikLandscape + ($jarakLebarAntarBarang * ($incrementLebarNaikLandscape - 1) + $jarakAtas + $jarakBawah);

            if ($totalLebarLembarCetakLandscape >= $this->lebarAreaCetakMaximal - 1) {
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
        $resultsPanjangNaikLandscapeBahan = [];  // Membuat array untuk menyimpan hasil formula

        $panjangBahan = $this->panjangBahan;
        $ukuranPanjangLembarCetakLandscape = $this->ukuranPanjangLembarCetakLandscape;

        $incrementPanjangNaikLandscapeBahan = 1; // Mulai dari increment 1
        while (true) {
            $totalNaikPanjangLembarCetakLandscape = $panjangBahan - ($ukuranPanjangLembarCetakLandscape * $incrementPanjangNaikLandscapeBahan);

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
            if ($panjangSisaBahanLandscape === null || $data["panjang_sisa_bahan"] < $panjangSisaBahanLandscape) {
                $panjangSisaBahanLandscape = $data["panjang_sisa_bahan"];
                $panjangNaikBahanLandscape = $data["panjang_naik_bahan"];
            }
        }

        $this->panjangSisaBahanLandscape = $panjangSisaBahanLandscape;
        $this->panjangNaikBahanLandscape = $panjangNaikBahanLandscape;
        //selesai Menentukan Panjang Naik Landscape Bahan


        //Menentukan Panjang Naik Landscape Bahan
        $resultsLebarNaikLandscapeBahan = [];  // Membuat array untuk menyimpan hasil formula

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
            if ($lebarSisaBahanLandscape === null || $data["lebar_sisa_bahan"] < $lebarSisaBahanLandscape) {
                $lebarSisaBahanLandscape = $data["lebar_sisa_bahan"];
                $lebarNaikBahanLandscape = $data["lebar_naik_bahan"];
            }
        }

        $this->lebarSisaBahanLandscape = $lebarSisaBahanLandscape;
        $this->lebarNaikBahanLandscape = $lebarNaikBahanLandscape;
        //selesai Menentukan Panjang Naik Landscape Bahan


        return view('livewire.hitung-bahan.index.index-automatic-spk')
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Form Hitung Bahan']);
    }
}
