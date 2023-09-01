<?php

namespace App\Http\Livewire\Component\Details;

use Carbon\Carbon;
use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Keterangan;
use App\Models\WarnaPlate;
use App\Models\FileSetting;
use App\Models\Instruction;
use App\Models\RincianPlate;
use Livewire\WithFileUploads;
use App\Models\KeteranganFoil;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Storage;
use App\Models\KeteranganMatressEmbossDeboss;

class FormSettingIndex extends Component
{
    use WithFileUploads;
    public $fileLayout = [];
    public $fileLayoutData = [];
    public $instructionCurrentId;
    public $workStepCurrentId;
    public $catatanProsesPengerjaan;
    public $keterangans = [];
    public $dataInstruction;
    public $dataFileSetting;

    public $stateWorkStepPlate;
    public $stateWorkStepSablon;
    public $stateWorkStepPond;
    public $stateWorkStepCetakLabel;
    public $stateWorkStepFoil;
    public $stateWorkStepEmbossDeboss;
    public $stateWorkStepSpotUV;
    public $stateWorkStepUV;

    //file
    public $filePisauPond = [];
    public $dataPisauPond = [];
    public $fileFoil = [];
    public $dataFoil = [];
    public $fileSablon = [];
    public $dataSablon = [];
    public $fileEmbossDeboss = [];
    public $dataEmbossDeboss = [];
    public $fileSpotUV = [];
    public $dataSpotUV = [];
    public $fileUV = [];
    public $dataUV = [];
    public $fileCetakLabel = [];
    public $dataCetakLabel = [];

    public $notes = [];
    public $workSteps;

    public function addEmptyNote()
    {
        $this->notes[] = '';
    }

    public function removeNote($index)
    {
        unset($this->notes[$index]);
        $this->notes = array_values($this->notes);
    }

    public function addWarnaField($keteranganIndex, $rincianIndexPlate)
    {
        $this->keterangans[$keteranganIndex]['rincianPlate'][$rincianIndexPlate]['rincianWarna'][] = [
            'warna' => null,
            'keterangan' => null,
        ];
    }

    public function removeWarnaField($keteranganIndex, $rincianIndexPlate, $indexwarna)
    {
        unset($this->keterangans[$keteranganIndex]['rincianPlate'][$rincianIndexPlate]['rincianWarna'][$indexwarna]);
        // Reindex the array after removal to maintain consecutive numeric keys
        $this->keterangans[$keteranganIndex]['rincianPlate'][$rincianIndexPlate]['rincianWarna'] = array_values($this->keterangans[$keteranganIndex]['rincianPlate'][$rincianIndexPlate]['rincianWarna']);
    }

