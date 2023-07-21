<?php

namespace App\Http\Livewire\HitungBahan\Component;

use Carbon\Carbon;
use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Keterangan;
use App\Models\FileRincian;
use App\Models\Instruction;
use App\Models\LayoutBahan;
use App\Models\LayoutSetting;
use Livewire\WithFileUploads;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Storage;

class CreateFormHitungBahanIndex extends Component
{
    use WithFileUploads;
    public $filerincian = [];
    public $filerincianlast = [];
    public $layoutSettings = [];
    public $layoutBahans = [];
    public $keterangans = [];
    public $currentInstructionId;
    public $instructionData;
    public $contohData;
    public $note;
    public $notereject;
    public $notes = [];
    public $workSteps;

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

    public $selectedInstructionParent;
    public $selectedWorkStepParent;
    public $selectedFileContohParent;
    public $selectedFileArsipParent;
    public $selectedFileAccountingParent;
    public $selectedFileLayoutParent;
    public $selectedFileSampleParent;

    public $selectedInstructionChild;

    public $selectedGroupParent;
    public $selectedGroupChild;

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
            'fileRincianLast' => [],
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

    public function addEmptyNote()
    {
        $this->notes[] = '';
    }

    public function removeNote($index)
    {
        unset($this->notes[$index]);
        $this->notes = array_values($this->notes);
    }

