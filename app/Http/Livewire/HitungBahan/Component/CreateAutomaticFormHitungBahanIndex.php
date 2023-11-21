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
    public $mesin = 2;
    public $panjangAreaCetakMinimal;
    public $lebarAreaCetakMinimal;
    public $panjangAreaCetakMaximal;
    public $lebarAreaCetakMaximal;
    public $panjangMaximalBahan;
    public $lebarMaximalBahan;

    //detail
    public $panjangBarangJadi = 18;
    public $lebarBarangJadi = 5;

    public $qtyPermintaan = 1000;
    public $pond = 'Y';
    public $potongJadi = 'N';
    public $jarakPotongJadi = 'N';
    public $jarakPanjangAntarBarang;
    public $jarakLebarAntarBarang;
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

    //hasil Potrait
    public $panjangNaikPotrait;
    public $lebarNaikPotrait;

    public $ukuranPanjangLembarCetakPotrait;
    public $ukuranLebarLembarCetakPotrait;

    //hasil bahan landscape
    public $panjangSisaBahanLandscape;
    public $panjangNaikBahanLandscape;

    public $lebarSisaBahanLandscape;
    public $lebarNaikBahanLandscape;

    public $panjangNaikSisaBahanPanjangLandscape;
    public $lebarNaikSisaBahanPanjangLandscape;

    //hasil bahan Potrait
    public $panjangSisaBahanPotrait;
    public $panjangNaikBahanPotrait;

    public $lebarSisaBahanPotrait;
    public $lebarNaikBahanPotrait;

    public $panjangNaikSisaBahanPanjangPotrait;
    public $lebarNaikSisaBahanPanjangPotrait;

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
        $this->validate([
            'panjangBarangJadi' => 'required',
            'lebarBarangJadi' => 'required',
            'panjangBahan' => 'required',
            'lebarBahan' => 'required',
            'qtyPermintaan' => 'required',
            'mesin' => 'required',
            'pond' => 'required',
            'potongJadi' => 'required',
            'jarakPotongJadi' => 'required',
            // 'layoutSettingType' => 'required',
            // 'layoutBahanType' => 'required',
        ]);

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

        $dataMesin = Machine::find($this->mesin);

        $this->panjangAreaCetakMinimal = $dataMesin->panjang_area_cetak_minimal;
        $this->lebarAreaCetakMinimal = $dataMesin->lebar_area_cetak_minimal;
        $this->panjangAreaCetakMaximal = $dataMesin->panjang_area_cetak_maximal;
        $this->lebarAreaCetakMaximal = $dataMesin->lebar_area_cetak_maximal;
        $this->panjangMaximalBahan = $dataMesin->panjang_maximal_bahan;
        $this->lebarMaximalBahan = $dataMesin->lebar_maximal_bahan;

        //Menentukan Panjang Naik Landscape
        $resultsNaikLayoutSetting = []; // Membuat array untuk menyimpan hasil formula

        $panjangBarangJadi = $this->panjangBarangJadi;
        $lebarBarangJadi = $this->lebarBarangJadi;
        $jarakSisiKiri = $this->jarakSisiKiri;
        $jarakSisiKanan = $this->jarakSisiKanan;
        $jarakAtas = $this->jarakAtas;
        $jarakBawah = $this->jarakBawah;
        $jarakPanjangAntarBarang = $this->jarakPanjangAntarBarang;
        $jarakLebarAntarBarang = $this->jarakLebarAntarBarang;

        $incrementPanjangNaikLayoutSettingLandscape = 1; // Mulai dari increment 1
        while (true) {
            $totalPanjangLembarCetakLayoutSettingLandscape = $panjangBarangJadi * $incrementPanjangNaikLayoutSettingLandscape + ($jarakPanjangAntarBarang * ($incrementPanjangNaikLayoutSettingLandscape - 1) + $jarakSisiKiri + $jarakSisiKanan);

            if ($totalPanjangLembarCetakLayoutSettingLandscape >= $this->panjangAreaCetakMaximal) {
                break; // Menghentikan perulangan jika totalPanjangLembarCetakLayoutSettingLandscape mendekati panjangAreaCetakMaximal
            }

            if ($totalPanjangLembarCetakLayoutSettingLandscape >= $this->panjangAreaCetakMinimal && $totalPanjangLembarCetakLayoutSettingLandscape <= $this->panjangAreaCetakMaximal) {
                $resultsNaikLayoutSetting['layout_setting_landscape']['panjang'][] = [
                    'panjang_lembar_cetak' => $totalPanjangLembarCetakLayoutSettingLandscape,
                    'panjang_naik' => $incrementPanjangNaikLayoutSettingLandscape,
                ];
            }

            $incrementPanjangNaikLayoutSettingLandscape++; // Menambahkan increment
        }

        $incrementPanjangNaikLayoutSettingPotrait = 1; // Mulai dari increment 1
        while (true) {
            $totalPanjangLembarCetakLayoutSettingPotrait = $lebarBarangJadi * $incrementPanjangNaikLayoutSettingPotrait + ($jarakLebarAntarBarang * ($incrementPanjangNaikLayoutSettingPotrait - 1) + $jarakSisiKiri + $jarakSisiKanan);

            if ($totalPanjangLembarCetakLayoutSettingPotrait >= $this->panjangAreaCetakMaximal) {
                break; // Menghentikan perulangan jika totalPanjangLembarCetakLayoutSettingPotrait mendekati panjangAreaCetakMaximal
            }

            if ($totalPanjangLembarCetakLayoutSettingPotrait >= $this->panjangAreaCetakMinimal && $totalPanjangLembarCetakLayoutSettingPotrait <= $this->panjangAreaCetakMaximal) {
                $resultsNaikLayoutSetting['layout_setting_potrait']['panjang'][] = [
                    'panjang_lembar_cetak' => $totalPanjangLembarCetakLayoutSettingPotrait,
                    'panjang_naik' => $incrementPanjangNaikLayoutSettingPotrait,
                ];
            }

            $incrementPanjangNaikLayoutSettingPotrait++; // Menambahkan increment
        }

        // $maxUkuranPanjangLembarCetakLandscape = 0; // Variabel untuk menyimpan nilai terbesar
        // $panjangNaikLandscape = 0; // Variabel untuk menyimpan panjang_naik yang sesuai

        // foreach ($resultsPanjangNaikLandscape as $item) {
        //     $ukuranPanjangLembarCetak = $item['ukuran_panjang_lembar_cetak'];

        //     if ($ukuranPanjangLembarCetak > $maxUkuranPanjangLembarCetakLandscape) {
        //         $maxUkuranPanjangLembarCetakLandscape = $ukuranPanjangLembarCetak;
        //         $panjangNaikLandscape = $item['panjang_naik'];
        //     }
        // }

        // $this->ukuranPanjangLembarCetakLandscape = $maxUkuranPanjangLembarCetakLandscape;
        // $this->panjangNaikLandscape = $panjangNaikLandscape;
        //selesai Menentukan Panjang Naik Landscape

        //Menentukan Lebar Naik Landscape
        $incrementLebarNaikLayoutSettingLandscape = 1; // Mulai dari increment 1
        while (true) {
            $totalLebarLembarCetakLayoutSettingLandscape = $lebarBarangJadi * $incrementLebarNaikLayoutSettingLandscape + ($jarakLebarAntarBarang * ($incrementLebarNaikLayoutSettingLandscape - 1) + $jarakAtas + $jarakBawah);

            if ($totalLebarLembarCetakLayoutSettingLandscape >= $this->lebarAreaCetakMaximal) {
                break; // Menghentikan perulangan jika totalPanjangLembarCetakLandscape mendekati panjangAreaCetakMaximal
            }

            if ($totalLebarLembarCetakLayoutSettingLandscape >= $this->lebarAreaCetakMinimal && $totalLebarLembarCetakLayoutSettingLandscape <= $this->lebarAreaCetakMaximal) {
                $resultsNaikLayoutSetting['layout_setting_landscape']['lebar'][] = [
                    'lebar_lembar_cetak' => $totalLebarLembarCetakLayoutSettingLandscape,
                    'lebar_naik' => $incrementLebarNaikLayoutSettingLandscape,
                ];
            }

            $incrementLebarNaikLayoutSettingLandscape++; // Menambahkan increment
        }

        $incrementLebarNaikLayoutSettingPotrait = 1; // Mulai dari increment 1
        while (true) {
            $totalLebarLembarCetakLayoutSettingPotrait = $panjangBarangJadi * $incrementLebarNaikLayoutSettingPotrait + ($jarakPanjangAntarBarang * ($incrementLebarNaikLayoutSettingPotrait - 1) + $jarakAtas + $jarakBawah);

            if ($totalLebarLembarCetakLayoutSettingPotrait >= $this->lebarAreaCetakMaximal) {
                break; // Menghentikan perulangan jika totalPanjangLembarCetakLandscape mendekati panjangAreaCetakMaximal
            }

            if ($totalLebarLembarCetakLayoutSettingPotrait >= $this->lebarAreaCetakMinimal && $totalLebarLembarCetakLayoutSettingPotrait <= $this->lebarAreaCetakMaximal) {
                $resultsNaikLayoutSetting['layout_setting_potrait']['lebar'][] = [
                    'lebar_lembar_cetak' => $totalLebarLembarCetakLayoutSettingPotrait,
                    'lebar_naik' => $incrementLebarNaikLayoutSettingPotrait,
                ];
            }

            $incrementLebarNaikLayoutSettingPotrait++; // Menambahkan increment
        }

        // Inisialisasi array gabungan
        $groupData = [];

        // Loop Landscape
        foreach ($resultsNaikLayoutSetting['layout_setting_landscape']['panjang'] as $panjang) {
            // Loop lebar
            foreach ($resultsNaikLayoutSetting['layout_setting_landscape']['lebar'] as $lebar) {
                // Gabungkan panjang dan lebar menjadi satu array
                $groupData['layout_setting_landscape'][] = array_merge($panjang, $lebar);
            }
        }

        // Loop Potrait
        foreach ($resultsNaikLayoutSetting['layout_setting_potrait']['panjang'] as $panjang) {
            // Loop lebar
            foreach ($resultsNaikLayoutSetting['layout_setting_potrait']['lebar'] as $lebar) {
                // Gabungkan panjang dan lebar menjadi satu array
                $groupData['layout_setting_potrait'][] = array_merge($panjang, $lebar);
            }
        }
        // dd($groupData);

        $finalData = [];
        //Membagi bahan
        $panjangBahan = $this->panjangBahan;
        $lebarBahan = $this->lebarBahan;

        $incrementPanjangNaikLandscapeBahan = 1;
        foreach ($groupData['layout_setting_landscape'] as $key => $dataLandscape) {
            $incrementPanjangNaikLandscapeBahan = 1; // Mulai dari increment 1
            while (true) {
                $totalPanjangLembarCetakLandscapeBahan = $panjangBahan - $dataLandscape['panjang_lembar_cetak'] * $incrementPanjangNaikLandscapeBahan;

                if ($totalPanjangLembarCetakLandscapeBahan < 0) {
                    break; // Menghentikan perulangan jika $totalNaikPanjangLembarCetakLandscape menjadi negatif
                }

                if ($totalPanjangLembarCetakLandscapeBahan >= 0) {
                    $bahanLandscape = [
                        'total_qty_per_lembar_cetak' => $dataLandscape['panjang_naik'] * $dataLandscape['lebar_naik'],
                        'panjang_naik_bahan' => $incrementPanjangNaikLandscapeBahan,
                        'vertical_sisa_lebar_bahan' => $lebarBahan,
                        'vertical_naik_panjang_bahan' => [], // Initialize the array for 'vertical_naik_panjang_bahan'
                    ];

                    if($totalPanjangLembarCetakLandscapeBahan >= $dataLandscape['lebar_lembar_cetak']){
                        // Continue with additional logic for 'vertical_naik_panjang_bahan'
                        $incrementVerticalSisaPanjangBahan = 1;
                        while (true) {
                            $totalVerticalSisaPanjangBahan = $totalPanjangLembarCetakLandscapeBahan - $dataLandscape['lebar_lembar_cetak'] * $incrementVerticalSisaPanjangBahan;

                            if ($totalVerticalSisaPanjangBahan < 0) {
                                break; // Menghentikan perulangan jika $totalVerticalSisaPanjangBahan menjadi negatif
                            }

                            // Add the 'vertical_naik_panjang_bahan' array to the 'landscape' subarray
                            $bahanLandscape['vertical_naik_panjang_bahan'][] = [
                                'sisa_bahan_vertical_panjang' => $totalVerticalSisaPanjangBahan,
                                'vertical_panjang_naik' => $incrementVerticalSisaPanjangBahan,
                                'total_qty_per_plano' => $dataLandscape['panjang_naik'] * $dataLandscape['lebar_naik'] * $incrementPanjangNaikLandscapeBahan + ($incrementVerticalSisaPanjangBahan * $dataLandscape['panjang_naik'] * $dataLandscape['lebar_naik']),
                            ];

                            $incrementVerticalSisaPanjangBahan++;
                        }
                    }else{
                        // Add the 'vertical_naik_panjang_bahan' array to the 'landscape' subarray
                        $bahanLandscape['vertical_naik_panjang_bahan'][] = [
                            'sisa_bahan_vertical_panjang' => $totalPanjangLembarCetakLandscapeBahan,
                            'vertical_panjang_naik' => 0,
                            'total_qty_per_plano' => $dataLandscape['panjang_naik'] * $dataLandscape['lebar_naik'] * $incrementPanjangNaikLandscapeBahan + (0 * $dataLandscape['panjang_naik'] * $dataLandscape['lebar_naik']),
                        ];
                    }
                    // Add the 'bahanLandscape' array to the 'landscape' subarray
                    $groupData['layout_setting_landscape'][$key]['bahan']['landscape'][] = $bahanLandscape;
                }

                $incrementPanjangNaikLandscapeBahan++; // Menambahkan increment
            }

            $incrementPanjangNaikLandscapeBahan++;
        }


          // if($totalPanjangLembarCetakLandscapeBahan >= 0){
            //     if($totalPanjangLembarCetakLandscapeBahan >= $dataLandscape['lebar_lembar_cetak']){
            //         $finalData['layout_setting_landscape'][] = [
            //             'panjang_lembar_cetak' => $dataLandscape['panjang_lembar_cetak'],
            //             'panjang_naik' => $dataLandscape['panjang_naik'],
            //             'lebar_lembar_cetak' => $dataLandscape['lebar_lembar_cetak'],
            //             'lebar_naik' => $dataLandscape['lebar_naik'],
            //             'total_qty_per_lembar_cetak' => $dataLandscape['panjang_naik'] * $dataLandscape['lebar_naik'],
            //             'panjang_naik_bahan' => $incrementPanjangNaikLandscapeBahan,
            //             'vertical_sisa_panjang_bahan' => $totalPanjangLembarCetakLandscapeBahan,
            //             'vertical_sisa_lebar_bahan' => $lebarBahan,
            //             'lebar_naik_bahan' => $totalLebarLembarCetakLandscapeBahan,
            //         ];
            //     }else{
            //         $finalData['layout_setting_landscape'][] = [
            //             'panjang_lembar_cetak' => $dataLandscape['panjang_lembar_cetak'],
            //             'panjang_naik' => $dataLandscape['panjang_naik'],
            //             'lebar_lembar_cetak' => $dataLandscape['lebar_lembar_cetak'],
            //             'lebar_naik' => $dataLandscape['lebar_naik'],
            //             'total_qty_per_lembar_cetak' => $dataLandscape['panjang_naik'] * $dataLandscape['lebar_naik'],
            //             'panjang_naik_bahan' => $incrementPanjangNaikLandscapeBahan,
            //             'vertical_sisa_panjang_bahan' => $totalPanjangLembarCetakLandscapeBahan,
            //             'vertical_sisa_lebar_bahan' => 0,
            //             'lebar_naik_bahan' => $totalLebarLembarCetakLandscapeBahan,
            //         ];
            //     }

            // }



        // $resultsPanjangNaikLandscapeBahan = []; // Membuat array untuk menyimpan hasil formula
        // $resultsPanjangNaikPotraitBahan = []; // Membuat array untuk menyimpan hasil formula

        // $panjangBahan = $this->panjangBahan;

        // $incrementPanjangNaikLandscapeBahan = 1; // Mulai dari increment 1
        // while (true) {
        //     $ukuranPanjangLembarCetakLandscape = $this->ukuranPanjangLembarCetakLandscape;
        //         $totalNaikPanjangLembarCetakLandscape = $panjangBahan - $ukuranPanjangLembarCetakLandscape * $incrementPanjangNaikLandscapeBahan;

        //     if ($totalNaikPanjangLembarCetakLandscape < 0) {
        //         break; // Menghentikan perulangan jika $totalNaikPanjangLembarCetakLandscape menjadi negatif
        //     }

        //     if ($totalNaikPanjangLembarCetakLandscape >= 0) {
        //         $resultsPanjangNaikLandscapeBahan[] = [
        //             'panjang_sisa_bahan' => $totalNaikPanjangLembarCetakLandscape,
        //             'panjang_naik_bahan' => $incrementPanjangNaikLandscapeBahan,
        //         ];
        //     }

        //     $incrementPanjangNaikLandscapeBahan++; // Menambahkan increment
        // }

        // $incrementPanjangNaikLandscapeBahan = 1; // Mulai dari increment 1
        // while (true) {
        //         $ukuranLebarLembarCetakLandscape = $this->ukuranLebarLembarCetakLandscape;
        //         $totalNaikPanjangLembarCetakLandscape = $panjangBahan - $ukuranLebarLembarCetakLandscape * $incrementPanjangNaikLandscapeBahan;

        //     if ($totalNaikPanjangLembarCetakLandscape < 0) {
        //         break; // Menghentikan perulangan jika $totalNaikPanjangLembarCetakLandscape menjadi negatif
        //     }

        //     if ($totalNaikPanjangLembarCetakLandscape >= 0) {
        //         $resultsPanjangNaikPotraitBahan[] = [
        //             'panjang_sisa_bahan' => $totalNaikPanjangLembarCetakLandscape,
        //             'panjang_naik_bahan' => $incrementPanjangNaikLandscapeBahan,
        //         ];
        //     }

        //     $incrementPanjangNaikLandscapeBahan++; // Menambahkan increment
        // }

        // $panjangSisaBahanLandscape = null;
        // $panjangNaikBahanLandscape = null;

        // foreach ($resultsPanjangNaikLandscapeBahan as $data) {
        //     if ($panjangSisaBahanLandscape === null || $data['panjang_sisa_bahan'] < $panjangSisaBahanLandscape) {
        //         $panjangSisaBahanLandscape = $data['panjang_sisa_bahan'];
        //         $panjangNaikBahanLandscape = $data['panjang_naik_bahan'];
        //     }
        // }

        // $panjangSisaBahanPotrait = null;
        // $panjangNaikBahanPotrait = null;

        // foreach ($resultsPanjangNaikPotraitBahan as $data) {
        //     if ($panjangSisaBahanPotrait === null || $data['panjang_sisa_bahan'] < $panjangSisaBahanPotrait) {
        //         $panjangSisaBahanPotrait = $data['panjang_sisa_bahan'];
        //         $panjangNaikBahanPotrait = $data['panjang_naik_bahan'];
        //     }
        // }

        // if($this->layoutBahanType == "Landscape"){
        //     $this->panjangNaikBahanLandscape = $panjangNaikBahanLandscape;
        // }else if($this->layoutBahanType == "Potrait"){
        //     $this->panjangNaikBahanLandscape = $panjangNaikBahanPotrait;
        // }else{
        //     if($panjangSisaBahanLandscape < $panjangSisaBahanPotrait){
        //         $this->panjangNaikBahanLandscape = $panjangSisaBahanLandscape;
        //     }else{
        //         $this->panjangNaikBahanLandscape = $panjangNaikBahanPotrait;
        //     }
        // }

        // // dd($this->layoutBahanType);
        // //selesai Menentukan Panjang Naik Landscape Bahan

        // //Menentukan Lebar Naik Landscape Bahan
        // $resultsLebarNaikLandscapeBahan = []; // Membuat array untuk menyimpan hasil formula
        // $resultsLebarNaikPotraitBahan = []; // Membuat array untuk menyimpan hasil formula

        // $lebarBahan = $this->lebarBahan;

        // $incrementLebarNaikLandscapeBahan = 1; // Mulai dari increment 1
        // while (true) {

        //         $ukuranLebarLembarCetakLandscape = $this->ukuranLebarLembarCetakLandscape;
        //         $totalNaikLebarLembarCetakLandscape = $lebarBahan - ($ukuranLebarLembarCetakLandscape * $incrementLebarNaikLandscapeBahan);

        //     if ($totalNaikLebarLembarCetakLandscape < 0) {
        //         break; // Menghentikan perulangan jika $totalNaikLebarLembarCetakLandscape menjadi negatif
        //     }

        //     if ($totalNaikLebarLembarCetakLandscape >= 0) {
        //         $resultsLebarNaikLandscapeBahan[] = [
        //             'lebar_sisa_bahan' => $totalNaikLebarLembarCetakLandscape,
        //             'lebar_naik_bahan' => $incrementLebarNaikLandscapeBahan,
        //         ];
        //     }

        //     $incrementLebarNaikLandscapeBahan++; // Menambahkan increment
        // }

        // $incrementLebarNaikLandscapeBahan = 1; // Mulai dari increment 1
        // while (true) {

        //         $ukuranPanjangLembarCetakLandscape = $this->ukuranPanjangLembarCetakLandscape;
        //         $totalNaikLebarLembarCetakLandscape = $lebarBahan - ($ukuranPanjangLembarCetakLandscape * $incrementLebarNaikLandscapeBahan);

        //     if ($totalNaikLebarLembarCetakLandscape < 0) {
        //         break; // Menghentikan perulangan jika $totalNaikLebarLembarCetakLandscape menjadi negatif
        //     }

        //     if ($totalNaikLebarLembarCetakLandscape >= 0) {
        //         $resultsLebarNaikPotraitBahan[] = [
        //             'lebar_sisa_bahan' => $totalNaikLebarLembarCetakLandscape,
        //             'lebar_naik_bahan' => $incrementLebarNaikLandscapeBahan,
        //         ];
        //     }

        //     $incrementLebarNaikLandscapeBahan++; // Menambahkan increment
        // }

        // $lebarSisaBahanLandscape = null;
        // $lebarNaikBahanLandscape = null;

        // foreach ($resultsLebarNaikLandscapeBahan as $data) {
        //     if ($lebarSisaBahanLandscape === null || $data['lebar_sisa_bahan'] < $lebarSisaBahanLandscape) {
        //         $lebarSisaBahanLandscape = $data['lebar_sisa_bahan'];
        //         $lebarNaikBahanLandscape = $data['lebar_naik_bahan'];
        //     }
        // }

        // $lebarSisaBahanPotrait = null;
        // $lebarNaikBahanPotrait = null;

        // foreach ($resultsLebarNaikPotraitBahan as $data) {
        //     if ($lebarSisaBahanPotrait === null || $data['lebar_sisa_bahan'] < $lebarSisaBahanPotrait) {
        //         $lebarSisaBahanPotrait = $data['lebar_sisa_bahan'];
        //         $lebarNaikBahanPotrait = $data['lebar_naik_bahan'];
        //     }
        // }

        // if($this->layoutBahanType == "Landscape"){
        //     $this->lebarNaikBahanLandscape = $lebarNaikBahanLandscape;
        // }else if($this->layoutBahanType == "Potrait"){
        //     $this->lebarNaikBahanLandscape = $lebarNaikBahanPotrait;
        // }else{
        //     if($lebarSisaBahanLandscape < $lebarSisaBahanPotrait){
        //         $this->lebarNaikBahanLandscape = $lebarNaikBahanLandscape;
        //     }else{
        //         $this->lebarNaikBahanLandscape = $lebarNaikBahanPotrait;
        //     }
        // }

        // //selesai Menentukan Lebar Naik Landscape Bahan

        // $this->panjangSisaBahanLandscape = $panjangSisaBahanLandscape;
        // $lebarSisaBahanLandscape = $this->lebarBahan;

        // $this->lebarSisaBahanLandscape = $lebarSisaBahanLandscape;

        // if($this->panjangSisaBahanLandscape >= $this->ukuranLebarLembarCetakLandscape){
        //     $resultsPanjangNaikLandscapeBahanSisa = []; // Membuat array untuk menyimpan hasil formula

        //     $sisaPanjangBahanPanjang = $this->panjangSisaBahanLandscape;
        //     $ukuranLebarLembarCetakLandscape = $this->ukuranLebarLembarCetakLandscape;

        //     $incrementPanjangNaikLandscapeBahan = 1; // Mulai dari increment 1
        //     while (true) {
        //         $totalNaikPanjangLembarCetakLandscapeSisaBahanPanjang = $sisaPanjangBahanPanjang - $ukuranLebarLembarCetakLandscape * $incrementPanjangNaikLandscapeBahan;

        //         if ($totalNaikPanjangLembarCetakLandscapeSisaBahanPanjang < 0) {
        //             break; // Menghentikan perulangan jika $totalNaikPanjangLembarCetakLandscapeSisaBahanPanjang menjadi negatif
        //         }

        //         if ($totalNaikPanjangLembarCetakLandscapeSisaBahanPanjang >= 0) {
        //             $resultsPanjangNaikLandscapeBahanSisa[] = [
        //                 'panjang_sisa_bahan' => $totalNaikPanjangLembarCetakLandscapeSisaBahanPanjang,
        //                 'panjang_naik_bahan' => $incrementPanjangNaikLandscapeBahan,
        //             ];
        //         }

        //         $incrementPanjangNaikLandscapeBahan++; // Menambahkan increment
        //     }

        //     $panjangSisaBahanLandscape = null;
        //     $panjangNaikBahanLandscape = null;

        //     foreach ($resultsPanjangNaikLandscapeBahanSisa as $data) {
        //         if ($panjangSisaBahanLandscape === null || $data['panjang_sisa_bahan'] < $panjangSisaBahanLandscape) {
        //             $panjangSisaBahanLandscape = $data['panjang_sisa_bahan'];
        //             $panjangNaikBahanLandscape = $data['panjang_naik_bahan'];
        //         }
        //     }

        //     $this->panjangNaikSisaBahanPanjangLandscape = $panjangNaikBahanLandscape;

        //     $resultsLebarNaikLandscapeBahanSisa = []; // Membuat array untuk menyimpan hasil formula

        //     $sisaLebarBahanPanjang = $this->lebarBahan;
        //     $ukuranPanjangLembarCetakLandscape = $this->ukuranPanjangLembarCetakLandscape;

        //     $incrementPanjangNaikLandscapeBahan = 1; // Mulai dari increment 1
        //     while (true) {
        //         $totalNaikPanjangLembarCetakLandscapeSisaBahanPanjang = $sisaLebarBahanPanjang - $ukuranPanjangLembarCetakLandscape * $incrementPanjangNaikLandscapeBahan;

        //         if ($totalNaikPanjangLembarCetakLandscapeSisaBahanPanjang < 0) {
        //             break; // Menghentikan perulangan jika $totalNaikPanjangLembarCetakLandscapeSisaBahanPanjang menjadi negatif
        //         }

        //         if ($totalNaikPanjangLembarCetakLandscapeSisaBahanPanjang >= 0) {
        //             $resultsLebarNaikLandscapeBahanSisa[] = [
        //                 'panjang_sisa_bahan' => $totalNaikPanjangLembarCetakLandscapeSisaBahanPanjang,
        //                 'panjang_naik_bahan' => $incrementPanjangNaikLandscapeBahan,
        //             ];
        //         }

        //         $incrementPanjangNaikLandscapeBahan++; // Menambahkan increment
        //     }

        //     $panjangSisaBahanLandscape = null;
        //     $panjangNaikBahanLandscape = null;

        //     foreach ($resultsLebarNaikLandscapeBahanSisa as $data) {
        //         if ($panjangSisaBahanLandscape === null || $data['panjang_sisa_bahan'] < $panjangSisaBahanLandscape) {
        //             $panjangSisaBahanLandscape = $data['panjang_sisa_bahan'];
        //             $panjangNaikBahanLandscape = $data['panjang_naik_bahan'];
        //         }
        //     }

        //     $this->lebarNaikSisaBahanPanjangLandscape = $panjangNaikBahanLandscape;

        // }else{
        //     $this->panjangNaikSisaBahanPanjangLandscape = 0;
        //     $this->lebarNaikSisaBahanPanjangLandscape = 0;
        // }

        // if($this->layoutSettingType == "Potrait"){
        //     $this->emit('updateCanvasSettingPotrait', $this->ukuranPanjangLembarCetakLandscape, $this->ukuranLebarLembarCetakLandscape, $this->panjangBarangJadi, $this->lebarBarangJadi, $this->jarakPanjangAntarBarang, $this->lebarNaikLandscape, $this->panjangNaikLandscape, $this->jarakSisiKiri, $this->jarakAtas);
        // }else{
        //     $this->emit('updateCanvasSettingLandscape', $this->ukuranPanjangLembarCetakLandscape, $this->ukuranLebarLembarCetakLandscape, $this->panjangBarangJadi, $this->lebarBarangJadi, $this->jarakPanjangAntarBarang, $this->lebarNaikLandscape, $this->panjangNaikLandscape, $this->jarakSisiKiri, $this->jarakAtas);
        // }

        // if($this->layoutBahanType == "Potrait"){
        //     $this->emit('updateCanvasBahanPotrait', $this->ukuranPanjangLembarCetakLandscape, $this->ukuranLebarLembarCetakLandscape, $this->panjangBahan, $this->lebarBahan, $this->lebarNaikBahanLandscape, $this->panjangNaikBahanLandscape);
        // }else if($this->layoutBahanType == "Landscape"){
        //     $this->emit('updateCanvasBahanLandscape', $this->ukuranPanjangLembarCetakLandscape, $this->ukuranLebarLembarCetakLandscape, $this->panjangBahan, $this->lebarBahan, $this->lebarNaikBahanLandscape, $this->panjangNaikBahanLandscape);
        // }else{
        //     $total = $this->ukuranPanjangLembarCetakLandscape * $this->panjangNaikBahanLandscape;
        //     if($total <= $panjangBahan){
        //         $this->emit('updateCanvasBahanCombination', $this->ukuranPanjangLembarCetakLandscape, $this->ukuranLebarLembarCetakLandscape, $this->panjangBahan, $this->lebarBahan, $this->lebarNaikBahanLandscape, $this->panjangNaikBahanLandscape, $this->panjangNaikSisaBahanPanjangLandscape, $this->lebarNaikSisaBahanPanjangLandscape);
        //     }else{
        //         $this->emit('updateCanvasBahanCombination', $this->ukuranLebarLembarCetakLandscape, $this->ukuranPanjangLembarCetakLandscape, $this->panjangBahan, $this->lebarBahan, $this->lebarNaikBahanLandscape, $this->panjangNaikBahanLandscape, $this->panjangNaikSisaBahanPanjangLandscape, $this->lebarNaikSisaBahanPanjangLandscape);
        //     }

        // }


        $panjangSheet = 109;
        $lebarSheet = 79;
        $panjangCutSize = 37.2;
        $lebarCutSize = 22.1;

        // Menghitung jumlah potret yang dapat masuk
        $potretPerPanjang = floor($panjangSheet / $lebarCutSize);
        $potretPerLebar = floor($lebarSheet / $panjangCutSize);
        $jumlahPotret = $potretPerPanjang * $potretPerLebar;

        // Menghitung jumlah lanskap yang dapat masuk
        $lanskapPerPanjang = floor($panjangSheet / $panjangCutSize);
        $lanskapPerLebar = floor($lebarSheet / $lebarCutSize);
        $jumlahLanskap = $lanskapPerPanjang * $lanskapPerLebar;

        // Menghitung jumlah maksimum autorotation
$maksimalAutorotation = max($jumlahPotret, $jumlahLanskap);

        dd($maksimalAutorotation);
    }
}