    public function mount($instructionId, $workStepId)
    {
        $this->instructionCurrentId = $instructionId;
        $this->dataInstruction = Instruction::find($this->instructionCurrentId);
        $this->workStepCurrentId = $workStepId;

        $this->workSteps = WorkStep::where('instruction_id', $instructionId)
            ->with('workStepList')
            ->get();

        $dataFileLayout = Files::where('instruction_id', $this->instructionCurrentId)
            ->where('type_file', 'layout')
            ->get();

        foreach ($dataFileLayout as $dataFile) {
            $fileLayout = [
                'id' => $dataFile['id'],
                'file_name' => $dataFile['file_name'],
                'file_path' => $dataFile['file_path'],
                'type_file' => $dataFile['type_file'],
            ];

            $this->fileLayoutData[] = $fileLayout;
        }

        if ($this->dataInstruction->spk_type != 'layout') {
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
            $this->stateWorkStepFoil = WorkStep::where('instruction_id', $instructionId)
                ->where('work_step_list_id', 28)
                ->first();
            $this->stateWorkStepEmbossDeboss = WorkStep::where('instruction_id', $instructionId)
                ->whereIn('work_step_list_id', [25, 26])
                ->first();
            $this->stateWorkStepSpotUV = WorkStep::where('instruction_id', $instructionId)
                ->where('work_step_list_id', 31)
                ->first();
            $this->stateWorkStepUV = WorkStep::where('instruction_id', $instructionId)
                ->where('work_step_list_id', 30)
                ->first();

            $this->dataFileSetting = FileSetting::where('instruction_id', $instructionId)->get();

            $keteranganData = Keterangan::where('instruction_id', $this->instructionCurrentId)
                ->with('keteranganPlate', 'keteranganPisauPond', 'keteranganScreen', 'keteranganFoil', 'keteranganMatress', 'rincianPlate', 'rincianScreen', 'fileRincian', 'rincianPlate.warnaPlate')
                ->get();

            foreach ($keteranganData as $dataKeterangan) {
                $keterangan = [
                    'rincianPlate' => [],
                    'foil' => [
                        [
                            'state_foil' => 'baru',
                            'jumlah_foil' => null,
                        ],
                        [
                            'state_foil' => 'repeat',
                            'jumlah_foil' => null,
                        ],
                        [
                            'state_foil' => 'sample',
                            'jumlah_foil' => null,
                        ],
                    ],
                    'matress' => [
                        [
                            'state_matress' => 'baru',
                            'jumlah_matress' => null,
                        ],
                        [
                            'state_matress' => 'repeat',
                            'jumlah_matress' => null,
                        ],
                        [
                            'state_matress' => 'sample',
                            'jumlah_matress' => null,
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
                                'state' => $dataRincianPlate['state'],
                                'plate' => $dataRincianPlate['plate'],
                                'jumlah_lembar_cetak' => $dataRincianPlate['jumlah_lembar_cetak'],
                                'waste' => $dataRincianPlate['waste'],
                                'name' => $dataRincianPlate['name'],
                                'rincianWarna' => $dataWarna,
                            ];
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

                $this->keterangans[] = $keterangan;
            }

            if (empty($this->keterangans)) {
                $this->keterangans[] = [
                    'foil' => [],
                    'matress' => [],
                    'rincianPlate' => [],
                ];
            }

            if (isset($this->stateWorkStepPond)) {
                $filePisauPond = FileSetting::where('instruction_id', $instructionId)
                    ->where('keperluan', 'Pisau')
                    ->first();
                if (isset($filePisauPond)) {
                    $dataPisauPond = [
                        'keperluan' => 'Pisau',
                        'ukuran_film' => $filePisauPond['ukuran_film'],
                        'jumlah_film' => $filePisauPond['jumlah_film'],
                    ];
                } else {
                    $dataPisauPond = [
                        'keperluan' => 'Pisau',
                        'ukuran_film' => '',
                        'jumlah_film' => '',
                    ];
                }

                $this->dataPisauPond = $dataPisauPond;
            }

            if (isset($this->stateWorkStepSablon)) {
                $fileSablon = FileSetting::where('instruction_id', $instructionId)
                    ->where('keperluan', 'Sablon')
                    ->first();
                if (isset($fileSablon)) {
                    $dataSablon = [
                        'keperluan' => 'Sablon',
                        'ukuran_film' => $fileSablon['ukuran_film'],
                        'jumlah_film' => $fileSablon['jumlah_film'],
                    ];
                } else {
                    $dataSablon = [
                        'keperluan' => 'Sablon',
                        'ukuran_film' => '',
                        'jumlah_film' => '',
                    ];
                }

                $this->dataSablon = $dataSablon;
            }

            if (isset($this->stateWorkStepFoil)) {
                $fileFoil = FileSetting::where('instruction_id', $instructionId)
                    ->where('keperluan', 'Foil')
                    ->first();
                if (isset($fileFoil)) {
                    $dataFoil = [
                        'keperluan' => 'Foil',
                        'ukuran_film' => $fileFoil['ukuran_film'],
                        'jumlah_film' => $fileFoil['jumlah_film'],
                    ];
                } else {
                    $dataFoil = [
                        'keperluan' => 'Foil',
                        'ukuran_film' => '',
                        'jumlah_film' => '',
                    ];
                }

                $this->dataFoil = $dataFoil;
            }

            if (isset($this->stateWorkStepEmbossDeboss)) {
                $fileEmbossDeboss = FileSetting::where('instruction_id', $instructionId)
                    ->where('keperluan', 'Emboss/Deboss')
                    ->first();
                if (isset($fileEmbossDeboss)) {
                    $dataEmbossDeboss = [
                        'keperluan' => 'Emboss/Deboss',
                        'ukuran_film' => $fileEmbossDeboss['ukuran_film'],
                        'jumlah_film' => $fileEmbossDeboss['jumlah_film'],
                    ];
                } else {
                    $dataEmbossDeboss = [
                        'keperluan' => 'Emboss/Deboss',
                        'ukuran_film' => '',
                        'jumlah_film' => '',
                    ];
                }

                $this->dataEmbossDeboss = $dataEmbossDeboss;
            }

            if (isset($this->stateWorkStepSpotUV)) {
                $fileSpotUV = FileSetting::where('instruction_id', $instructionId)
                    ->where('keperluan', 'Spot UV')
                    ->first();
                if (isset($fileSpotUV)) {
                    $dataSpotUV = [
                        'keperluan' => 'Spot UV',
                        'ukuran_film' => $fileSpotUV['ukuran_film'],
                        'jumlah_film' => $fileSpotUV['jumlah_film'],
                    ];
                } else {
                    $dataSpotUV = [
                        'keperluan' => 'Spot UV',
                        'ukuran_film' => '',
                        'jumlah_film' => '',
                    ];
                }
                $this->dataSpotUV = $dataSpotUV;
            }

            if (isset($this->stateWorkStepUV)) {
                $fileUV = FileSetting::where('instruction_id', $instructionId)
                    ->where('keperluan', 'UV')
                    ->first();
                if (isset($fileUV)) {
                    $dataUV = [
                        'keperluan' => 'UV',
                        'ukuran_film' => $fileUV['ukuran_film'],
                        'jumlah_film' => $fileUV['jumlah_film'],
                    ];
                } else {
                    $dataUV = [
                        'keperluan' => 'UV',
                        'ukuran_film' => '',
                        'jumlah_film' => '',
                    ];
                }

                $this->dataUV = $dataUV;
            }

            if (isset($this->stateWorkStepCetakLabel)) {
                $fileCetakLabel = FileSetting::where('instruction_id', $instructionId)
                    ->where('keperluan', 'Label')
                    ->first();
                if (isset($fileCetakLabel)) {
                    $dataCetakLabel = [
                        'keperluan' => 'Label',
                        'ukuran_film' => $fileCetakLabel['ukuran_film'],
                        'jumlah_film' => $fileCetakLabel['jumlah_film'],
                    ];
                } else {
                    $dataCetakLabel = [
                        'keperluan' => 'Label',
                        'ukuran_film' => '',
                        'jumlah_film' => '',
                    ];
                }

                $this->dataCetakLabel = $dataCetakLabel;
            }
        }
    }

    public function render()
    {
        return view('livewire.component.details.form-setting-index');
    }
}