    public function mount($instructionId)
    {
        $this->currentInstructionId = $instructionId;
        $cekGroup = Instruction::where('id', $instructionId)
            ->whereNotNull('group_id')
            ->whereNotNull('group_priority')
            ->first();

        if (!$cekGroup){
            $this->instructionData = Instruction::where('id', $instructionId)->get();
        }else{
            $instructionGroup = Instruction::where('group_id', $cekGroup->group_id)->get();
            $this->instructionData = Instruction::whereIn('id', $instructionGroup->pluck('id'))->get();
        }

        $this->contohData = Files::where('instruction_id', $instructionId)->where('type_file', 'contoh')->get();

        $this->stateWorkStepPlate = WorkStep::where('instruction_id', $instructionId)->where('work_step_list_id', 7)->first();
        $this->stateWorkStepSablon = WorkStep::where('instruction_id', $instructionId)->where('work_step_list_id', 23)->first();
        $this->stateWorkStepPond = WorkStep::where('instruction_id', $instructionId)->where('work_step_list_id', 24)->first();
        $this->stateWorkStepCetakLabel = WorkStep::where('instruction_id', $instructionId)->where('work_step_list_id', 12)->first();
        $this->workSteps = WorkStep::where('instruction_id', $instructionId)->with('workStepList')->get();

        $this->note = Catatan::where('instruction_id', $instructionId)->where('kategori', 'catatan')->where('tujuan', 5)->get();
        $this->notereject = Catatan::where('instruction_id', $instructionId)->where('kategori', 'reject')->where('tujuan', 5)->get();
        
        $layoutSettingData = LayoutSetting::where('instruction_id', $this->currentInstructionId)->get();
        foreach($layoutSettingData as $dataLayoutSetting){
            $this->layoutSettings[] = [
                'panjang_barang_jadi' => $dataLayoutSetting['panjang_barang_jadi'],
                'lebar_barang_jadi' => $dataLayoutSetting['lebar_barang_jadi'],
                'panjang_bahan_cetak' => $dataLayoutSetting['panjang_bahan_cetak'],
                'lebar_bahan_cetak' => $dataLayoutSetting['lebar_bahan_cetak'],
                'dataURL' => $dataLayoutSetting['dataURL'],
                'dataJSON' => $dataLayoutSetting['dataJSON'],
                'state' => $dataLayoutSetting['state'],
                'panjang_naik' => $dataLayoutSetting['panjang_naik'],
                'lebar_naik' => $dataLayoutSetting['lebar_naik'],
                'jarak_panjang' => $dataLayoutSetting['jarak_panjang'],
                'jarak_lebar' => $dataLayoutSetting['jarak_lebar'],
                'sisi_atas' => $dataLayoutSetting['sisi_atas'],
                'sisi_bawah' => $dataLayoutSetting['sisi_bawah'],
                'sisi_kiri' => $dataLayoutSetting['sisi_kiri'],
                'sisi_kanan' => $dataLayoutSetting['sisi_kanan'],
                'jarak_tambahan_vertical' => $dataLayoutSetting['jarak_tambahan_vertical'],
                'jarak_tambahan_horizontal' => $dataLayoutSetting['jarak_tambahan_horizontal'],
            ];
        }
       
        $keteranganData = Keterangan::where('instruction_id', $this->currentInstructionId)
            ->with('keteranganPlate', 'keteranganPisauPond', 'keteranganScreen', 'rincianPlate', 'rincianScreen', 'fileRincian')
            ->get();

        foreach ($keteranganData as $dataKeterangan) {
            $keterangan = [
                'fileRincian' => [],
                'notes' => $dataKeterangan['notes'],
                'plate' => [],
                'screen' => [],
                'pond' => [],
                'rincianPlate' => [],
                'rincianScreen' => [],
                'fileRincianLast' => [],
            ];

            if (isset($dataKeterangan['keteranganPlate'])) {
                foreach ($dataKeterangan['keteranganPlate'] as $dataPlate) {
                    $keterangan['plate'][] = [
                        "state_plate" => $dataPlate['state_plate'],
                        "jumlah_plate" => $dataPlate['jumlah_plate'],
                        "ukuran_plate" => $dataPlate['ukuran_plate']
                    ];
                }
            }

            if (isset($dataKeterangan['keteranganScreen'])) {
                foreach ($dataKeterangan['keteranganScreen'] as $dataScreen) {
                    $keterangan['screen'][] = [
                        "state_screen" => $dataScreen['state_screen'],
                        "jumlah_screen" => $dataScreen['jumlah_screen'],
                        "ukuran_screen" => $dataScreen['ukuran_screen']
                    ];
                }
            }

            if (isset($dataKeterangan['keteranganPisauPond'])) {
                foreach ($dataKeterangan['keteranganPisauPond'] as $dataPisau) {
                    $keterangan['pond'][] = [
                        "state_pisau" => $dataPisau['state_pisau'],
                        "jumlah_pisau" => $dataPisau['jumlah_pisau'],
                    ];
                }
            }

            if (isset($dataKeterangan['rincianPlate'])) {
                foreach ($dataKeterangan['rincianPlate'] as $dataRincianPlate) {
                    $keterangan['rincianPlate'][] = [
                        "state" => $dataRincianPlate['state'],
                        "plate" => $dataRincianPlate['plate'],
                        "jumlah_lembar_cetak" => $dataRincianPlate['jumlah_lembar_cetak'],
                        "waste" => $dataRincianPlate['waste'],
                    ];
                }
            }

            if (isset($dataKeterangan['rincianScreen'])) {
                foreach ($dataKeterangan['rincianScreen'] as $dataRincianScreen) {
                    $keterangan['rincianScreen'][] = [
                        "state" => $dataRincianScreen['state'],
                        "screen" => $dataRincianScreen['screen'],
                        "jumlah_lembar_cetak" => $dataRincianScreen['jumlah_lembar_cetak'],
                        "waste" => $dataRincianScreen['waste'],
                    ];
                }
            }

            if (isset($dataKeterangan['fileRincian'])) {
                foreach ($dataKeterangan['fileRincian'] as $dataFileRincian) {
                    $keterangan['fileRincianLast'][] = [
                        "file_name" => $dataFileRincian['file_name'],
                        "file_path" => $dataFileRincian['file_path'],
                    ];
                }
            }

            $this->keterangans[] = $keterangan;
        }
    
        $layoutBahanData = LayoutBahan::where('instruction_id', $this->currentInstructionId)->get();
        foreach($layoutBahanData as $dataLayoutBahan){
            $this->layoutBahans[] = [
                'dataURL' => $dataLayoutBahan['dataURL'],
                'dataJSON' => $dataLayoutBahan['dataJSON'],
                'state' => $dataLayoutBahan['state'],
                'panjang_plano' => $dataLayoutBahan['panjang_plano'],
                'lebar_plano' => $dataLayoutBahan['lebar_plano'],
                'panjang_bahan_cetak' => $dataLayoutBahan['panjang_bahan_cetak'],
                'lebar_bahan_cetak' => $dataLayoutBahan['lebar_bahan_cetak'],
                'jenis_bahan' => $dataLayoutBahan['jenis_bahan'],
                'gramasi' => $dataLayoutBahan['gramasi'],
                'one_plano' => $dataLayoutBahan['one_plano'],
                'sumber_bahan' => $dataLayoutBahan['sumber_bahan'],
                'merk_bahan' => $dataLayoutBahan['merk_bahan'],
                'supplier' => $dataLayoutBahan['supplier'],
                'jumlah_lembar_cetak' => $dataLayoutBahan['jumlah_lembar_cetak'],
                'jumlah_incit' => $dataLayoutBahan['jumlah_incit'],
                'total_lembar_cetak' => $dataLayoutBahan['total_lembar_cetak'],
                'harga_bahan' => $dataLayoutBahan['harga_bahan'],
                'jumlah_bahan' => $dataLayoutBahan['jumlah_bahan'],
                'panjang_sisa_bahan' => $dataLayoutBahan['panjang_sisa_bahan'],
                'lebar_sisa_bahan' => $dataLayoutBahan['lebar_sisa_bahan'],
                'layout_custom_file_name' => $dataLayoutBahan['layout_custom_file_name'],
                'layout_custom_path' => $dataLayoutBahan['layout_custom_path'],
                'include_belakang' => $dataLayoutBahan['include_belakang'],
                'fileLayoutCustom' => '',
            ];
        }
        
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
                'fileRincianLast' => [],
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
                'layout_custom_file_name' => '',
                'layout_custom_path' => '',
            ];
        }
    }

    public function render()
    {
        return view('livewire.hitung-bahan.component.create-form-hitung-bahan-index')->extends('layouts.app')
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

        $checkLayoutSetting = LayoutSetting::where('instruction_id', $this->currentInstructionId)->delete();
        $checkKeterangan = Keterangan::where('instruction_id', $this->currentInstructionId)->delete();
        $checkLayoutBahan = LayoutBahan::where('instruction_id', $this->currentInstructionId)->delete();


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

                        if($keteranganData['fileRincianLast']){
                            $InstructionCurrentDataFile = Instruction::find($this->currentInstructionId);
                            $norincian = 1;
                            foreach ($keteranganData['fileRincianLast'] as $file) {
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
        
        if($this->notes){
            foreach ($this->notes as $input) {
                $catatan = Catatan::create([
                    'tujuan' => $input['tujuan'],
                    'catatan' => $input['catatan'],
                    'kategori' => 'catatan',
                    'instruction_id' => $this->currentInstructionId,
                    'user_id' => Auth()->user()->id,
                ]);
            }
        }

        $updateTask = WorkStep::where('instruction_id', $this->currentInstructionId)
                ->where('work_step_list_id', 5)
                ->first();
            
            if ($updateTask) {
                $updateTask->update([
                    'state_task' => 'Complete',
                    'status_task' => 'Complete',
                    'selesai' => Carbon::now()->toDateTimeString(),
                ]);
            
                $updateNextStep = WorkStep::where('instruction_id', $this->currentInstructionId)
                    ->where('step', $updateTask->step + 1)
                    ->first();
            
                if ($updateNextStep) {
                    $updateNextStep->update([
                        'state_task' => 'Running',
                        'status_task' => 'Pending Approved',
                        'schedule_date' => Carbon::now(),
                    ]);

                    $updateStatusJob = WorkStep::where('instruction_id', $this->currentInstructionId)->update([
                        'status_id' => 1,
                        'job_id' => $updateNextStep->work_step_list_id,
                    ]);
                }
            }

            $this->messageSent(['createdMessage' => 'info', 'selectedConversation' => 'SPK selesai Hitung Bahan', 'instruction_id' => $this->currentInstructionId, 'receiverUser' => 8]);
            $this->messageSent(['createdMessage' => 'info', 'selectedConversation' => 'SPK selesai Hitung Bahan', 'instruction_id' => $this->currentInstructionId, 'receiverUser' => 58]);
            $this->messageSent(['createdMessage' => 'info', 'selectedConversation' => 'SPK selesai Hitung Bahan', 'instruction_id' => $this->currentInstructionId, 'receiverUser' => 59]);


        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Create Instruksi Kerja',
            'message' => 'Berhasil membuat instruksi kerja',
        ]);

        session()->flash('success', 'Instruksi kerja berhasil disimpan.');

        return redirect()->route('hitungBahan.dashboard');
    }

    public function deleteFileRincian($fileName, $key, $keteranganIndex)
    {
        $file = FileRincian::where('file_name', $fileName)->first();

        if ($file) {
            Storage::delete($file->file_path.'/'.$file->file_name);
            $file->delete();
            // Hapus juga entry dari array fileRincian di property $keterangans menggunakan index
            if (isset($this->keterangans[$keteranganIndex]['fileRincianLast'][$key])) {
                unset($this->keterangans[$keteranganIndex]['fileRincianLast'][$key]);
            }
        }
    }

    public function deleteFileCustomLayout($fileName, $indexBahan)
    {
        $file = LayoutBahan::where('layout_custom_file_name', $fileName)->first();

        if ($file) {
            Storage::delete($file->layout_custom_path.'/'.$file->layout_custom_file_name);
            $file->update([
                'layout_custom_file_name' => null,
                'layout_custom_path' => null,
            ]);
            // Hapus juga entry dari array fileRincian di property $keterangans menggunakan index
            if (isset($this->layoutBahans[$indexBahan]['layout_custom_file_name_last']) && isset($this->layoutBahans[$indexBahan]['layout_custom_path_last'])) {
                unset($this->layoutBahans[$indexBahan]['layout_custom_file_name_last']);
                unset($this->layoutBahans[$indexBahan]['layout_custom_path_last']);
            }
        }
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

    public function modalInstructionDetailsGroup($groupId)
    {
        $this->selectedGroupParent = Instruction::where('group_id', $groupId)->where('group_priority', 'parent')->first();
        $this->selectedGroupChild = Instruction::where('group_id', $groupId)->where('group_priority', 'child')->get();

        $this->selectedInstructionParent = Instruction::find($this->selectedGroupParent->id);
        $this->selectedWorkStepParent = WorkStep::where('instruction_id', $this->selectedGroupParent->id)->with('workStepList', 'user', 'machine')->get();
        $this->selectedFileContohParent = Files::where('instruction_id', $this->selectedGroupParent->id)->where('type_file', 'contoh')->get();
        $this->selectedFileArsipParent = Files::where('instruction_id', $this->selectedGroupParent->id)->where('type_file', 'arsip')->get();
        $this->selectedFileAccountingParent = Files::where('instruction_id', $this->selectedGroupParent->id)->where('type_file', 'accounting')->get();
        $this->selectedFileLayoutParent = Files::where('instruction_id', $this->selectedGroupParent->id)->where('type_file', 'layout')->get();
        $this->selectedFileSampleParent = Files::where('instruction_id', $this->selectedGroupParent->id)->where('type_file', 'sample')->get();

        $this->selectedInstructionChild = Instruction::where('group_id', $groupId)->where('group_priority', 'child')->with('workstep', 'workstep.workStepList', 'workstep.user', 'workstep.machine', 'fileArsip')->get();

        $this->dispatchBrowserEvent('show-detail-instruction-modal-group');
    }

    public function messageSent($arguments)
    {
        $createdMessage = $arguments['createdMessage'];
        $selectedConversation = $arguments['selectedConversation'];
        $receiverUser = $arguments['receiverUser'];
        $instruction_id = $arguments['instruction_id'];

        broadcast(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, $receiverUser));
    }
}
