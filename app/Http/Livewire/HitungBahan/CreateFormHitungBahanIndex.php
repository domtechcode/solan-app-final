<?php

namespace App\Http\Livewire\HitungBahan;

use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Keterangan;
use App\Models\Instruction;
use App\Models\LayoutBahan;
use App\Models\LayoutSetting;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CreateFormHitungBahanIndex extends Component
{
    use WithFileUploads;
    public $filerincian = [];
    public $layoutSettings = [];
    public $layoutBahans = [];
    public $keterangans = [];
    public $currentInstructionId;
    public $instructionData;
    public $contohData;

    public $stateWorkStepPlate;
    public $stateWorkStepSablon;
    public $stateWorkStepPond;
    public $stateWorkStepCetakLabel;

    //modal
    public $selectedInstruction;
    public $selectedWorkStep;
    public $selectedFileContoh;
    public $selectedFileArsip;
    public $selectedFileAccounting;
    public $selectedFileLayout;
    public $selectedFileSample;

    public function addFormSetting()
    {
        $this->layoutSettings[] = [
            'panjang_barang_jadi' => '',
            'lebar_barang_jadi' => '',
            'panjang_bahan_cetak' => '',
            'lebar_bahan_cetak' => '',
            'dataURL' => '',
            'dataJSON' => '',
            'state' => '',
            'panjang_naik' => '',
            'lebar_naik' => '',
            'jarak_panjang' => '',
            'jarak_lebar' => '',
            'sisi_atas' => '',
            'sisi_bawah' => '',
            'sisi_kiri' => '',
            'sisi_kanan' => '',
            'jarak_tambahan_vertical' => '',
            'jarak_tambahan_horizontal' => '',
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
            'dataURL' => '',
            'dataJSON' => '',
            'state' => '',
            'panjang_plano' => '',
            'lebar_plano' => '',
            'panjang_bahan_cetak' => '',
            'lebar_bahan_cetak' => '',
            'jenis_bahan' => '',
            'gramasi' => '',
            'one_plano' => '',
            'sumber_bahan' => '',
            'merk_bahan' => '',
            'supplier' => '',
            'jumlah_lembar_cetak' => '',
            'jumlah_incit' => '',
            'total_lembar_cetak' => '',
            'harga_bahan' => '',
            'jumlah_bahan' => '',
            'panjang_sisa_bahan' => '',
            'lebar_sisa_bahan' => '',
            'fileLayoutCustom' => '',
            'include_belakang' => '',
        ];
    }

    public function removeFormBahan($indexBahan)
    {
        unset($this->layoutBahans[$indexBahan]);
        $this->layoutBahans = array_values($this->layoutBahans);
    }

    public function calculateTotalLembarCetak($indexBahan)
    {
        $jumlahLembarCetak = $this->layoutBahans[$indexBahan]['jumlah_lembar_cetak'] ?? 0;
        $jumlahIncit = $this->layoutBahans[$indexBahan]['jumlah_incit'] ?? 0;

        if (is_numeric($jumlahLembarCetak) && is_numeric($jumlahIncit)) {
            $totalLembarCetak = $jumlahLembarCetak + $jumlahIncit;
        } else {
            $totalLembarCetak = 0;
        }

        $this->layoutBahans[$indexBahan]['total_lembar_cetak'] = currency_idr($totalLembarCetak);
    }

    public function addFormKeterangan()
    {
        $this->keterangans[] = [
            'plate' => [],
            'screen' => [],
            'pond' => [],
            'label' => [
                [
                    'alat_bahan' => 'Cylinder',
                ],
                [
                    'alat_bahan' => 'Pita',
                ],
                [
                    'alat_bahan' => 'Tinta',
                ],
                [
                    'alat_bahan' => 'Plate',
                ],
                
            ],
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

    public function removeRincianPlate($index, $keteranganIndex, $rincianIndexPlate)
    {
        unset($this->keterangans[$keteranganIndex]['rincianPlate'][$rincianIndexPlate]);
        $this->keterangans[$keteranganIndex]['rincianPlate'] = array_values($this->keterangans[$keteranganIndex]['rincianPlate']);
    }

    public function addRincianScreen($keteranganIndex)
    {
        $this->keterangans[$keteranganIndex]['rincianScreen'][] = '';
    }

    public function removeRincianScreen($index, $keteranganIndex, $rincianIndexScreen)
    {
        unset($this->keterangans[$keteranganIndex]['rincianScreen'][$rincianIndexScreen]);
        $this->keterangans[$keteranganIndex]['rincianScreen'] = array_values($this->keterangans[$keteranganIndex]['rincianScreen']);
    }

    public function mount($instructionId)
    {
        $this->currentInstructionId = $instructionId;
        $this->instructionData = Instruction::where('id', $instructionId)->get();
        $this->contohData = Files::where('instruction_id', $instructionId)->where('type_file', 'contoh')->get();

        $this->stateWorkStepPlate = WorkStep::where('instruction_id', $instructionId)->where('work_step_list_id', 7)->first();
        $this->stateWorkStepSablon = WorkStep::where('instruction_id', $instructionId)->where('work_step_list_id', 23)->first();
        $this->stateWorkStepPond = WorkStep::where('instruction_id', $instructionId)->where('work_step_list_id', 24)->first();
        $this->stateWorkStepCetakLabel = WorkStep::where('instruction_id', $instructionId)->where('work_step_list_id', 12)->first();
        // dd($this->stateWorkStepCetakLabel);
        
         // Cek apakah array layoutSettings dan keterangans kosong
        if (empty($this->layoutSettings)) {
            $this->layoutSettings[] = [
                'panjang_barang_jadi' => '',
                'lebar_barang_jadi' => '',
                'panjang_bahan_cetak' => '',
                'lebar_bahan_cetak' => '',
                'dataURL' => '',
                'dataJSON' => '',
                'state' => '',
                'panjang_naik' => '',
                'lebar_naik' => '',
                'jarak_panjang' => '',
                'jarak_lebar' => '',
                'sisi_atas' => '',
                'sisi_bawah' => '',
                'sisi_kiri' => '',
                'sisi_kanan' => '',
                'jarak_tambahan_vertical' => '',
                'jarak_tambahan_horizontal' => '',
            ];
        }
        
        if (empty($this->keterangans)) {
            $this->keterangans[] = [
                'plate' => [],
                'screen' => [],
                'pond' => [],
                'label' => [
                    [
                        'alat_bahan' => 'Cylinder',
                    ],
                    [
                        'alat_bahan' => 'Pita',
                    ],
                    [
                        'alat_bahan' => 'Tinta',
                    ],
                    [
                        'alat_bahan' => 'Plate',
                    ],
                    
                ],
                'fileRincian' => [],
                'rincianPlate' => [],
                'rincianScreen' => [],
                'notes' => '',
            ];
        }
        if (empty($this->layoutBahans)) {
            $this->layoutBahans[] = [
                'dataURL' => '',
                'dataJSON' => '',
                'state' => '',
                'panjang_plano' => '',
                'lebar_plano' => '',
                'panjang_bahan_cetak' => '',
                'lebar_bahan_cetak' => '',
                'jenis_bahan' => '',
                'gramasi' => '',
                'one_plano' => '',
                'sumber_bahan' => '',
                'merk_bahan' => '',
                'supplier' => '',
                'jumlah_lembar_cetak' => '',
                'jumlah_incit' => '',
                'total_lembar_cetak' => '',
                'harga_bahan' => '',
                'jumlah_bahan' => '',
                'panjang_sisa_bahan' => '',
                'lebar_sisa_bahan' => '',
                'fileLayoutCustom' => '',
                'include_belakang' => '',
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
            'layoutSettings.*.state' => 'required',
            'layoutSettings.*.panjang_naik' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutSettings.*.lebar_naik' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutSettings.*.jarak_panjang' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutSettings.*.jarak_lebar' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutSettings.*.sisi_atas' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutSettings.*.sisi_bawah' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutSettings.*.sisi_kiri' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutSettings.*.sisi_kanan' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutSettings.*.jarak_tambahan_vertical' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutSettings.*.jarak_tambahan_horizontal' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
       
            'layoutBahans' => 'required|array|min:1',
            // 'layoutBahans.*.dataURL' => 'required',
            // 'layoutBahans.*.dataJSON' => 'required',
            'layoutBahans.*.state' => 'required',
            'layoutBahans.*.panjang_plano' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutBahans.*.lebar_plano' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutBahans.*.panjang_bahan_cetak' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutBahans.*.lebar_bahan_cetak' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutBahans.*.jenis_bahan' => 'required',
            'layoutBahans.*.gramasi' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutBahans.*.one_plano' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutBahans.*.sumber_bahan' => 'required',
            'layoutBahans.*.merk_bahan' => 'required',
            'layoutBahans.*.supplier' => 'required',
            'layoutBahans.*.jumlah_lembar_cetak' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutBahans.*.jumlah_incit' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutBahans.*.total_lembar_cetak' => 'required',
            'layoutBahans.*.harga_bahan' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutBahans.*.jumlah_bahan' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutBahans.*.panjang_sisa_bahan' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'layoutBahans.*.lebar_sisa_bahan' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
        ], [
            'layoutSettings.required' => 'Setidaknya satu layout setting harus diisi.',
            'layoutSettings.min' => 'Setidaknya satu layout setting harus diisi.',
            'layoutSettings.*.dataURL.required' => 'Gambar harus dibuat terlebih dahulu.',
            'layoutSettings.*.dataJSON.required' => 'Gambar harus dibuat terlebih dahulu.',
            'layoutSettings.*.state.required' => 'View layout harus diisi.',
            'layoutSettings.*.panjang_barang_jadi.required' => 'Panjang barang jadi harus diisi.',
            'layoutSettings.*.lebar_barang_jadi.required' => 'Lebar barang jadi harus diisi.',
            'layoutSettings.*.panjang_bahan_cetak.required' => 'Panjang bahan cetak harus diisi.',
            'layoutSettings.*.lebar_bahan_cetak.required' => 'Lebar bahan cetak harus diisi.',
            'layoutSettings.*.panjang_naik.required' => 'Panjang Naik harus diisi.',
            'layoutSettings.*.lebar_naik.required' => 'Lebar Naik harus diisi.',
            'layoutSettings.*.jarak_panjang.required' => 'Jarak Panjang harus diisi.',
            'layoutSettings.*.jarak_lebar.required' => 'Jarak Lebar harus diisi.',
            'layoutSettings.*.sisi_atas.required' => 'Sisi Atas harus diisi.',
            'layoutSettings.*.sisi_bawah.required' => 'Sisi Bawah harus diisi.',
            'layoutSettings.*.sisi_kiri.required' => 'Sisi Kiri harus diisi.',
            'layoutSettings.*.sisi_kanan.required' => 'Sisi Kanan harus diisi.',
            'layoutSettings.*.jarak_tambahan_vertical.required' => 'Jarak Tambahan Vertical harus diisi.',
            'layoutSettings.*.jarak_tambahan_horizontal.required' => 'Jarak Tambahan Horizontal harus diisi.',

            'layoutSettings.*.panjang_barang_jadi.numeric' => 'Panjang barang jadi harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutSettings.*.lebar_barang_jadi.numeric' => 'Lebar barang jadi harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutSettings.*.panjang_bahan_cetak.numeric' => 'Panjang bahan cetak harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutSettings.*.lebar_bahan_cetak.numeric' => 'Lebar bahan cetak harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutSettings.*.panjang_naik.numeric' => 'Panjang Naik harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutSettings.*.lebar_naik.numeric' => 'Lebar Naik harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutSettings.*.jarak_panjang.numeric' => 'Jarak Panjang harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutSettings.*.jarak_lebar.numeric' => 'Jarak Lebar harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutSettings.*.sisi_atas.numeric' => 'Sisi Atas harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutSettings.*.sisi_bawah.numeric' => 'Sisi Bawah harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutSettings.*.sisi_kiri.numeric' => 'Sisi Kiri harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutSettings.*.sisi_kanan.numeric' => 'Sisi Kanan harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutSettings.*.jarak_tambahan_vertical.numeric' => 'Jarak Tambahan Vertical harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutSettings.*.jarak_tambahan_horizontal.numeric' => 'Jarak Tambahan Horizontal harus berupa angka/tidak boleh ada tanda koma(,).',
    
            'layoutBahans.required' => 'Setidaknya satu layout setting harus diisi.',
            'layoutBahans.min' => 'Setidaknya satu layout setting harus diisi.',
            // 'layoutBahans.*.dataURL.required' => 'Gambar harus dibuat terlebih dahulu.',
            // 'layoutBahans.*.dataJSON.required' => 'Gambar harus dibuat terlebih dahulu.',
            'layoutBahans.*.state.required' => 'View layout harus diisi.',
            'layoutBahans.*.panjang_plano.required' => 'Panjang Plano harus diisi.',
            'layoutBahans.*.lebar_plano.required' => 'Lebar Plano harus diisi.',
            'layoutBahans.*.panjang_bahan_cetak.required' => 'Panjang bahan cetak harus diisi.',
            'layoutBahans.*.lebar_bahan_cetak.required' => 'Lebar bahan cetak harus diisi.',
            'layoutBahans.*.jenis_bahan.required' => 'Jenis bahan harus diisi.',
            'layoutBahans.*.gramasi.required' => 'Gramasi bahan harus diisi.',
            'layoutBahans.*.one_plano.required' => '1 Plano harus diisi.',
            'layoutBahans.*.sumber_bahan.required' => 'Sumber Bahan harus diisi.',
            'layoutBahans.*.merk_bahan.required' => 'Merk Bahan harus diisi.',
            'layoutBahans.*.supplier.required' => 'Supplier harus diisi.',
            'layoutBahans.*.jumlah_lembar_cetak.required' => 'Jumlah Lembar Cetak harus diisi.',
            'layoutBahans.*.jumlah_incit.required' => 'Jumlah Incit harus diisi.',
            'layoutBahans.*.total_lembar_cetak.required' => 'Total Lembar Cetak harus diisi.',
            'layoutBahans.*.harga_bahan.required' => 'Harga Bahan harus diisi.',
            'layoutBahans.*.jumlah_bahan.required' => 'Jumlah Bahan harus diisi.',
            'layoutBahans.*.panjang_sisa_bahan.required' => 'Panjang Sisa Bahan harus diisi.',
            'layoutBahans.*.lebar_sisa_bahan.required' => 'Lebar Sisa Bahan harus diisi.',

            'layoutBahans.*.panjang_plano.numeric' => 'Panjang Plano harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutBahans.*.lebar_plano.numeric' => 'Lebar Plano harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutBahans.*.panjang_bahan_cetak.numeric' => 'Panjang bahan cetak harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutBahans.*.lebar_bahan_cetak.numeric' => 'Lebar bahan cetak harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutBahans.*.gramasi.numeric' => 'Gramasi harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutBahans.*.one_plano.numeric' => '1 Plano harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutBahans.*.jumlah_lembar_cetak.numeric' => 'Jumlah Lembar Cetak harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutBahans.*.jumlah_incit.numeric' => 'Jumlah Incit harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutBahans.*.harga_bahan.numeric' => 'Harga Bahan harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutBahans.*.jumlah_bahan.numeric' => 'Harga Bahan harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutBahans.*.panjang_sisa_bahan.numeric' => 'Panjang Sisa Bahan harus berupa angka/tidak boleh ada tanda koma(,).',
            'layoutBahans.*.lebar_sisa_bahan.numeric' => 'Lebar Sisa Bahan harus berupa angka/tidak boleh ada tanda koma(,).',
        ]);

        if(isset($this->stateWorkStepPlate)){
            $this->validate([        
                'keterangans' => 'required|array|min:1',
                'keterangans.*.plate' => 'required|array|min:1',
                'keterangans.*.plate.*.state_plate' => 'required',
                'keterangans.*.plate.*.jumlah_plate' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
                'keterangans.*.plate.*.ukuran_plate' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
               
                'keterangans.*.rincianPlate' => 'required|array|min:1',
                'keterangans.*.rincianPlate.*.state' => 'required',
                'keterangans.*.rincianPlate.*.plate' => 'required',
                'keterangans.*.rincianPlate.*.jumlah_lembar_cetak' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
                'keterangans.*.rincianPlate.*.waste' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            ], [
                'keterangans.*.plate.required' => 'Setidaknya satu data plate harus diisi pada keterangan.',
                'keterangans.*.plate.min' => 'Setidaknya satu data plate harus diisi pada keterangan.',
                'keterangans.*.plate.*.state_plate.required' => 'State pada data plate harus diisi pada keterangan.',
                'keterangans.*.plate.*.jumlah_plate.required' => 'Jumlah plate harus diisi pada keterangan.',
                'keterangans.*.plate.*.jumlah_plate.numeric' => 'Jumlah plate harus berupa angka/tidak boleh ada tanda koma(,).',
                'keterangans.*.plate.*.ukuran_plate.required' => 'Ukuran plate harus diisi pada keterangan.',
                'keterangans.*.plate.*.ukuran_plate.numeric' => 'Ukuran plate harus berupa angka/tidak boleh ada tanda koma(,).',

                'keterangans.*.rincianPlate.required' => 'Setidaknya satu data rincian plate harus diisi pada keterangan.',
                'keterangans.*.rincianPlate.min' => 'Setidaknya satu data rincian plate harus diisi pada keterangan.',
                'keterangans.*.rincianPlate.*.state.required' => 'State pada rincian plate harus diisi pada keterangan.',
                'keterangans.*.rincianPlate.*.plate.required' => 'Plate harus diisi pada keterangan.',
                'keterangans.*.rincianPlate.*.jumlah_lembar_cetak.required' => 'Jumlah lembar cetak harus diisi pada keterangan.',
                'keterangans.*.rincianPlate.*.jumlah_lembar_cetak.numeric' => 'Jumlah lembar cetak harus berupa angka/tidak boleh ada tanda koma(,).',
                'keterangans.*.rincianPlate.*.waste.required' => 'Waste harus diisi pada keterangan.',
                'keterangans.*.rincianPlate.*.waste.numeric' => 'Waste harus berupa angka/tidak boleh ada tanda koma(,).',
            ]);
        }

        if(isset($this->stateWorkStepSablon)){
            $this->validate([        
                'keterangans' => 'required|array|min:1',
                'keterangans.*.screen' => 'required|array|min:1',
                'keterangans.*.screen.*.state_screen' => 'required',
                'keterangans.*.screen.*.jumlah_screen' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
                'keterangans.*.screen.*.ukuran_screen' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
                
                'keterangans.*.rincianScreen' => 'required|array|min:1',
                'keterangans.*.rincianScreen.*.state' => 'required',
                'keterangans.*.rincianScreen.*.screen' => 'required',
                'keterangans.*.rincianScreen.*.jumlah_lembar_cetak' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
                'keterangans.*.rincianScreen.*.waste' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            ], [
                'keterangans.*.screen.required' => 'Setidaknya satu data plate harus diisi pada keterangan.',
                'keterangans.*.screen.min' => 'Setidaknya satu data plate harus diisi pada keterangan.',
                'keterangans.*.screen.*.state_screen.required' => 'State pada data plate harus diisi pada keterangan.',
                'keterangans.*.screen.*.jumlah_screen.required' => 'Jumlah Screen harus diisi pada keterangan.',
                'keterangans.*.screen.*.jumlah_screen.numeric' => 'Jumlah Screen harus berupa angka/tidak boleh ada tanda koma(,).',
                'keterangans.*.screen.*.ukuran_screen.required' => 'Ukuran Screen harus diisi pada keterangan.',
                'keterangans.*.screen.*.ukuran_screen.numeric' => 'Ukuran Screen harus berupa angka/tidak boleh ada tanda koma(,).',

                'keterangans.*.rincianScreen.required' => 'Setidaknya satu data rincian screen harus diisi pada keterangan.',
                'keterangans.*.rincianScreen.min' => 'Setidaknya satu data rincian screen harus diisi pada keterangan.',
                'keterangans.*.rincianScreen.*.state.required' => 'State pada rincian screen harus diisi pada keterangan.',
                'keterangans.*.rincianScreen.*.screen.required' => 'Screen harus diisi pada keterangan.',
                'keterangans.*.rincianScreen.*.jumlah_lembar_cetak.required' => 'Jumlah lembar cetak harus diisi pada keterangan.',
                'keterangans.*.rincianScreen.*.jumlah_lembar_cetak.numeric' => 'Jumlah lembar cetak harus berupa angka/tidak boleh ada tanda koma(,).',
                'keterangans.*.rincianScreen.*.waste.required' => 'Waste harus diisi pada keterangan.',
                'keterangans.*.rincianScreen.*.waste.numeric' => 'Waste harus berupa angka/tidak boleh ada tanda koma(,).',
            ]);
        }

        if(isset($this->stateWorkStepPond)){
            $this->validate([        
                'keterangans' => 'required|array|min:1',
                'keterangans.*.pond' => 'required|array|min:1',
                'keterangans.*.pond.*.state_pisau' => 'required',
                'keterangans.*.pond.*.jumlah_pisau' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            ], [
                'keterangans.*.pond.required' => 'Setidaknya satu data pond harus diisi pada keterangan.',
                'keterangans.*.pond.min' => 'Setidaknya satu data pond harus diisi pada keterangan.',
                'keterangans.*.pond.*.state_pisau.required' => 'State pada data pond harus diisi pada keterangan.',
                'keterangans.*.pond.*.jumlah_pisau.required' => 'Jumlah pisau harus diisi pada keterangan.',
                'keterangans.*.pond.*.jumlah_pisau.numeric' => 'Jumlah pisau harus berupa angka/tidak boleh ada tanda koma(,).',              
            ]);
        }

        if(isset($this->stateWorkStepCetakLabel)){
            $this->validate([        
                'keterangans' => 'required|array|min:1',
                'keterangans.*.label' => 'required|array|min:1',
                'keterangans.*.label.*.alat_bahan' => 'required',
                'keterangans.*.label.*.jenis_ukuran' => 'required',
                'keterangans.*.label.*.jumlah' => 'required',
                'keterangans.*.label.*.ketersediaan' => 'required',
            ], [
                'keterangans.*.label.min' => 'Setidaknya satu data pond harus diisi pada keterangan.',
                'keterangans.*.label.*.alat_bahan.required' => 'State pada data pond harus diisi pada keterangan.',
                'keterangans.*.label.*.jenis_ukuran.required' => 'Jenis Ukuran harus diisi pada keterangan.',
                'keterangans.*.label.*.jumlah.required' => 'Jumlah harus diisi pada keterangan.',
                'keterangans.*.label.*.ketersediaan.required' => 'Ketersediaan harus diisi pada keterangan.',
            ]);
        }

        if(isset($this->stateWorkStepCetakLabel)){
            if ($this->layoutSettings) {
                foreach ($this->layoutSettings as $key => $layoutSettingData) {
                    // Buat instance model LayoutSetting
                    $layoutSetting = LayoutSetting::create([
                        'instruction_id' => $this->currentInstructionId,
                        'form_id' => $key,
                        'state' => $layoutSettingData['state'],
                        'panjang_barang_jadi' => $layoutSettingData['panjang_barang_jadi'],
                        'lebar_barang_jadi' => $layoutSettingData['lebar_barang_jadi'],
                        'panjang_bahan_cetak' => $layoutSettingData['panjang_bahan_cetak'],
                        'lebar_bahan_cetak' => $layoutSettingData['lebar_bahan_cetak'],
                        'panjang_naik' => $layoutSettingData['panjang_naik'],
                        'lebar_naik' => $layoutSettingData['lebar_naik'],
                        'lebar_naik' => $layoutSettingData['lebar_naik'],
                        'jarak_panjang' => $layoutSettingData['jarak_panjang'],
                        'jarak_lebar' => $layoutSettingData['jarak_lebar'],
                        'sisi_atas' => $layoutSettingData['sisi_atas'],
                        'sisi_bawah' => $layoutSettingData['sisi_bawah'],
                        'sisi_kiri' => $layoutSettingData['sisi_kiri'],
                        'sisi_kanan' => $layoutSettingData['sisi_kanan'],
                        'sisi_kanan' => $layoutSettingData['sisi_kanan'],
                        'jarak_tambahan_vertical' => $layoutSettingData['jarak_tambahan_vertical'],
                        'jarak_tambahan_horizontal' => $layoutSettingData['jarak_tambahan_horizontal'],
                        'dataURL' => $layoutSettingData['dataURL'],
                        'dataJSON' => $layoutSettingData['dataJSON'],
                    ]);
                }
            }
    
            if ($this->keterangans) {
                foreach ($this->keterangans as $index => $keteranganData) {
                        $keterangan = Keterangan::create([
                            'form_id' => $index,
                            'instruction_id' => $this->currentInstructionId,
                            'notes' => $keteranganData['notes'],
                        ]);
    
                        if($keteranganData['label']){
                            foreach ($keteranganData['label'] as $label) {
                                // Buat instance model KeteranganPlate
                                $keteranganLabel = $keterangan->keteranganLabel()->create([
                                    'instruction_id' => $this->currentInstructionId,
                                    'alat_bahan' => $label['alat_bahan'],
                                    'jenis_ukuran' => $label['jenis_ukuran'],
                                    'jumlah' => $label['jumlah'],
                                    'ketersediaan' => $label['ketersediaan'],
                                    'catatan_label' => $label['catatan_label'],
                                ]);
                            }
                        }
    
                        if($keteranganData['fileRincian']){
                            $InstructionCurrentDataFile = Instruction::find($this->currentInstructionId);
                            $norincian = 1;
                            foreach ($keteranganData['fileRincian'] as $file) {
                                $folder = "public/".$InstructionCurrentDataFile->spk_number."/hitung-bahan";
    
                                $fileName = $InstructionCurrentDataFile->spk_number . '-file-rincian-label-'.$norincian . '.' . $file->getClientOriginalExtension();
                                Storage::putFileAs($folder, $file, $fileName);
                                $norincian ++;
    
                                $keteranganFileRincian= $keterangan->fileRincian()->create([
                                    'instruction_id' => $this->currentInstructionId,
                                    "file_name" => $fileName,
                                    "file_path" => $folder,
                                ]);
                            }
                        }
    
                }
            }
    
            if ($this->layoutBahans) {
                foreach ($this->layoutBahans as $key => $layoutBahanData) {
                    // Buat instance model layoutBahan
                    $layoutBahan = LayoutBahan::create([
                        'instruction_id' => $this->currentInstructionId,
                        'form_id' => $key,
                        'state' => $layoutBahanData['state'],
                        'include_belakang' => $layoutBahanData['include_belakang'],
                        'panjang_plano' => $layoutBahanData['panjang_plano'],
                        'lebar_plano' => $layoutBahanData['lebar_plano'],
                        'panjang_bahan_cetak' => $layoutBahanData['panjang_bahan_cetak'],
                        'lebar_bahan_cetak' => $layoutBahanData['lebar_bahan_cetak'],
                        'jenis_bahan' => $layoutBahanData['jenis_bahan'],
                        'gramasi' => $layoutBahanData['gramasi'],
                        'one_plano' => $layoutBahanData['one_plano'],
                        'sumber_bahan' => $layoutBahanData['sumber_bahan'],
                        'merk_bahan' => $layoutBahanData['merk_bahan'],
                        'supplier' => $layoutBahanData['supplier'],
                        'jumlah_lembar_cetak' => $layoutBahanData['jumlah_lembar_cetak'],
                        'jumlah_incit' => $layoutBahanData['jumlah_incit'],
                        'total_lembar_cetak' => currency_convert($layoutBahanData['total_lembar_cetak']),
                        'harga_bahan' => currency_convert($layoutBahanData['harga_bahan']),
                        'jumlah_bahan' => $layoutBahanData['jumlah_bahan'],
                        'panjang_sisa_bahan' => $layoutBahanData['panjang_sisa_bahan'],
                        'lebar_sisa_bahan' => $layoutBahanData['lebar_sisa_bahan'],
                        'dataURL' => $layoutBahanData['dataURL'],
                        'dataJSON' => $layoutBahanData['dataJSON'],
                    ]);
    
                    if ($layoutBahanData['fileLayoutCustom']) {
                        $InstructionCurrentDataFile = Instruction::find($this->currentInstructionId);
                        $file = $layoutBahanData['fileLayoutCustom'];
                    
                        $folder = "public/" . $InstructionCurrentDataFile->spk_number . "/hitung-bahan";
                        $fileName = $InstructionCurrentDataFile->spk_number . '-file-custom-layout.' . $file->getClientOriginalExtension();
                        Storage::putFileAs($folder, $file, $fileName);
                    
                        $keteranganFileRincian = LayoutBahan::where('id', $layoutBahan->id)->update([
                            "layout_custom_file_name" => $fileName,
                            "layout_custom_path" => $folder,
                        ]);
                    }
    
                }
            }
        }else{
            if ($this->layoutSettings) {
                foreach ($this->layoutSettings as $key => $layoutSettingData) {
                    // Buat instance model LayoutSetting
                    $layoutSetting = LayoutSetting::create([
                        'instruction_id' => $this->currentInstructionId,
                        'form_id' => $key,
                        'state' => $layoutSettingData['state'],
                        'panjang_barang_jadi' => $layoutSettingData['panjang_barang_jadi'],
                        'lebar_barang_jadi' => $layoutSettingData['lebar_barang_jadi'],
                        'panjang_bahan_cetak' => $layoutSettingData['panjang_bahan_cetak'],
                        'lebar_bahan_cetak' => $layoutSettingData['lebar_bahan_cetak'],
                        'panjang_naik' => $layoutSettingData['panjang_naik'],
                        'lebar_naik' => $layoutSettingData['lebar_naik'],
                        'lebar_naik' => $layoutSettingData['lebar_naik'],
                        'jarak_panjang' => $layoutSettingData['jarak_panjang'],
                        'jarak_lebar' => $layoutSettingData['jarak_lebar'],
                        'sisi_atas' => $layoutSettingData['sisi_atas'],
                        'sisi_bawah' => $layoutSettingData['sisi_bawah'],
                        'sisi_kiri' => $layoutSettingData['sisi_kiri'],
                        'sisi_kanan' => $layoutSettingData['sisi_kanan'],
                        'sisi_kanan' => $layoutSettingData['sisi_kanan'],
                        'jarak_tambahan_vertical' => $layoutSettingData['jarak_tambahan_vertical'],
                        'jarak_tambahan_horizontal' => $layoutSettingData['jarak_tambahan_horizontal'],
                        'dataURL' => $layoutSettingData['dataURL'],
                        'dataJSON' => $layoutSettingData['dataJSON'],
                    ]);
                }
            }
    
            if ($this->keterangans) {
                foreach ($this->keterangans as $index => $keteranganData) {
                        $keterangan = Keterangan::create([
                            'form_id' => $index,
                            'instruction_id' => $this->currentInstructionId,
                            'notes' => $keteranganData['notes'],
                        ]);
    
                        if($keteranganData['plate']){
                            foreach ($keteranganData['plate'] as $plate) {
                                // Buat instance model KeteranganPlate
                                $keteranganPlate = $keterangan->keteranganPlate()->create([
                                    'instruction_id' => $this->currentInstructionId,
                                    'state_plate' => $plate['state_plate'],
                                    'jumlah_plate' => $plate['jumlah_plate'],
                                    'ukuran_plate' => $plate['ukuran_plate'],
                                ]);
                            }
                        }
    
                        if($keteranganData['screen']){
                            foreach ($keteranganData['screen'] as $screen) {
                                // Buat instance model KeteranganScreen
                                $keteranganScreen = $keterangan->keteranganScreen()->create([
                                    'instruction_id' => $this->currentInstructionId,
                                    'state_screen' => $screen['state_screen'],
                                    'jumlah_screen' => $screen['jumlah_screen'],
                                    'ukuran_screen' => $screen['ukuran_screen'],
                                ]);
                            }
                        }
                        
                        if($keteranganData['pond']){
                            foreach ($keteranganData['pond'] as $pond) {
                                // Buat instance model KeteranganPisauPond
                                $keteranganPisauPond = $keterangan->keteranganPisauPond()->create([
                                    'instruction_id' => $this->currentInstructionId,
                                    'state_pisau' => $pond['state_pisau'],
                                    'jumlah_pisau' => $pond['jumlah_pisau'],
                                ]);
                            }
                        }
    
                        if($keteranganData['rincianPlate']){
                            foreach ($keteranganData['rincianPlate'] as $rincianPlate) {
                                // Buat instance model RincianPlate
                                $rincianPlate = $keterangan->rincianPlate()->create([
                                    'instruction_id' => $this->currentInstructionId,
                                    'state' => $rincianPlate['state'],
                                    'plate' => $rincianPlate['plate'],
                                    'jumlah_lembar_cetak' => $rincianPlate['jumlah_lembar_cetak'],
                                    'waste' => $rincianPlate['waste'],
                                ]);
                            }
                        }
    
                        if($keteranganData['rincianScreen']){
                            foreach ($keteranganData['rincianScreen'] as $rincianScreen) {
                                // Buat instance model RincianScreen
                                $rincianScreen = $keterangan->rincianScreen()->create([
                                    'instruction_id' => $this->currentInstructionId,
                                    'state' => $rincianScreen['state'],
                                    'screen' => $rincianScreen['screen'],
                                    'jumlah_lembar_cetak' => $rincianScreen['jumlah_lembar_cetak'],
                                    'waste' => $rincianScreen['waste'],
                                ]);
                            }
                        }
    
                        if($keteranganData['fileRincian']){
                            $InstructionCurrentDataFile = Instruction::find($this->currentInstructionId);
                            $norincian = 1;
                            foreach ($keteranganData['fileRincian'] as $file) {
                                $folder = "public/".$InstructionCurrentDataFile->spk_number."/hitung-bahan";
    
                                $fileName = $InstructionCurrentDataFile->spk_number . '-file-rincian-'.$norincian . '.' . $file->getClientOriginalExtension();
                                Storage::putFileAs($folder, $file, $fileName);
                                $norincian ++;
    
                                $keteranganFileRincian= $keterangan->fileRincian()->create([
                                    'instruction_id' => $this->currentInstructionId,
                                    "file_name" => $fileName,
                                    "file_path" => $folder,
                                ]);
                            }
                        }
    
                }
            }
    
            if ($this->layoutBahans) {
                foreach ($this->layoutBahans as $key => $layoutBahanData) {
                    // Buat instance model layoutBahan
                    $layoutBahan = LayoutBahan::create([
                        'instruction_id' => $this->currentInstructionId,
                        'form_id' => $key,
                        'state' => $layoutBahanData['state'],
                        'include_belakang' => $layoutBahanData['include_belakang'],
                        'panjang_plano' => $layoutBahanData['panjang_plano'],
                        'lebar_plano' => $layoutBahanData['lebar_plano'],
                        'panjang_bahan_cetak' => $layoutBahanData['panjang_bahan_cetak'],
                        'lebar_bahan_cetak' => $layoutBahanData['lebar_bahan_cetak'],
                        'jenis_bahan' => $layoutBahanData['jenis_bahan'],
                        'gramasi' => $layoutBahanData['gramasi'],
                        'one_plano' => $layoutBahanData['one_plano'],
                        'sumber_bahan' => $layoutBahanData['sumber_bahan'],
                        'merk_bahan' => $layoutBahanData['merk_bahan'],
                        'supplier' => $layoutBahanData['supplier'],
                        'jumlah_lembar_cetak' => $layoutBahanData['jumlah_lembar_cetak'],
                        'jumlah_incit' => $layoutBahanData['jumlah_incit'],
                        'total_lembar_cetak' => currency_convert($layoutBahanData['total_lembar_cetak']),
                        'harga_bahan' => currency_convert($layoutBahanData['harga_bahan']),
                        'jumlah_bahan' => $layoutBahanData['jumlah_bahan'],
                        'panjang_sisa_bahan' => $layoutBahanData['panjang_sisa_bahan'],
                        'lebar_sisa_bahan' => $layoutBahanData['lebar_sisa_bahan'],
                        'dataURL' => $layoutBahanData['dataURL'],
                        'dataJSON' => $layoutBahanData['dataJSON'],
                    ]);
    
                    if ($layoutBahanData['fileLayoutCustom']) {
                        $InstructionCurrentDataFile = Instruction::find($this->currentInstructionId);
                        $file = $layoutBahanData['fileLayoutCustom'];
                    
                        $folder = "public/" . $InstructionCurrentDataFile->spk_number . "/hitung-bahan";
                        $fileName = $InstructionCurrentDataFile->spk_number . '-file-custom-layout.' . $file->getClientOriginalExtension();
                        Storage::putFileAs($folder, $file, $fileName);
                    
                        $keteranganFileRincian = LayoutBahan::where('id', $layoutBahan->id)->update([
                            "layout_custom_file_name" => $fileName,
                            "layout_custom_path" => $folder,
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

        // return redirect()->route('hitungBahan.createFormHitungBahan');
        return redirect()->back();
    }

    public function modalInstructionDetails($instructionId)
    {
        $this->selectedInstruction = Instruction::find($instructionId);
        $this->selectedWorkStep = WorkStep::where('instruction_id', $instructionId)->with('workStepList', 'user', 'machine')->get();
        $this->selectedFileContoh = Files::where('instruction_id', $instructionId)->where('type_file', 'contoh')->get();
        $this->selectedFileArsip = Files::where('instruction_id', $instructionId)->where('type_file', 'arsip')->get();
        $this->selectedFileAccounting = Files::where('instruction_id', $instructionId)->where('type_file', 'accounting')->get();
        $this->selectedFileLayout = Files::where('instruction_id', $instructionId)->where('type_file', 'layout')->get();
        $this->selectedFileSample = Files::where('instruction_id', $instructionId)->where('type_file', 'sample')->get();

        $this->dispatchBrowserEvent('show-detail-instruction-modal');
    }
}
