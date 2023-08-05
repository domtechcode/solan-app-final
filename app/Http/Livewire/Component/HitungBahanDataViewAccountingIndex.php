<?php

namespace App\Http\Livewire\Component;

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
use Illuminate\Support\Facades\Storage;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Html;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class HitungBahanDataViewAccountingIndex extends Component
{
    use WithFileUploads;
    public $filerincian = [];
    public $layoutSettings = [];
    public $layoutBahans = [];
    public $keterangans = [];
    public $currentInstructionId;
    public $currentWorkStepId;
    public $instructionData;
    public $contohData;
    public $note;
    public $notereject;
    public $noterevisi;
    public $notes = [];
    public $workSteps;
    public $fileCheckerData = [];

    public $stateWorkStepPlate;
    public $stateWorkStepSablon;
    public $stateWorkStepPond;
    public $stateWorkStepCetakLabel;
    public $stateWorkStepFoil;
    public $stateWorkStepEmbossDeboss;

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

    public $filePaths;
    public $htmlOutputs;

    public $totalPlate;
    public $totalLembarCetakPlate;
    public $totalWastePlate;

    public $totalScreen;
    public $totalLembarCetakScreen;
    public $totalWasteScreen;
    
    public function mount($instructionId, $workStepId)
    {
        $this->currentInstructionId = $instructionId;
        $this->currentWorkStepId = $workStepId;

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
        $this->stateWorkStepFoil = WorkStep::where('instruction_id', $instructionId)->where('work_step_list_id', 28)->first();
        $this->stateWorkStepEmbossDeboss = WorkStep::where('instruction_id', $instructionId)->whereIn('work_step_list_id', [25, 26])->first();

        $this->workSteps = WorkStep::where('instruction_id', $instructionId)->with('workStepList')->get();

        $dataWorkStep = WorkStep::find($this->currentWorkStepId);

        $this->note = Catatan::where('instruction_id', $instructionId)->where('kategori', 'catatan')->where('tujuan', $dataWorkStep->work_step_list_id)->get();
        $this->notereject = Catatan::where('instruction_id', $instructionId)->where('kategori', 'reject')->where('tujuan', $dataWorkStep->work_step_list_id)->get();
        $this->noterevisi = Catatan::where('instruction_id', $instructionId)->where('kategori', 'revisi')->where('tujuan', $dataWorkStep->work_step_list_id)->get();

        $dataNotes = Catatan::where('instruction_id', $instructionId)->where('kategori', 'catatan')->where('tujuan', $dataWorkStep->work_step_list_id)->get();

        $this->notes = [];

        foreach($dataNotes as $note) {
            $this->notes[] = [
                "tujuan" => $note->tujuan,
                "catatan" => $note->catatan,
            ];
        }

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
        ->with('keteranganPlate', 'keteranganPisauPond', 'keteranganScreen', 'keteranganFoil', 'keteranganMatress', 'rincianPlate', 'rincianPlate.warnaPlate', 'rincianScreen', 'fileRincian')
        ->get();
        
        $this->totalPlate = 0;
        $this->totalLembarCetakPlate = 0;
        $this->totalWastePlate = 0;
        $this->totalScreen = 0;
        $this->totalLembarCetakScreen = 0;
        $this->totalWasteScreen = 0;
        foreach($keteranganData as $dataKeterangan){
            $keterangan = [
                'fileRincian' => [],
                'notes' => $dataKeterangan['notes'],
                'plate' => [
                    [
                        "state_plate" => "baru",
                        "jumlah_plate" => null,
                        "ukuran_plate" => null,
                    ],
                    [
                        "state_plate" => "repeat",
                        "jumlah_plate" => null,
                        "ukuran_plate" => null,
                    ],
                    [
                        "state_plate" => "sample",
                        "jumlah_plate" => null,
                        "ukuran_plate" => null,
                    ],
                ],
                'pond' => [
                    [
                        "state_pisau" => "baru",
                        "jumlah_pisau" => null,
                    ],
                    [
                        "state_pisau" => "repeat",
                        "jumlah_pisau" => null,
                    ],
                    [
                        "state_pisau" => "sample",
                        "jumlah_pisau" => null,
                    ],
                ],
                'screen' => [
                    [
                        "state_screen" => "baru",
                        "jumlah_screen" => null,
                        "ukuran_screen" => null,
                    ],
                    [
                        "state_screen" => "repeat",
                        "jumlah_screen" => null,
                        "ukuran_screen" => null,
                    ],
                    [
                        "state_screen" => "sample",
                        "jumlah_screen" => null,
                        "ukuran_screen" => null,
                    ],
                ],
                'foil' => [
                    [
                        "state_foil" => "baru",
                        "jumlah_foil" => null,
                    ],
                    [
                        "state_foil" => "repeat",
                        "jumlah_foil" => null,
                    ],
                    [
                        "state_foil" => "sample",
                        "jumlah_foil" => null,
                    ],
                ],
                'matress' => [
                    [
                        "state_matress" => "baru",
                        "jumlah_matress" => null,
                    ],
                    [
                        "state_matress" => "repeat",
                        "jumlah_matress" => null,
                    ],
                    [
                        "state_matress" => "sample",
                        "jumlah_matress" => null,
                    ],
                ],

            ];

            if (isset($dataKeterangan['rincianPlate'])) {
                foreach ($dataKeterangan['rincianPlate'] as $dataRincianPlate) {
                    $dataWarna = []; // Initialize dataWarna array for each rincianPlate

                    if ($dataRincianPlate['warnaPlate']) {
                        foreach ($dataRincianPlate['warnaPlate'] as $warna) {
                            // Use unique keys for each item in dataWarna array
                            $dataWarna[] = [
                                'warna' => $warna['warna'],
                                'keterangan' => $warna['keterangan'],
                            ];
                        }
                    }

                    // Add a default entry for "rincianWarna" when WarnaPlate is empty or contains no data
                    if (empty($dataWarna)) {
                        $dataWarna[] = [
                            'warna' => null,
                            'keterangan' => null,
                        ];
                    }

                    if ($dataRincianPlate['status'] != 'Deleted by Setting') {
                        $keterangan['rincianPlate'][] = [
                            "state" => $dataRincianPlate['state'],
                            "plate" => $dataRincianPlate['plate'],
                            "jumlah_lembar_cetak" => $dataRincianPlate['jumlah_lembar_cetak'],
                            "waste" => $dataRincianPlate['waste'],
                            "name" => $dataRincianPlate['name'],
                            "rincianWarna" => $dataWarna,
                        ];
                        $this->totalLembarCetakPlate += $dataRincianPlate['jumlah_lembar_cetak'];
                        $this->totalWastePlate += $dataRincianPlate['waste'];
                    }

                    
                }
            }

            if (isset($dataKeterangan['keteranganPlate'])) {
                // Convert object to array
                $dataPlateArray = json_decode(json_encode($dataKeterangan['keteranganPlate']), true);
        
                // Populate the Screen array with the actual data
                foreach ($dataPlateArray as $dataPlate) {
                    $statePlate = $dataPlate['state_plate'];
        
                    // Check if the state_screen is one of the expected states
                    if ($statePlate == 'baru' || $statePlate == 'repeat' || $statePlate == 'sample') {
                        // Find the index of the current state_screen in the $keterangan['foil'] array
                        $index = array_search($statePlate, array_column($keterangan['plate'], 'state_plate'));
        
                        // Set jumlah_plate based on the state
                        if ($index !== false) {
                            $keterangan['plate'][$index]['jumlah_plate'] = $dataPlate['jumlah_plate'];
                            $keterangan['plate'][$index]['ukuran_plate'] = $dataPlate['ukuran_plate'];

                            $this->totalPlate += $keterangan['plate'][$index]['jumlah_plate'] = $dataPlate['jumlah_plate'];
                        }
                    }
                }
        
                // Set to null if any of 'baru', 'repeat', or 'sample' is missing in dataFoil
                foreach ($keterangan['plate'] as &$plateData) {
                    if (!in_array($plateData['state_plate'], array_column($dataPlateArray, 'state_plate'))) {
                        $plateData['state_plate'] = null;
                        $plateData['jumlah_plate'] = null;
                        $plateData['ukuran_plate'] = null;
                    }
                }
            }

            if (isset($dataKeterangan['keteranganScreen'])) {
                // Convert object to array
                $dataScreenArray = json_decode(json_encode($dataKeterangan['keteranganScreen']), true);
        
                // Populate the Screen array with the actual data
                foreach ($dataScreenArray as $dataScreen) {
                    $stateScreen = $dataScreen['state_screen'];
        
                    // Check if the state_screen is one of the expected states
                    if ($stateScreen == 'baru' || $stateScreen == 'repeat' || $stateScreen == 'sample') {
                        // Find the index of the current state_screen in the $keterangan['foil'] array
                        $index = array_search($stateScreen, array_column($keterangan['screen'], 'state_screen'));
        
                        // Set jumlah_screen based on the state
                        if ($index !== false) {
                            $keterangan['screen'][$index]['jumlah_screen'] = $dataScreen['jumlah_screen'];
                            $keterangan['screen'][$index]['ukuran_screen'] = $dataScreen['ukuran_screen'];

                            $this->totalScreen += $keterangan['screen'][$index]['jumlah_screen'] = $dataPlate['jumlah_screen'];
                        }
                    }
                }
        
                // Set to null if any of 'baru', 'repeat', or 'sample' is missing in dataFoil
                foreach ($keterangan['screen'] as &$screenData) {
                    if (!in_array($screenData['state_screen'], array_column($dataScreenArray, 'state_screen'))) {
                        $screenData['state_screen'] = null;
                        $screenData['jumlah_screen'] = null;
                        $screenData['ukuran_screen'] = null;
                    }
                }
            }

            if (isset($dataKeterangan['keteranganPisauPond'])) {
                // Convert object to array
                $dataPisauPondArray = json_decode(json_encode($dataKeterangan['keteranganPisauPond']), true);
        
                // Populate the PisauPond array with the actual data
                foreach ($dataPisauPondArray as $dataPisauPond) {
                    $statePisauPond = $dataPisauPond['state_pisau'];
        
                    // Check if the state_pisau is one of the expected states
                    if ($statePisauPond == 'baru' || $statePisauPond == 'repeat' || $statePisauPond == 'sample') {
                        // Find the index of the current state_pisau in the $keterangan['foil'] array
                        $index = array_search($statePisauPond, array_column($keterangan['pond'], 'state_pisau'));
        
                        // Set jumlah_pisau based on the state
                        if ($index !== false) {
                            $keterangan['pond'][$index]['jumlah_pisau'] = $dataPisauPond['jumlah_pisau'];
                        }
                    }
                }
        
                // Set to null if any of 'baru', 'repeat', or 'sample' is missing in dataFoil
                foreach ($keterangan['pond'] as &$pondData) {
                    if (!in_array($pondData['state_pisau'], array_column($dataPisauPondArray, 'state_pisau'))) {
                        $pondData['state_pisau'] = null;
                        $pondData['jumlah_pisau'] = null;
                    }
                }
            }

            if (isset($dataKeterangan['keteranganFoil'])) {
                // Convert object to array
                $dataFoilArray = json_decode(json_encode($dataKeterangan['keteranganFoil']), true);
        
                // Populate the foil array with the actual data
                foreach ($dataFoilArray as $dataFoil) {
                    $stateFoil = $dataFoil['state_foil'];
        
                    // Check if the state_foil is one of the expected states
                    if ($stateFoil == 'baru' || $stateFoil == 'repeat' || $stateFoil == 'sample') {
                        // Find the index of the current state_foil in the $keterangan['foil'] array
                        $index = array_search($stateFoil, array_column($keterangan['foil'], 'state_foil'));
        
                        // Set jumlah_foil based on the state
                        if ($index !== false) {
                            $keterangan['foil'][$index]['jumlah_foil'] = $dataFoil['jumlah_foil'];
                        }
                    }
                }
        
                // Set to null if any of 'baru', 'repeat', or 'sample' is missing in dataFoil
                foreach ($keterangan['foil'] as &$foilData) {
                    if (!in_array($foilData['state_foil'], array_column($dataFoilArray, 'state_foil'))) {
                        $foilData['state_foil'] = null;
                        $foilData['jumlah_foil'] = null;
                    }
                }
            }

            if (isset($dataKeterangan['keteranganMatress'])) {
                // Convert object to array
                $dataMatressArray = json_decode(json_encode($dataKeterangan['keteranganMatress']), true);
        
                // Populate the foil array with the actual data
                foreach ($dataMatressArray as $dataMatress) {
                    $stateMatress = $dataMatress['state_matress'];
        
                    // Check if the state_foil is one of the expected states
                    if ($stateMatress == 'baru' || $stateMatress == 'repeat' || $stateMatress == 'sample') {
                        // Find the index of the current state_foil in the $keterangan['foil'] array
                        $index = array_search($stateMatress, array_column($keterangan['matress'], 'state_matress'));
        
                        // Set jumlah_matress based on the state
                        if ($index !== false) {
                            $keterangan['matress'][$index]['jumlah_matress'] = $dataMatress['jumlah_matress'];
                        }
                    }
                }
        
                // Set to null if any of 'baru', 'repeat', or 'sample' is missing in dataMatress
                foreach ($keterangan['matress'] as &$matressData) {
                    if (!in_array($matressData['state_matress'], array_column($dataMatressArray, 'state_matress'))) {
                        $matressData['state_matress'] = null;
                        $matressData['jumlah_matress'] = null;
                    }
                }
            }


            foreach($dataKeterangan['rincianScreen'] as $dataRincianScreen){
                $keterangan['rincianScreen'][] = [
                    "state" => $dataRincianScreen['state'],
                    "screen" => $dataRincianScreen['screen'],
                    "jumlah_lembar_cetak" => $dataRincianScreen['jumlah_lembar_cetak'],
                    "waste" => $dataRincianScreen['waste'],
                ];
                $this->totalLembarCetakScreen += $dataRincianScreen['jumlah_lembar_cetak'];
                $this->totalWasteScreen += $dataRincianScreen['waste'];
            }

            foreach($dataKeterangan['fileRincian'] as $dataFileRincian){
                $keterangan['fileRincian'][] = [
                    "file_name" => $dataFileRincian['file_name'],
                    "file_path" => $dataFileRincian['file_path'],
                ];

                $filePath = storage_path('app/' . $dataFileRincian['file_path'] . '/' . $dataFileRincian['file_name']);
                $this->filePaths[] = $filePath;
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
                'total_lembar_cetak' => currency_idr($dataLayoutBahan['total_lembar_cetak']),
                'harga_bahan' => currency_idr($dataLayoutBahan['harga_bahan']),
                'jumlah_bahan' => $dataLayoutBahan['jumlah_bahan'],
                'panjang_sisa_bahan' => $dataLayoutBahan['panjang_sisa_bahan'],
                'lebar_sisa_bahan' => $dataLayoutBahan['lebar_sisa_bahan'],
                'layout_custom_file_name' => $dataLayoutBahan['layout_custom_file_name'],
                'layout_custom_path' => $dataLayoutBahan['layout_custom_path'],
                'include_belakang' => $dataLayoutBahan['include_belakang'],
                'fileLayoutCustom' => '',
            ];
        }

        $this->fileCheckerData = Files::where('instruction_id', $instructionId)->where('type_file', 'Approved Checker')->get();
        
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
                'foil' => [],
                'matress' => [],
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
                'layout_custom_file_name' => '',
                'layout_custom_path' => '',
            ];
        }
        
        if (empty($this->filePaths)){
            $this->filePaths[] = '';
        }

        if(!empty($this->filePaths)){
            $this->loadExcel();
        }
    }

    public function render()
    {
        return view('livewire.component.hitung-bahan-data-view-accounting-index')->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Form Edit Hitung Bahan']);
    }

    public function loadExcel()
    {
        $this->htmlOutputs = [];
        if(isset($this->filePaths)){
            foreach ($this->filePaths as $filePath) {
                if (file_exists($filePath)) {
                    $inputFileType = IOFactory::identify($filePath);
                    $reader = IOFactory::createReader($inputFileType);
                    $spreadsheet = $reader->load($filePath);
                    $writer = IOFactory::createWriter($spreadsheet, 'Html');
                    ob_start();
                    $writer->save('php://output');
                    $this->htmlOutputs[] = ob_get_clean();
                } else {
                    // File tidak ditemukan, berikan pesan kesalahan atau lakukan tindakan lain
                    // Misalnya:
                    // echo "File $filePath tidak ditemukan.";
                    // atau
                    // Log::error("File $filePath tidak ditemukan.");
                }
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
}
