<?php

namespace App\Http\Livewire\Component\Operator;

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
        return view('livewire.component.operator.form-setting-index');
    }

    public function saveSampleAndProduction()
    {
        $InstructionCurrentDataFile = Instruction::find($this->instructionCurrentId);
        $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

        $currentStep = WorkStep::find($this->workStepCurrentId);
        $nextStep = WorkStep::where('instruction_id', $this->instructionCurrentId)
            ->where('step', $currentStep->step + 1)
            ->first();

        $previousStep = WorkStep::where('instruction_id', $this->instructionCurrentId)
            ->where('step', $currentStep->step - 1)
            ->first();

        if($currentStep->flag == 'Split' && $previousStep->state_task != 'Complete' && $previousStep->work_step_list_id != 2){
            $this->emit('flashMessage', [
                'type' => 'error',
                'title' => 'Error Submit',
                'message' => 'Data tidak bisa di submit, karena langkah kerja sebelumnya tidak/belum complete',
            ]);
        }else{
            if ($this->catatanProsesPengerjaan) {
                $dataCatatanProsesPengerjaan = WorkStep::find($this->workStepCurrentId);

                // Ambil alasan pause yang sudah ada dari database
                $existingCatatanProsesPengerjaan = json_decode($dataCatatanProsesPengerjaan->catatan_proses_pengerjaan, true);

                // Tambahkan alasan pause yang baru ke dalam array existingCatatanProsesPengerjaan
                $timestampedKeterangan = $this->catatanProsesPengerjaan . ' - [' . now() . ']';
                $existingCatatanProsesPengerjaan[] = $timestampedKeterangan;

                // Simpan data ke database sebagai JSON
                $updateCatatanPengerjaan = WorkStep::where('id', $this->workStepCurrentId)->update([
                    'catatan_proses_pengerjaan' => json_encode($existingCatatanProsesPengerjaan),
                ]);
            }

            if (isset($this->notes)) {
                $this->validate([
                    'notes.*.tujuan' => 'required',
                    'notes.*.catatan' => 'required',
                ]);

                foreach ($this->notes as $input) {
                    if($input['tujuan'] == 'semua') {
                        foreach ($this->workSteps as $item) {
                            $catatanSemua = Catatan::create([
                                'tujuan' => $item['work_step_list_id'],
                                'catatan' => $input['catatan'],
                                'kategori' => 'catatan',
                                'instruction_id' => $this->instructionCurrentId,
                                'user_id' => Auth()->user()->id,
                            ]);
                        }
                    }else{
                        $catatan = Catatan::create([
                            'tujuan' => $input['tujuan'],
                            'catatan' => $input['catatan'],
                            'kategori' => 'catatan',
                            'instruction_id' => $this->instructionCurrentId,
                            'user_id' => Auth()->user()->id,
                        ]);
                    }
                }
            }

            if ($nextStep->status_task == 'Waiting Revisi') {
                if (isset($this->stateWorkStepPlate)) {
                    $this->validate(
                        [
                            'keterangans.*.rincianPlate.*.name' => 'required',
                            'keterangans.*.rincianPlate.*.rincianWarna.*.warna' => 'required',
                            'fileLayout' => 'required',
                        ],
                        [
                            'keterangans.*.rincianPlate.*.name.required' => 'Nama Plate Harus diisi.',
                            'keterangans.*.rincianPlate.*.rincianWarna.*.warna.required' => 'Warna Harus diisi.',
                            'fileLayout.required' => 'File Layout Harus diisi.',
                        ],
                    );
                }

                if (isset($this->stateWorkStepFoil)) {
                    foreach ($this->keterangans as $index => $keterangan) {
                        $this->keterangans[$index]['foil'] = array_filter($keterangan['foil'], function ($foil) {
                            return $foil['state_foil'] !== null || $foil['jumlah_foil'] !== null;
                        });
                    }

                    $this->validate(
                        [
                            'keterangans' => 'required|array|min:1',
                            'keterangans.*.foil' => 'required|array|min:1',
                            'keterangans.*.foil.*.state_foil' => 'required',
                            'keterangans.*.foil.*.jumlah_foil' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
                        ],
                        [
                            'keterangans.*.foil.required' => 'Setidaknya satu data foil harus diisi pada keterangan.',
                            'keterangans.*.foil.min' => 'Setidaknya satu data foil harus diisi pada keterangan.',
                            'keterangans.*.foil.*.state_foil.required' => 'State pada data foil harus diisi pada keterangan.',
                            'keterangans.*.foil.*.jumlah_foil.required' => 'Jumlah foil harus diisi pada keterangan.',
                            'keterangans.*.foil.*.jumlah_foil.numeric' => 'Jumlah foil harus berupa angka/tidak boleh ada tanda koma(,).',
                        ],
                    );
                }

                if (isset($this->stateWorkStepEmbossDeboss)) {
                    foreach ($this->keterangans as $index => $keterangan) {
                        $this->keterangans[$index]['matress'] = array_filter($keterangan['matress'], function ($matress) {
                            return $matress['state_matress'] !== null || $matress['jumlah_matress'] !== null;
                        });
                    }

                    $this->validate(
                        [
                            'keterangans' => 'required|array|min:1',
                            'keterangans.*.matress' => 'required|array|min:1',
                            'keterangans.*.matress.*.state_matress' => 'required',
                            'keterangans.*.matress.*.jumlah_matress' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
                        ],
                        [
                            'keterangans.*.matress.required' => 'Setidaknya satu data matress harus diisi pada keterangan.',
                            'keterangans.*.matress.min' => 'Setidaknya satu data matress harus diisi pada keterangan.',
                            'keterangans.*.matress.*.state_matress.required' => 'State pada data matress harus diisi pada keterangan.',
                            'keterangans.*.matress.*.jumlah_matress.required' => 'Jumlah matress harus diisi pada keterangan.',
                            'keterangans.*.matress.*.jumlah_matress.numeric' => 'Jumlah matress harus berupa angka/tidak boleh ada tanda koma(,).',
                        ],
                    );
                }

                if ($this->filePisauPond) {
                    if (isset($this->stateWorkStepPond)) {
                        $this->validate(
                            [
                                'filePisauPond' => 'required',
                                'dataPisauPond.keperluan' => 'required',
                                'dataPisauPond.jumlah_film' => 'required',
                                'dataPisauPond.ukuran_film' => 'required',
                            ],
                            [
                                'filePisauPond.required' => 'File Pisau Pond harus diupload.',
                                'dataPisauPond.keperluan.required' => 'Data Pisau Pond harus diisi.',
                                'dataPisauPond.jumlah_film.required' => 'Data Pisau Pond harus diisi.',
                                'dataPisauPond.ukuran_film.required' => 'Data Pisau Pond harus diisi.',
                            ],
                        );

                        $noPisauPond = FileSetting::where('instruction_id', $this->instructionCurrentId)
                            ->where('keperluan', 'Pisau')
                            ->count();
                        foreach ($this->filePisauPond as $file) {
                            $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                            $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                            $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                            $fileName = $InstructionCurrentDataFile->spk_number . '-file-pisau-pond-revisi-' . $noPisauPond . '.' . $extension;

                            Storage::putFileAs($folder, $file, $fileName);
                            $noPisauPond++;

                            $keteranganFileRincian = FileSetting::create([
                                'instruction_id' => $this->instructionCurrentId,
                                'keperluan' => $this->dataPisauPond['keperluan'],
                                'ukuran_film' => $this->dataPisauPond['ukuran_film'],
                                'jumlah_film' => $this->dataPisauPond['jumlah_film'],
                                'file_path' => $folder,
                                'file_name' => $fileName,
                            ]);
                        }
                    }
                }

                if ($this->fileFoil) {
                    if (isset($this->stateWorkStepFoil)) {
                        $this->validate(
                            [
                                'fileFoil' => 'required',
                                'dataFoil.keperluan' => 'required',
                                'dataFoil.jumlah_film' => 'required',
                                'dataFoil.ukuran_film' => 'required',
                            ],
                            [
                                'fileFoil.required' => 'File Foil harus diupload.',
                                'dataFoil.keperluan.required' => 'Data Foil harus diisi.',
                                'dataFoil.jumlah_film.required' => 'Data Foil harus diisi.',
                                'dataFoil.ukuran_film.required' => 'Data Foil harus diisi.',
                            ],
                        );

                        $noFoil = FileSetting::where('instruction_id', $this->instructionCurrentId)
                            ->where('keperluan', 'Foil')
                            ->count();
                        foreach ($this->fileFoil as $file) {
                            $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                            $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                            $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                            $fileName = $InstructionCurrentDataFile->spk_number . '-file-foil-revisi-' . $noFoil . '.' . $extension;

                            Storage::putFileAs($folder, $file, $fileName);
                            $noFoil++;

                            $keteranganFileRincian = FileSetting::create([
                                'instruction_id' => $this->instructionCurrentId,
                                'keperluan' => $this->dataFoil['keperluan'],
                                'ukuran_film' => $this->dataFoil['ukuran_film'],
                                'jumlah_film' => $this->dataFoil['jumlah_film'],
                                'file_path' => $folder,
                                'file_name' => $fileName,
                            ]);
                        }
                    }
                }

                if ($this->fileSablon) {
                    if (isset($this->stateWorkStepSablon)) {
                        $this->validate(
                            [
                                'fileSablon' => 'required',
                                'dataSablon.keperluan' => 'required',
                                'dataSablon.jumlah_film' => 'required',
                                'dataSablon.ukuran_film' => 'required',
                            ],
                            [
                                'fileSablon.required' => 'File Sablon harus diupload.',
                                'dataSablon.keperluan.required' => 'Data Sablon harus diisi.',
                                'dataSablon.jumlah_film.required' => 'Data Sablon harus diisi.',
                                'dataSablon.ukuran_film.required' => 'Data Sablon harus diisi.',
                            ],
                        );

                        $noSablon = FileSetting::where('instruction_id', $this->instructionCurrentId)
                            ->where('keperluan', 'Sablon')
                            ->count();
                        foreach ($this->fileSablon as $file) {
                            $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                            $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                            $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                            $fileName = $InstructionCurrentDataFile->spk_number . '-file-sablon-revisi-' . $noSablon . '.' . $extension;

                            Storage::putFileAs($folder, $file, $fileName);
                            $noSablon++;

                            $keteranganFileRincian = FileSetting::create([
                                'instruction_id' => $this->instructionCurrentId,
                                'keperluan' => $this->dataSablon['keperluan'],
                                'ukuran_film' => $this->dataSablon['ukuran_film'],
                                'jumlah_film' => $this->dataSablon['jumlah_film'],
                                'file_path' => $folder,
                                'file_name' => $fileName,
                            ]);
                        }
                    }
                }

                if ($this->fileEmbossDeboss) {
                    if (isset($this->stateWorkStepEmbossDeboss)) {
                        $this->validate(
                            [
                                'fileEmbossDeboss' => 'required',
                                'dataEmbossDeboss.keperluan' => 'required',
                                'dataEmbossDeboss.jumlah_film' => 'required',
                                'dataEmbossDeboss.ukuran_film' => 'required',
                            ],
                            [
                                'fileEmbossDeboss.required' => 'File Emboss/Deboss harus diupload.',
                                'dataEmbossDeboss.keperluan.required' => 'Data Emboss/Deboss harus diisi.',
                                'dataEmbossDeboss.jumlah_film.required' => 'Data Emboss/Deboss harus diisi.',
                                'dataEmbossDeboss.ukuran_film.required' => 'Data Emboss/Deboss harus diisi.',
                            ],
                        );

                        $noEmbossDeboss = FileSetting::where('instruction_id', $this->instructionCurrentId)
                            ->where('keperluan', 'Emboss/Deboss')
                            ->count();
                        foreach ($this->fileEmbossDeboss as $file) {
                            $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                            $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                            $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                            $fileName = $InstructionCurrentDataFile->spk_number . '-file-EmbossDeboss-revisi-' . $noEmbossDeboss . '.' . $extension;

                            Storage::putFileAs($folder, $file, $fileName);
                            $noEmbossDeboss++;

                            $keteranganFileRincian = FileSetting::create([
                                'instruction_id' => $this->instructionCurrentId,
                                'keperluan' => $this->dataEmbossDeboss['keperluan'],
                                'ukuran_film' => $this->dataEmbossDeboss['ukuran_film'],
                                'jumlah_film' => $this->dataEmbossDeboss['jumlah_film'],
                                'file_path' => $folder,
                                'file_name' => $fileName,
                            ]);
                        }
                    }
                }

                if ($this->fileSpotUV) {
                    if (isset($this->stateWorkStepSpotUV)) {
                        $this->validate(
                            [
                                'fileSpotUV' => 'required',
                                'dataSpotUV.keperluan' => 'required',
                                'dataSpotUV.jumlah_film' => 'required',
                                'dataSpotUV.ukuran_film' => 'required',
                            ],
                            [
                                'fileSpotUV.required' => 'File SpotUV harus diupload.',
                                'dataSpotUV.keperluan.required' => 'Data SpotUV harus diisi.',
                                'dataSpotUV.jumlah_film.required' => 'Data SpotUV harus diisi.',
                                'dataSpotUV.ukuran_film.required' => 'Data SpotUV harus diisi.',
                            ],
                        );

                        $noSpotUV = FileSetting::where('instruction_id', $this->instructionCurrentId)
                            ->where('keperluan', 'Spot UV')
                            ->count();
                        foreach ($this->fileSpotUV as $file) {
                            $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                            $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                            $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                            $fileName = $InstructionCurrentDataFile->spk_number . '-file-SpotUV-revisi-' . $noSpotUV . '.' . $extension;

                            Storage::putFileAs($folder, $file, $fileName);
                            $noSpotUV++;

                            $keteranganFileRincian = FileSetting::create([
                                'instruction_id' => $this->instructionCurrentId,
                                'keperluan' => $this->dataSpotUV['keperluan'],
                                'ukuran_film' => $this->dataSpotUV['ukuran_film'],
                                'jumlah_film' => $this->dataSpotUV['jumlah_film'],
                                'file_path' => $folder,
                                'file_name' => $fileName,
                            ]);
                        }
                    }
                }

                if ($this->fileUV) {
                    if (isset($this->stateWorkStepUV)) {
                        $this->validate(
                            [
                                'fileUV' => 'required',
                                'dataUV.keperluan' => 'required',
                                'dataUV.jumlah_film' => 'required',
                                'dataUV.ukuran_film' => 'required',
                            ],
                            [
                                'fileUV.required' => 'File UV harus diupload.',
                                'dataUV.keperluan.required' => 'Data UV harus diisi.',
                                'dataUV.jumlah_film.required' => 'Data UV harus diisi.',
                                'dataUV.ukuran_film.required' => 'Data UV harus diisi.',
                            ],
                        );

                        $noUV = FileSetting::where('instruction_id', $this->instructionCurrentId)
                            ->where('keperluan', 'UV')
                            ->count();
                        foreach ($this->fileUV as $file) {
                            $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                            $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                            $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                            $fileName = $InstructionCurrentDataFile->spk_number . '-file-UV-revisi-' . $noUV . '.' . $extension;

                            Storage::putFileAs($folder, $file, $fileName);
                            $noUV++;

                            $keteranganFileRincian = FileSetting::create([
                                'instruction_id' => $this->instructionCurrentId,
                                'keperluan' => $this->dataUV['keperluan'],
                                'ukuran_film' => $this->dataUV['ukuran_film'],
                                'jumlah_film' => $this->dataUV['jumlah_film'],
                                'file_path' => $folder,
                                'file_name' => $fileName,
                            ]);
                        }
                    }
                }

                if ($this->fileCetakLabel) {
                    if (isset($this->stateWorkStepCetakLabel)) {
                        $this->validate(
                            [
                                'fileCetakLabel' => 'required',
                                'dataCetakLabel.keperluan' => 'required',
                                'dataCetakLabel.jumlah_film' => 'required',
                                'dataCetakLabel.ukuran_film' => 'required',
                            ],
                            [
                                'fileCetakLabel.required' => 'File CetakLabel harus diupload.',
                                'dataCetakLabel.keperluan.required' => 'Data CetakLabel harus diisi.',
                                'dataCetakLabel.jumlah_film.required' => 'Data CetakLabel harus diisi.',
                                'dataCetakLabel.ukuran_film.required' => 'Data CetakLabel harus diisi.',
                            ],
                        );

                        $noCetakLabel = FileSetting::where('instruction_id', $this->instructionCurrentId)
                            ->where('keperluan', 'Label')
                            ->count();
                        foreach ($this->fileCetakLabel as $file) {
                            $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                            $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                            $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                            $fileName = $InstructionCurrentDataFile->spk_number . '-file-CetakLabel-revisi-' . $noCetakLabel . '.' . $extension;

                            Storage::putFileAs($folder, $file, $fileName);
                            $noCetakLabel++;

                            $keteranganFileRincian = FileSetting::create([
                                'instruction_id' => $this->instructionCurrentId,
                                'keperluan' => $this->dataCetakLabel['keperluan'],
                                'ukuran_film' => $this->dataCetakLabel['ukuran_film'],
                                'jumlah_film' => $this->dataCetakLabel['jumlah_film'],
                                'file_path' => $folder,
                                'file_name' => $fileName,
                            ]);
                        }
                    }
                }

                if ($this->fileLayout) {
                    $this->validate(
                        [
                            'fileLayout' => 'required',
                        ],
                        [
                            'fileLayout.required' => 'File Layout Harus diisi.',
                        ],
                    );

                    $fileLayoutData = Files::where('instruction_id', $this->instructionCurrentId)
                        ->where('type_file', 'layout')
                        ->count();
                    $nolayout = $fileLayoutData;

                    foreach ($this->fileLayout as $file) {
                        $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                        $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                        $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                        $fileName = Carbon::now()->format('Ymd') . '-' . $InstructionCurrentDataFile->spk_number . '-file-layout-revisi-' . $nolayout . '.' . $extension;

                        Storage::putFileAs($folder, $file, $fileName);
                        $nolayout++;

                        Files::create([
                            'instruction_id' => $this->instructionCurrentId,
                            'user_id' => Auth()->user()->id,
                            'type_file' => 'layout',
                            'file_name' => $fileName,
                            'file_path' => $folder,
                        ]);
                    }
                }
            } elseif ($currentStep->status_task == 'Reject Requirements') {
                if (isset($this->stateWorkStepPlate)) {
                    $this->validate(
                        [
                            'keterangans.*.rincianPlate.*.name' => 'required',
                            'keterangans.*.rincianPlate.*.rincianWarna.*.warna' => 'required',
                            'fileLayout' => 'required',
                        ],
                        [
                            'keterangans.*.rincianPlate.*.name.required' => 'Nama Plate Harus diisi.',
                            'keterangans.*.rincianPlate.*.rincianWarna.*.warna.required' => 'Warna Harus diisi.',
                            'fileLayout.required' => 'File Layout Harus diisi.',
                        ],
                    );
                }

                if (isset($this->stateWorkStepFoil)) {
                    foreach ($this->keterangans as $index => $keterangan) {
                        $this->keterangans[$index]['foil'] = array_filter($keterangan['foil'], function ($foil) {
                            return $foil['state_foil'] !== null || $foil['jumlah_foil'] !== null;
                        });
                    }

                    $this->validate(
                        [
                            'keterangans' => 'required|array|min:1',
                            'keterangans.*.foil' => 'required|array|min:1',
                            'keterangans.*.foil.*.state_foil' => 'required',
                            'keterangans.*.foil.*.jumlah_foil' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
                        ],
                        [
                            'keterangans.*.foil.required' => 'Setidaknya satu data foil harus diisi pada keterangan.',
                            'keterangans.*.foil.min' => 'Setidaknya satu data foil harus diisi pada keterangan.',
                            'keterangans.*.foil.*.state_foil.required' => 'State pada data foil harus diisi pada keterangan.',
                            'keterangans.*.foil.*.jumlah_foil.required' => 'Jumlah foil harus diisi pada keterangan.',
                            'keterangans.*.foil.*.jumlah_foil.numeric' => 'Jumlah foil harus berupa angka/tidak boleh ada tanda koma(,).',
                        ],
                    );
                }

                if (isset($this->stateWorkStepEmbossDeboss)) {
                    foreach ($this->keterangans as $index => $keterangan) {
                        $this->keterangans[$index]['matress'] = array_filter($keterangan['matress'], function ($matress) {
                            return $matress['state_matress'] !== null || $matress['jumlah_matress'] !== null;
                        });
                    }

                    $this->validate(
                        [
                            'keterangans' => 'required|array|min:1',
                            'keterangans.*.matress' => 'required|array|min:1',
                            'keterangans.*.matress.*.state_matress' => 'required',
                            'keterangans.*.matress.*.jumlah_matress' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
                        ],
                        [
                            'keterangans.*.matress.required' => 'Setidaknya satu data matress harus diisi pada keterangan.',
                            'keterangans.*.matress.min' => 'Setidaknya satu data matress harus diisi pada keterangan.',
                            'keterangans.*.matress.*.state_matress.required' => 'State pada data matress harus diisi pada keterangan.',
                            'keterangans.*.matress.*.jumlah_matress.required' => 'Jumlah matress harus diisi pada keterangan.',
                            'keterangans.*.matress.*.jumlah_matress.numeric' => 'Jumlah matress harus berupa angka/tidak boleh ada tanda koma(,).',
                        ],
                    );
                }

                if ($this->filePisauPond) {
                    if (isset($this->stateWorkStepPond)) {
                        $this->validate(
                            [
                                'filePisauPond' => 'required',
                                'dataPisauPond.keperluan' => 'required',
                                'dataPisauPond.jumlah_film' => 'required',
                                'dataPisauPond.ukuran_film' => 'required',
                            ],
                            [
                                'filePisauPond.required' => 'File Pisau Pond harus diupload.',
                                'dataPisauPond.keperluan.required' => 'Data Pisau Pond harus diisi.',
                                'dataPisauPond.jumlah_film.required' => 'Data Pisau Pond harus diisi.',
                                'dataPisauPond.ukuran_film.required' => 'Data Pisau Pond harus diisi.',
                            ],
                        );

                        $noPisauPond = FileSetting::where('instruction_id', $this->instructionCurrentId)
                            ->where('keperluan', 'Pisau')
                            ->count();
                        foreach ($this->filePisauPond as $file) {
                            $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                            $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                            $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                            $fileName = $InstructionCurrentDataFile->spk_number . '-file-pisau-pond-reject-' . $noPisauPond . '.' . $extension;

                            Storage::putFileAs($folder, $file, $fileName);
                            $noPisauPond++;

                            $keteranganFileRincian = FileSetting::create([
                                'instruction_id' => $this->instructionCurrentId,
                                'keperluan' => $this->dataPisauPond['keperluan'],
                                'ukuran_film' => $this->dataPisauPond['ukuran_film'],
                                'jumlah_film' => $this->dataPisauPond['jumlah_film'],
                                'file_path' => $folder,
                                'file_name' => $fileName,
                            ]);
                        }
                    }
                }

                if ($this->fileFoil) {
                    if (isset($this->stateWorkStepFoil)) {
                        $this->validate(
                            [
                                'fileFoil' => 'required',
                                'dataFoil.keperluan' => 'required',
                                'dataFoil.jumlah_film' => 'required',
                                'dataFoil.ukuran_film' => 'required',
                            ],
                            [
                                'fileFoil.required' => 'File Foil harus diupload.',
                                'dataFoil.keperluan.required' => 'Data Foil harus diisi.',
                                'dataFoil.jumlah_film.required' => 'Data Foil harus diisi.',
                                'dataFoil.ukuran_film.required' => 'Data Foil harus diisi.',
                            ],
                        );

                        $noFoil = FileSetting::where('instruction_id', $this->instructionCurrentId)
                            ->where('keperluan', 'Foil')
                            ->count();
                        foreach ($this->fileFoil as $file) {
                            $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                            $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                            $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                            $fileName = $InstructionCurrentDataFile->spk_number . '-file-foil-reject-' . $noFoil . '.' . $extension;

                            Storage::putFileAs($folder, $file, $fileName);
                            $noFoil++;

                            $keteranganFileRincian = FileSetting::create([
                                'instruction_id' => $this->instructionCurrentId,
                                'keperluan' => $this->dataFoil['keperluan'],
                                'ukuran_film' => $this->dataFoil['ukuran_film'],
                                'jumlah_film' => $this->dataFoil['jumlah_film'],
                                'file_path' => $folder,
                                'file_name' => $fileName,
                            ]);
                        }
                    }
                }

                if ($this->fileSablon) {
                    if (isset($this->stateWorkStepSablon)) {
                        $this->validate(
                            [
                                'fileSablon' => 'required',
                                'dataSablon.keperluan' => 'required',
                                'dataSablon.jumlah_film' => 'required',
                                'dataSablon.ukuran_film' => 'required',
                            ],
                            [
                                'fileSablon.required' => 'File Sablon harus diupload.',
                                'dataSablon.keperluan.required' => 'Data Sablon harus diisi.',
                                'dataSablon.jumlah_film.required' => 'Data Sablon harus diisi.',
                                'dataSablon.ukuran_film.required' => 'Data Sablon harus diisi.',
                            ],
                        );

                        $noSablon = FileSetting::where('instruction_id', $this->instructionCurrentId)
                            ->where('keperluan', 'Sablon')
                            ->count();
                        foreach ($this->fileSablon as $file) {
                            $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                            $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                            $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                            $fileName = $InstructionCurrentDataFile->spk_number . '-file-sablon-reject-' . $noSablon . '.' . $extension;

                            Storage::putFileAs($folder, $file, $fileName);
                            $noSablon++;

                            $keteranganFileRincian = FileSetting::create([
                                'instruction_id' => $this->instructionCurrentId,
                                'keperluan' => $this->dataSablon['keperluan'],
                                'ukuran_film' => $this->dataSablon['ukuran_film'],
                                'jumlah_film' => $this->dataSablon['jumlah_film'],
                                'file_path' => $folder,
                                'file_name' => $fileName,
                            ]);
                        }
                    }
                }

                if ($this->fileEmbossDeboss) {
                    if (isset($this->stateWorkStepEmbossDeboss)) {
                        $this->validate(
                            [
                                'fileEmbossDeboss' => 'required',
                                'dataEmbossDeboss.keperluan' => 'required',
                                'dataEmbossDeboss.jumlah_film' => 'required',
                                'dataEmbossDeboss.ukuran_film' => 'required',
                            ],
                            [
                                'fileEmbossDeboss.required' => 'File Emboss/Deboss harus diupload.',
                                'dataEmbossDeboss.keperluan.required' => 'Data Emboss/Deboss harus diisi.',
                                'dataEmbossDeboss.jumlah_film.required' => 'Data Emboss/Deboss harus diisi.',
                                'dataEmbossDeboss.ukuran_film.required' => 'Data Emboss/Deboss harus diisi.',
                            ],
                        );

                        $noEmbossDeboss = FileSetting::where('instruction_id', $this->instructionCurrentId)
                            ->where('keperluan', 'Emboss/Deboss')
                            ->count();
                        foreach ($this->fileEmbossDeboss as $file) {
                            $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                            $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                            $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                            $fileName = $InstructionCurrentDataFile->spk_number . '-file-EmbossDeboss-reject-' . $noEmbossDeboss . '.' . $extension;

                            Storage::putFileAs($folder, $file, $fileName);
                            $noEmbossDeboss++;

                            $keteranganFileRincian = FileSetting::create([
                                'instruction_id' => $this->instructionCurrentId,
                                'keperluan' => $this->dataEmbossDeboss['keperluan'],
                                'ukuran_film' => $this->dataEmbossDeboss['ukuran_film'],
                                'jumlah_film' => $this->dataEmbossDeboss['jumlah_film'],
                                'file_path' => $folder,
                                'file_name' => $fileName,
                            ]);
                        }
                    }
                }

                if ($this->fileSpotUV) {
                    if (isset($this->stateWorkStepSpotUV)) {
                        $this->validate(
                            [
                                'fileSpotUV' => 'required',
                                'dataSpotUV.keperluan' => 'required',
                                'dataSpotUV.jumlah_film' => 'required',
                                'dataSpotUV.ukuran_film' => 'required',
                            ],
                            [
                                'fileSpotUV.required' => 'File SpotUV harus diupload.',
                                'dataSpotUV.keperluan.required' => 'Data SpotUV harus diisi.',
                                'dataSpotUV.jumlah_film.required' => 'Data SpotUV harus diisi.',
                                'dataSpotUV.ukuran_film.required' => 'Data SpotUV harus diisi.',
                            ],
                        );

                        $noSpotUV = FileSetting::where('instruction_id', $this->instructionCurrentId)
                            ->where('keperluan', 'Spot UV')
                            ->count();
                        foreach ($this->fileSpotUV as $file) {
                            $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                            $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                            $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                            $fileName = $InstructionCurrentDataFile->spk_number . '-file-SpotUV-reject-' . $noSpotUV . '.' . $extension;

                            Storage::putFileAs($folder, $file, $fileName);
                            $noSpotUV++;

                            $keteranganFileRincian = FileSetting::create([
                                'instruction_id' => $this->instructionCurrentId,
                                'keperluan' => $this->dataSpotUV['keperluan'],
                                'ukuran_film' => $this->dataSpotUV['ukuran_film'],
                                'jumlah_film' => $this->dataSpotUV['jumlah_film'],
                                'file_path' => $folder,
                                'file_name' => $fileName,
                            ]);
                        }
                    }
                }

                if ($this->fileUV) {
                    if (isset($this->stateWorkStepUV)) {
                        $this->validate(
                            [
                                'fileUV' => 'required',
                                'dataUV.keperluan' => 'required',
                                'dataUV.jumlah_film' => 'required',
                                'dataUV.ukuran_film' => 'required',
                            ],
                            [
                                'fileUV.required' => 'File UV harus diupload.',
                                'dataUV.keperluan.required' => 'Data UV harus diisi.',
                                'dataUV.jumlah_film.required' => 'Data UV harus diisi.',
                                'dataUV.ukuran_film.required' => 'Data UV harus diisi.',
                            ],
                        );

                        $noUV = FileSetting::where('instruction_id', $this->instructionCurrentId)
                            ->where('keperluan', 'UV')
                            ->count();
                        foreach ($this->fileUV as $file) {
                            $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                            $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                            $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                            $fileName = $InstructionCurrentDataFile->spk_number . '-file-UV-reject-' . $noUV . '.' . $extension;

                            Storage::putFileAs($folder, $file, $fileName);
                            $noUV++;

                            $keteranganFileRincian = FileSetting::create([
                                'instruction_id' => $this->instructionCurrentId,
                                'keperluan' => $this->dataUV['keperluan'],
                                'ukuran_film' => $this->dataUV['ukuran_film'],
                                'jumlah_film' => $this->dataUV['jumlah_film'],
                                'file_path' => $folder,
                                'file_name' => $fileName,
                            ]);
                        }
                    }
                }

                if ($this->fileCetakLabel) {
                    if (isset($this->stateWorkStepCetakLabel)) {
                        $this->validate(
                            [
                                'fileCetakLabel' => 'required',
                                'dataCetakLabel.keperluan' => 'required',
                                'dataCetakLabel.jumlah_film' => 'required',
                                'dataCetakLabel.ukuran_film' => 'required',
                            ],
                            [
                                'fileCetakLabel.required' => 'File CetakLabel harus diupload.',
                                'dataCetakLabel.keperluan.required' => 'Data CetakLabel harus diisi.',
                                'dataCetakLabel.jumlah_film.required' => 'Data CetakLabel harus diisi.',
                                'dataCetakLabel.ukuran_film.required' => 'Data CetakLabel harus diisi.',
                            ],
                        );

                        $noCetakLabel = FileSetting::where('instruction_id', $this->instructionCurrentId)
                            ->where('keperluan', 'Label')
                            ->count();
                        foreach ($this->fileCetakLabel as $file) {
                            $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                            $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                            $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                            $fileName = $InstructionCurrentDataFile->spk_number . '-file-CetakLabel-reject-' . $noCetakLabel . '.' . $extension;

                            Storage::putFileAs($folder, $file, $fileName);
                            $noCetakLabel++;

                            $keteranganFileRincian = FileSetting::create([
                                'instruction_id' => $this->instructionCurrentId,
                                'keperluan' => $this->dataCetakLabel['keperluan'],
                                'ukuran_film' => $this->dataCetakLabel['ukuran_film'],
                                'jumlah_film' => $this->dataCetakLabel['jumlah_film'],
                                'file_path' => $folder,
                                'file_name' => $fileName,
                            ]);
                        }
                    }
                }

                if ($this->fileLayout) {
                    $this->validate(
                        [
                            'fileLayout' => 'required',
                        ],
                        [
                            'fileLayout.required' => 'File Layout Harus diisi.',
                        ],
                    );

                    $fileLayoutData = Files::where('instruction_id', $this->instructionCurrentId)
                        ->where('type_file', 'layout')
                        ->count();
                    $nolayout = $fileLayoutData;

                    foreach ($this->fileLayout as $file) {
                        $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                        $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                        $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                        $fileName = Carbon::now()->format('Ymd') . '-' . $InstructionCurrentDataFile->spk_number . '-file-layout-reject-' . $nolayout . '.' . $extension;

                        Storage::putFileAs($folder, $file, $fileName);
                        $nolayout++;

                        Files::create([
                            'instruction_id' => $this->instructionCurrentId,
                            'user_id' => Auth()->user()->id,
                            'type_file' => 'layout',
                            'file_name' => $fileName,
                            'file_path' => $folder,
                        ]);
                    }
                }
            } else {
                if (isset($this->stateWorkStepPlate)) {
                    $this->validate(
                        [
                            'keterangans.*.rincianPlate.*.name' => 'required',
                            'keterangans.*.rincianPlate.*.rincianWarna.*.warna' => 'required',
                            'fileLayout' => 'required',
                        ],
                        [
                            'keterangans.*.rincianPlate.*.name.required' => 'Nama Plate Harus diisi.',
                            'keterangans.*.rincianPlate.*.rincianWarna.*.warna.required' => 'Warna Harus diisi.',
                            'fileLayout.required' => 'File Layout Harus diisi.',
                        ],
                    );
                }

                if (isset($this->stateWorkStepFoil)) {
                    foreach ($this->keterangans as $index => $keterangan) {
                        $this->keterangans[$index]['foil'] = array_filter($keterangan['foil'], function ($foil) {
                            return $foil['state_foil'] !== null || $foil['jumlah_foil'] !== null;
                        });
                    }

                    $this->validate(
                        [
                            'keterangans' => 'required|array|min:1',
                            'keterangans.*.foil' => 'required|array|min:1',
                            'keterangans.*.foil.*.state_foil' => 'required',
                            'keterangans.*.foil.*.jumlah_foil' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
                        ],
                        [
                            'keterangans.*.foil.required' => 'Setidaknya satu data foil harus diisi pada keterangan.',
                            'keterangans.*.foil.min' => 'Setidaknya satu data foil harus diisi pada keterangan.',
                            'keterangans.*.foil.*.state_foil.required' => 'State pada data foil harus diisi pada keterangan.',
                            'keterangans.*.foil.*.jumlah_foil.required' => 'Jumlah foil harus diisi pada keterangan.',
                            'keterangans.*.foil.*.jumlah_foil.numeric' => 'Jumlah foil harus berupa angka/tidak boleh ada tanda koma(,).',
                        ],
                    );
                }

                if (isset($this->stateWorkStepEmbossDeboss)) {
                    foreach ($this->keterangans as $index => $keterangan) {
                        $this->keterangans[$index]['matress'] = array_filter($keterangan['matress'], function ($matress) {
                            return $matress['state_matress'] !== null || $matress['jumlah_matress'] !== null;
                        });
                    }

                    $this->validate(
                        [
                            'keterangans' => 'required|array|min:1',
                            'keterangans.*.matress' => 'required|array|min:1',
                            'keterangans.*.matress.*.state_matress' => 'required',
                            'keterangans.*.matress.*.jumlah_matress' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
                        ],
                        [
                            'keterangans.*.matress.required' => 'Setidaknya satu data matress harus diisi pada keterangan.',
                            'keterangans.*.matress.min' => 'Setidaknya satu data matress harus diisi pada keterangan.',
                            'keterangans.*.matress.*.state_matress.required' => 'State pada data matress harus diisi pada keterangan.',
                            'keterangans.*.matress.*.jumlah_matress.required' => 'Jumlah matress harus diisi pada keterangan.',
                            'keterangans.*.matress.*.jumlah_matress.numeric' => 'Jumlah matress harus berupa angka/tidak boleh ada tanda koma(,).',
                        ],
                    );
                }

                if ($this->filePisauPond) {
                    if (isset($this->stateWorkStepPond)) {
                        $this->validate(
                            [
                                'filePisauPond' => 'required',
                                'dataPisauPond.keperluan' => 'required',
                                'dataPisauPond.jumlah_film' => 'required',
                                'dataPisauPond.ukuran_film' => 'required',
                            ],
                            [
                                'filePisauPond.required' => 'File Pisau Pond harus diupload.',
                                'dataPisauPond.keperluan.required' => 'Data Pisau Pond harus diisi.',
                                'dataPisauPond.jumlah_film.required' => 'Data Pisau Pond harus diisi.',
                                'dataPisauPond.ukuran_film.required' => 'Data Pisau Pond harus diisi.',
                            ],
                        );

                        $noPisauPond = FileSetting::where('instruction_id', $this->instructionCurrentId)
                            ->where('keperluan', 'Pisau')
                            ->count();
                        foreach ($this->filePisauPond as $file) {
                            $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                            $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                            $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                            $fileName = $InstructionCurrentDataFile->spk_number . '-file-pisau-pond-' . $noPisauPond . '.' . $extension;

                            Storage::putFileAs($folder, $file, $fileName);
                            $noPisauPond++;

                            $keteranganFileRincian = FileSetting::create([
                                'instruction_id' => $this->instructionCurrentId,
                                'keperluan' => $this->dataPisauPond['keperluan'],
                                'ukuran_film' => $this->dataPisauPond['ukuran_film'],
                                'jumlah_film' => $this->dataPisauPond['jumlah_film'],
                                'file_path' => $folder,
                                'file_name' => $fileName,
                            ]);
                        }
                    }
                }

                if ($this->fileFoil) {
                    if (isset($this->stateWorkStepFoil)) {
                        $this->validate(
                            [
                                'fileFoil' => 'required',
                                'dataFoil.keperluan' => 'required',
                                'dataFoil.jumlah_film' => 'required',
                                'dataFoil.ukuran_film' => 'required',
                            ],
                            [
                                'fileFoil.required' => 'File Foil harus diupload.',
                                'dataFoil.keperluan.required' => 'Data Foil harus diisi.',
                                'dataFoil.jumlah_film.required' => 'Data Foil harus diisi.',
                                'dataFoil.ukuran_film.required' => 'Data Foil harus diisi.',
                            ],
                        );

                        $noFoil = FileSetting::where('instruction_id', $this->instructionCurrentId)
                            ->where('keperluan', 'Foil')
                            ->count();
                        foreach ($this->fileFoil as $file) {
                            $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                            $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                            $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                            $fileName = $InstructionCurrentDataFile->spk_number . '-file-foil-' . $noFoil . '.' . $extension;

                            Storage::putFileAs($folder, $file, $fileName);
                            $noFoil++;

                            $keteranganFileRincian = FileSetting::create([
                                'instruction_id' => $this->instructionCurrentId,
                                'keperluan' => $this->dataFoil['keperluan'],
                                'ukuran_film' => $this->dataFoil['ukuran_film'],
                                'jumlah_film' => $this->dataFoil['jumlah_film'],
                                'file_path' => $folder,
                                'file_name' => $fileName,
                            ]);
                        }
                    }
                }

                if ($this->fileSablon) {
                    if (isset($this->stateWorkStepSablon)) {
                        $this->validate(
                            [
                                'fileSablon' => 'required',
                                'dataSablon.keperluan' => 'required',
                                'dataSablon.jumlah_film' => 'required',
                                'dataSablon.ukuran_film' => 'required',
                            ],
                            [
                                'fileSablon.required' => 'File Sablon harus diupload.',
                                'dataSablon.keperluan.required' => 'Data Sablon harus diisi.',
                                'dataSablon.jumlah_film.required' => 'Data Sablon harus diisi.',
                                'dataSablon.ukuran_film.required' => 'Data Sablon harus diisi.',
                            ],
                        );

                        $noSablon = FileSetting::where('instruction_id', $this->instructionCurrentId)
                            ->where('keperluan', 'Sablon')
                            ->count();
                        foreach ($this->fileSablon as $file) {
                            $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                            $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                            $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                            $fileName = $InstructionCurrentDataFile->spk_number . '-file-sablon-' . $noSablon . '.' . $extension;

                            Storage::putFileAs($folder, $file, $fileName);
                            $noSablon++;

                            $keteranganFileRincian = FileSetting::create([
                                'instruction_id' => $this->instructionCurrentId,
                                'keperluan' => $this->dataSablon['keperluan'],
                                'ukuran_film' => $this->dataSablon['ukuran_film'],
                                'jumlah_film' => $this->dataSablon['jumlah_film'],
                                'file_path' => $folder,
                                'file_name' => $fileName,
                            ]);
                        }
                    }
                }

                if ($this->fileEmbossDeboss) {
                    if (isset($this->stateWorkStepEmbossDeboss)) {
                        $this->validate(
                            [
                                'fileEmbossDeboss' => 'required',
                                'dataEmbossDeboss.keperluan' => 'required',
                                'dataEmbossDeboss.jumlah_film' => 'required',
                                'dataEmbossDeboss.ukuran_film' => 'required',
                            ],
                            [
                                'fileEmbossDeboss.required' => 'File Emboss/Deboss harus diupload.',
                                'dataEmbossDeboss.keperluan.required' => 'Data Emboss/Deboss harus diisi.',
                                'dataEmbossDeboss.jumlah_film.required' => 'Data Emboss/Deboss harus diisi.',
                                'dataEmbossDeboss.ukuran_film.required' => 'Data Emboss/Deboss harus diisi.',
                            ],
                        );

                        $noEmbossDeboss = FileSetting::where('instruction_id', $this->instructionCurrentId)
                            ->where('keperluan', 'Emboss/Deboss')
                            ->count();
                        foreach ($this->fileEmbossDeboss as $file) {
                            $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                            $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                            $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                            $fileName = $InstructionCurrentDataFile->spk_number . '-file-EmbossDeboss-' . $noEmbossDeboss . '.' . $extension;

                            Storage::putFileAs($folder, $file, $fileName);
                            $noEmbossDeboss++;

                            $keteranganFileRincian = FileSetting::create([
                                'instruction_id' => $this->instructionCurrentId,
                                'keperluan' => $this->dataEmbossDeboss['keperluan'],
                                'ukuran_film' => $this->dataEmbossDeboss['ukuran_film'],
                                'jumlah_film' => $this->dataEmbossDeboss['jumlah_film'],
                                'file_path' => $folder,
                                'file_name' => $fileName,
                            ]);
                        }
                    }
                }

                if ($this->fileSpotUV) {
                    if (isset($this->stateWorkStepSpotUV)) {
                        $this->validate(
                            [
                                'fileSpotUV' => 'required',
                                'dataSpotUV.keperluan' => 'required',
                                'dataSpotUV.jumlah_film' => 'required',
                                'dataSpotUV.ukuran_film' => 'required',
                            ],
                            [
                                'fileSpotUV.required' => 'File SpotUV harus diupload.',
                                'dataSpotUV.keperluan.required' => 'Data SpotUV harus diisi.',
                                'dataSpotUV.jumlah_film.required' => 'Data SpotUV harus diisi.',
                                'dataSpotUV.ukuran_film.required' => 'Data SpotUV harus diisi.',
                            ],
                        );

                        $noSpotUV = FileSetting::where('instruction_id', $this->instructionCurrentId)
                            ->where('keperluan', 'Spot UV')
                            ->count();
                        foreach ($this->fileSpotUV as $file) {
                            $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                            $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                            $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                            $fileName = $InstructionCurrentDataFile->spk_number . '-file-SpotUV-' . $noSpotUV . '.' . $extension;

                            Storage::putFileAs($folder, $file, $fileName);
                            $noSpotUV++;

                            $keteranganFileRincian = FileSetting::create([
                                'instruction_id' => $this->instructionCurrentId,
                                'keperluan' => $this->dataSpotUV['keperluan'],
                                'ukuran_film' => $this->dataSpotUV['ukuran_film'],
                                'jumlah_film' => $this->dataSpotUV['jumlah_film'],
                                'file_path' => $folder,
                                'file_name' => $fileName,
                            ]);
                        }
                    }
                }

                if ($this->fileUV) {
                    if (isset($this->stateWorkStepUV)) {
                        $this->validate(
                            [
                                'fileUV' => 'required',
                                'dataUV.keperluan' => 'required',
                                'dataUV.jumlah_film' => 'required',
                                'dataUV.ukuran_film' => 'required',
                            ],
                            [
                                'fileUV.required' => 'File UV harus diupload.',
                                'dataUV.keperluan.required' => 'Data UV harus diisi.',
                                'dataUV.jumlah_film.required' => 'Data UV harus diisi.',
                                'dataUV.ukuran_film.required' => 'Data UV harus diisi.',
                            ],
                        );

                        $noUV = FileSetting::where('instruction_id', $this->instructionCurrentId)
                            ->where('keperluan', 'UV')
                            ->count();
                        foreach ($this->fileUV as $file) {
                            $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                            $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                            $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                            $fileName = $InstructionCurrentDataFile->spk_number . '-file-UV-' . $noUV . '.' . $extension;

                            Storage::putFileAs($folder, $file, $fileName);
                            $noUV++;

                            $keteranganFileRincian = FileSetting::create([
                                'instruction_id' => $this->instructionCurrentId,
                                'keperluan' => $this->dataUV['keperluan'],
                                'ukuran_film' => $this->dataUV['ukuran_film'],
                                'jumlah_film' => $this->dataUV['jumlah_film'],
                                'file_path' => $folder,
                                'file_name' => $fileName,
                            ]);
                        }
                    }
                }

                if ($this->fileCetakLabel) {
                    if (isset($this->stateWorkStepCetakLabel)) {
                        $this->validate(
                            [
                                'fileCetakLabel' => 'required',
                                'dataCetakLabel.keperluan' => 'required',
                                'dataCetakLabel.jumlah_film' => 'required',
                                'dataCetakLabel.ukuran_film' => 'required',
                            ],
                            [
                                'fileCetakLabel.required' => 'File CetakLabel harus diupload.',
                                'dataCetakLabel.keperluan.required' => 'Data CetakLabel harus diisi.',
                                'dataCetakLabel.jumlah_film.required' => 'Data CetakLabel harus diisi.',
                                'dataCetakLabel.ukuran_film.required' => 'Data CetakLabel harus diisi.',
                            ],
                        );

                        $noCetakLabel = FileSetting::where('instruction_id', $this->instructionCurrentId)
                            ->where('keperluan', 'Label')
                            ->count();
                        foreach ($this->fileCetakLabel as $file) {
                            $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                            $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                            $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                            $fileName = $InstructionCurrentDataFile->spk_number . '-file-CetakLabel-' . $noCetakLabel . '.' . $extension;

                            Storage::putFileAs($folder, $file, $fileName);
                            $noCetakLabel++;

                            $keteranganFileRincian = FileSetting::create([
                                'instruction_id' => $this->instructionCurrentId,
                                'keperluan' => $this->dataCetakLabel['keperluan'],
                                'ukuran_film' => $this->dataCetakLabel['ukuran_film'],
                                'jumlah_film' => $this->dataCetakLabel['jumlah_film'],
                                'file_path' => $folder,
                                'file_name' => $fileName,
                            ]);
                        }
                    }
                }

                if ($this->fileLayout) {
                    $this->validate(
                        [
                            'fileLayout' => 'required',
                        ],
                        [
                            'fileLayout.required' => 'File Layout Harus diisi.',
                        ],
                    );

                    $fileLayoutData = Files::where('instruction_id', $this->instructionCurrentId)
                        ->where('type_file', 'layout')
                        ->count();
                    $nolayout = $fileLayoutData;
                    foreach ($this->fileLayout as $file) {
                        $folder = 'public/' . $InstructionCurrentDataFile->spk_number . '/setting';

                        $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                        $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                        $fileName = Carbon::now()->format('Ymd') . '-' . $InstructionCurrentDataFile->spk_number . '-file-layout-' . $nolayout . '.' . $extension;

                        Storage::putFileAs($folder, $file, $fileName);
                        $nolayout++;

                        Files::create([
                            'instruction_id' => $this->instructionCurrentId,
                            'user_id' => Auth()->user()->id,
                            'type_file' => 'layout',
                            'file_name' => $fileName,
                            'file_path' => $folder,
                        ]);
                    }
                }
            }

            if (isset($this->stateWorkStepPlate)) {
                $deleteWarna = WarnaPlate::where('instruction_id', $this->instructionCurrentId)->delete();
                if (isset($this->keterangans)){
                    foreach ($this->keterangans as $key => $item) {
                        $keterangan = Keterangan::where('instruction_id', $this->instructionCurrentId)
                            ->where('form_id', $key)
                            ->first();
                        foreach ($item['rincianPlate'] as $rincian) {
                            $updateRincianPlate = RincianPlate::updateOrCreate(
                                [
                                    'instruction_id' => $this->instructionCurrentId,
                                    'plate' => $rincian['plate'],
                                ],
                                [
                                    'name' => $rincian['name'],
                                    'jumlah_lembar_cetak' => $rincian['jumlah_lembar_cetak'],
                                    'waste' => $rincian['waste'],
                                ],
                            );
                            foreach ($rincian['rincianWarna'] as $warna) {
                                $warnaPlate = WarnaPlate::create([
                                    'instruction_id' => $this->instructionCurrentId,
                                    'rincian_plate_id' => $updateRincianPlate->id,
                                    'warna' => $warna['warna'],
                                    'keterangan' => $warna['keterangan'],
                                ]);
                            }
                        }

                        if (isset($item['foil'])) {
                            $deleteFoil = KeteranganFoil::where('instruction_id', $this->instructionCurrentId)->delete();
                            foreach ($item['foil'] as $foil) {
                                // Buat instance model KeteranganPisauPond
                                $keteranganFoil = KeteranganFoil::create([
                                    'instruction_id' => $this->instructionCurrentId,
                                    'keterangan_id' => $keterangan['id'],
                                    'state_foil' => $foil['state_foil'],
                                    'jumlah_foil' => $foil['jumlah_foil'],
                                ]);
                            }
                        }

                        if (isset($item['matress'])) {
                            $deleteMatressEmbossDeboss = KeteranganMatressEmbossDeboss::where('instruction_id', $this->instructionCurrentId)->delete();
                            foreach ($item['matress'] as $matress) {
                                // Buat instance model KeteranganPisauPond
                                $keteranganMatress = KeteranganMatressEmbossDeboss::create([
                                    'instruction_id' => $this->instructionCurrentId,
                                    'keterangan_id' => $keterangan['id'],
                                    'state_matress' => $matress['state_matress'],
                                    'jumlah_matress' => $matress['jumlah_matress'],
                                ]);
                            }
                        }
                    }

                    $updateRincianPlateDeleted = RincianPlate::where('instruction_id', $this->instructionCurrentId)
                        ->whereNull('name')
                        ->update([
                            'status' => 'Deleted by Setting',
                        ]);
                }
            }

            if ($currentStep->status_task == 'Reject Requirements') {
                $currentStep->update([
                    'state_task' => 'Complete',
                    'status_task' => 'Complete',
                ]);

                $findSourceReject = WorkStep::find($currentStep->reject_from_id);

                $findSourceReject->update([
                    'state_task' => 'Running',
                    'status_task' => 'Pending Approved',
                ]);

                $updateJobStatus = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                    'status_id' => 1,
                    'job_id' => $findSourceReject->work_step_list_id,
                ]);

                $currentStep->update([
                    'reject_from_id' => null,
                    'reject_from_status' => null,
                    'reject_from_job' => null,
                    'selesai' => Carbon::now()->toDateTimeString(),
                ]);

                $this->messageSent(['conversation' => 'SPK Perbaikan', 'instruction_id' => $this->instructionCurrentId, 'receiver' => $findSourceReject->user_id]);
                event(new IndexRenderEvent('refresh'));
            } else {
                if ($currentStep->flag == null) {
                    if ($currentStep) {
                        $currentStep->update([
                            'state_task' => 'Complete',
                            'status_task' => 'Complete',
                            'selesai' => Carbon::now()->toDateTimeString(),
                        ]);

                        // Cek apakah step berikutnya ada sebelum melanjutkan
                        if ($nextStep) {
                            $nextStep->update([
                                'state_task' => 'Running',
                                'status_task' => 'Pending Approved',
                            ]);

                            $updateJobStatus = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                                'job_id' => $nextStep->work_step_list_id,
                                'status_id' => 1,
                            ]);

                            //group
                            $dataInstruction = Instruction::find($this->instructionCurrentId);
                            if (isset($dataInstruction->group_id) && isset($dataInstruction->group_priority)) {
                                $datachild = Instruction::where('group_id', $dataInstruction->group_id)
                                    ->where('group_priority', 'child')
                                    ->get();

                                foreach ($datachild as $key => $item) {
                                    $updateChildWorkStep = WorkStep::where('instruction_id', $item['instruction_id'])
                                        ->where('work_step_list_id', $currentStep->work_step_list_id)
                                        ->where('user_id', $currentStep->user_id)
                                        ->first();

                                    if (isset($updateChildWorkStep)) {
                                        $updateChildWorkStep->update([
                                            'state_task' => 'Complete',
                                            'status_task' => 'Complete',
                                        ]);

                                        $updateChildNextWorkStep = WorkStep::where('instruction_id', $item['instruction_id'])
                                            ->where('step', $updateChildWorkStep->step + 1)
                                            ->first();

                                        $updateChildNextWorkStep->update([
                                            'state_task' => 'Running',
                                            'status_task' => 'Pending Approved',
                                        ]);

                                        $updateChildJobStatus = WorkStep::where('instruction_id', $item['instruction_id'])->update([
                                            'job_id' => $updateChildNextWorkStep->work_step_list_id,
                                            'status_id' => 1,
                                        ]);
                                    }
                                }
                            }
                        } else {
                            $updateSelesai = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                                'spk_status' => 'Selesai',
                                'state_task' => 'Complete',
                                'status_task' => 'Complete',
                            ]);

                            $updateJobStatus = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                                'job_id' => $currentStep->work_step_list_id,
                                'status_id' => 7,
                            ]);

                            //group
                            $dataInstruction = Instruction::find($this->instructionCurrentId);
                            if (isset($dataInstruction->group_id) && isset($dataInstruction->group_priority)) {
                                $datachild = Instruction::where('group_id', $dataInstruction->group_id)
                                    ->where('group_priority', 'child')
                                    ->get();

                                foreach ($datachild as $key => $item) {
                                    $updateChildWorkStep = WorkStep::where('instruction_id', $item['instruction_id'])
                                        ->where('work_step_list_id', $currentStep->work_step_list_id)
                                        ->where('user_id', $currentStep->user_id)
                                        ->first();

                                    if (isset($updateChildWorkStep)) {
                                        $updateChildWorkStep->update([
                                            'state_task' => 'Complete',
                                            'status_task' => 'Complete',
                                        ]);

                                        $updateChildJobStatus = WorkStep::where('instruction_id', $item['instruction_id'])->update([
                                            'spk_status' => 'Selesai',
                                            'state_task' => 'Complete',
                                            'status_task' => 'Complete',
                                            'job_id' => $currentStep->work_step_list_id,
                                            'status_id' => 7,
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }
                $this->messageSent(['conversation' => 'SPK Baru', 'instruction_id' => $this->instructionCurrentId, 'receiver' => $nextStep->user_id]);
                event(new IndexRenderEvent('refresh'));
            }

            $this->emit('flashMessage', [
                'type' => 'success',
                'title' => 'Setting Instruksi Kerja',
                'message' => 'Data Setting berhasil disimpan',
            ]);

            return redirect()->route('operator.dashboard');
        }
    }

    public function saveLayout()
    {
        $this->validate([
            'fileLayout' => 'required',
        ]);

        if ($this->catatanProsesPengerjaan) {
            $dataCatatanProsesPengerjaan = WorkStep::find($this->workStepCurrentId);

            // Ambil alasan pause yang sudah ada dari database
            $existingCatatanProsesPengerjaan = json_decode($dataCatatanProsesPengerjaan->catatan_proses_pengerjaan, true);

            // Tambahkan alasan pause yang baru ke dalam array existingCatatanProsesPengerjaan
            $timestampedKeterangan = $this->catatanProsesPengerjaan . ' - [' . now() . ']';
            $existingCatatanProsesPengerjaan[] = $timestampedKeterangan;

            // Simpan data ke database sebagai JSON
            $updateCatatanPengerjaan = WorkStep::where('id', $this->workStepCurrentId)->update([
                'catatan_proses_pengerjaan' => json_encode($existingCatatanProsesPengerjaan),
            ]);
        }

        if (isset($this->notes)) {
            $this->validate([
                'notes.*.tujuan' => 'required',
                'notes.*.catatan' => 'required',
            ]);

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

        $currentStep = WorkStep::find($this->workStepCurrentId);
        $nextStep = WorkStep::where('instruction_id', $this->instructionCurrentId)
            ->where('step', $currentStep->step + 1)
            ->first();

        $instructionData = Instruction::find($this->instructionCurrentId);
        $fileLayoutData = Files::where('instruction_id', $this->instructionCurrentId)
            ->where('type_file', 'layout')
            ->count();

        $folder = 'public/' . $instructionData->spk_number . '/setting';

        if ($nextStep->status_task == 'Waiting Revisi') {
            $nolayout = $fileLayoutData;
            foreach ($this->fileLayout as $file) {
                $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                $fileName = Carbon::now()->format('Ymd') . '-' . $instructionData->spk_number . '-file-layout-revisi-' . $nolayout . '.' . $extension;

                Storage::putFileAs($folder, $file, $fileName);
                $nolayout++;

                Files::create([
                    'instruction_id' => $this->instructionCurrentId,
                    'user_id' => Auth()->user()->id,
                    'type_file' => 'layout',
                    'file_name' => $fileName,
                    'file_path' => $folder,
                ]);
            }
        } else {
            $nolayout = $fileLayoutData;
            foreach ($this->fileLayout as $file) {
                $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);
                $fileName = Carbon::now()->format('Ymd') . '-' . $instructionData->spk_number . '-file-layout-' . $nolayout . '.' . $extension;

                Storage::putFileAs($folder, $file, $fileName);
                $nolayout++;

                Files::create([
                    'instruction_id' => $this->instructionCurrentId,
                    'user_id' => Auth()->user()->id,
                    'type_file' => 'layout',
                    'file_name' => $fileName,
                    'file_path' => $folder,
                ]);
            }
        }

        // Cek apakah $currentStep ada dan step berikutnya ada
        if ($currentStep) {
            $currentStep->update([
                'state_task' => 'Complete',
                'status_task' => 'Complete',
                'selesai' => Carbon::now()->toDateTimeString(),
            ]);

            // Cek apakah step berikutnya ada sebelum melanjutkan
            if ($nextStep) {
                $nextStep->update([
                    'state_task' => 'Running',
                    'status_task' => 'Pending Approved',
                ]);

                $updateJobStatus = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                    'job_id' => $nextStep->work_step_list_id,
                    'status_id' => 1,
                ]);
            }
        }

        $this->messageSent(['conversation' => 'SPK Baru', 'instruction_id' => $this->instructionCurrentId, 'receiver' => $nextStep->user_id]);
        event(new IndexRenderEvent('refresh'));

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Setting Instruksi Kerja',
            'message' => 'Data Setting berhasil disimpan',
        ]);

        return redirect()->route('operator.dashboard');
    }

    public function messageSent($arguments)
    {
        $createdMessage = 'info';
        $selectedConversation = $arguments['conversation'];
        $receiverUser = $arguments['receiver'];
        $instruction_id = $arguments['instruction_id'];

        event(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, $receiverUser));
    }
}
