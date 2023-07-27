<?php

namespace App\Http\Livewire\Component\Operator;

use Carbon\Carbon;
use App\Models\Files;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Keterangan;
use App\Models\WarnaPlate;
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
        $dataFileLayout = Files::where('instruction_id', $this->instructionCurrentId)->where('type_file', 'layout')->get();
        foreach($dataFileLayout as $dataFile){
            $fileLayout = [
                'id' => $dataFile['id'],
                'file_name' => $dataFile['file_name'],
                'file_path' => $dataFile['file_path'],
                'type_file' => $dataFile['type_file'],
            ];

            $this->fileLayoutData[] = $fileLayout;
        }

        if($this->dataInstruction->spk_type != 'layout'){
            $this->stateWorkStepPlate = WorkStep::where('instruction_id', $instructionId)->where('work_step_list_id', 7)->first();
            $this->stateWorkStepSablon = WorkStep::where('instruction_id', $instructionId)->where('work_step_list_id', 23)->first();
            $this->stateWorkStepPond = WorkStep::where('instruction_id', $instructionId)->where('work_step_list_id', 24)->first();
            $this->stateWorkStepCetakLabel = WorkStep::where('instruction_id', $instructionId)->where('work_step_list_id', 12)->first();
            $this->stateWorkStepFoil = WorkStep::where('instruction_id', $instructionId)->where('work_step_list_id', 28)->first();
            $this->stateWorkStepEmbossDeboss = WorkStep::where('instruction_id', $instructionId)->whereIn('work_step_list_id', [25, 26])->first();
            $this->stateWorkStepSpotUV = WorkStep::where('instruction_id', $instructionId)->where('work_step_list_id', 31)->first();
            $this->stateWorkStepUV = WorkStep::where('instruction_id', $instructionId)->where('work_step_list_id', 30)->first();

            $keteranganData = Keterangan::where('instruction_id', $this->instructionCurrentId)
                ->with('keteranganPlate', 'keteranganPisauPond', 'keteranganScreen', 'keteranganFoil', 'keteranganMatress', 'rincianPlate', 'rincianScreen', 'fileRincian', 'rincianPlate.warnaPlate')
                ->get();

            foreach ($keteranganData as $dataKeterangan) {
                $keterangan = [
                    'rincianPlate' => [],
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

            if(isset($this->stateWorkStepPond)){
                $dataPisauPond = [
                    'keperluan' => 'Pisau',
                    'ukuran_film' => '',
                    'jumlah_film' => '',
                ];

                $this->dataPisauPond = $dataPisauPond;
            }

            if(isset($this->stateWorkStepSablon)){
                $dataSablon = [
                    'keperluan' => 'Sablon',
                    'ukuran_film' => '',
                    'jumlah_film' => '',
                ];

                $this->dataSablon = $dataSablon;
            }

            if(isset($this->stateWorkStepFoil)){
                $dataFoil = [
                    'keperluan' => 'Foil',
                    'ukuran_film' => '',
                    'jumlah_film' => '',
                ];

                $this->dataFoil = $dataFoil;
            }

            if(isset($this->stateWorkStepEmbossDeboss)){
                $dataEmbossDeboss = [
                    'keperluan' => 'Emboss/Deboss',
                    'ukuran_film' => '',
                    'jumlah_film' => '',
                ];

                $this->dataEmbossDeboss = $dataEmbossDeboss;
            }

            if(isset($this->stateWorkStepSpotUV)){
                $dataSpotUV = [
                    'keperluan' => 'Spot UV',
                    'ukuran_film' => '',
                    'jumlah_film' => '',
                ];

                $this->dataSpotUV = $dataSpotUV;
            }

            if(isset($this->stateWorkStepUV)){
                $dataUV = [
                    'keperluan' => ' UV',
                    'ukuran_film' => '',
                    'jumlah_film' => '',
                ];

                $this->dataUV = $dataUV;
            }

            if(isset($this->stateWorkStepCetakLabel)){
                $dataCetakLabel = [
                    'keperluan' => ' Label',
                    'ukuran_film' => '',
                    'jumlah_film' => '',
                ];

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
        $this->validate([
            'keterangans.*.rincianPlate.*.name' => 'required',
            'keterangans.*.rincianPlate.*.rincianWarna.*.warna' => 'required',
        ],[
            'keterangans.*.rincianPlate.*.name.required' => 'Nama Plate Harus diisi.',
            'keterangans.*.rincianPlate.*.rincianWarna.*.warna.required' => 'Warna Harus diisi.',
        ]);

        
        if(isset($this->stateWorkStepFoil)){
            foreach ($this->keterangans as $index => $keterangan) {
                $this->keterangans[$index]['foil'] = array_filter($keterangan['foil'], function ($foil) {
                    return $foil['state_foil'] !== null || $foil['jumlah_foil'] !== null;
                });
            }

            $this->validate([        
                'keterangans' => 'required|array|min:1',
                'keterangans.*.foil' => 'required|array|min:1',
                'keterangans.*.foil.*.state_foil' => 'required',
                'keterangans.*.foil.*.jumlah_foil' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            ], [
                'keterangans.*.foil.required' => 'Setidaknya satu data foil harus diisi pada keterangan.',
                'keterangans.*.foil.min' => 'Setidaknya satu data foil harus diisi pada keterangan.',
                'keterangans.*.foil.*.state_foil.required' => 'State pada data foil harus diisi pada keterangan.',
                'keterangans.*.foil.*.jumlah_foil.required' => 'Jumlah foil harus diisi pada keterangan.',
                'keterangans.*.foil.*.jumlah_foil.numeric' => 'Jumlah foil harus berupa angka/tidak boleh ada tanda koma(,).',              
            ]);
        }
        
        if(isset($this->stateWorkStepEmbossDeboss)){
            foreach ($this->keterangans as $index => $keterangan) {
                $this->keterangans[$index]['matress'] = array_filter($keterangan['matress'], function ($matress) {
                    return $matress['state_matress'] !== null || $matress['jumlah_matress'] !== null;
                });
            }

            $this->validate([        
                'keterangans' => 'required|array|min:1',
                'keterangans.*.matress' => 'required|array|min:1',
                'keterangans.*.matress.*.state_matress' => 'required',
                'keterangans.*.matress.*.jumlah_matress' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            ], [
                'keterangans.*.matress.required' => 'Setidaknya satu data matress harus diisi pada keterangan.',
                'keterangans.*.matress.min' => 'Setidaknya satu data matress harus diisi pada keterangan.',
                'keterangans.*.matress.*.state_matress.required' => 'State pada data matress harus diisi pada keterangan.',
                'keterangans.*.matress.*.jumlah_matress.required' => 'Jumlah matress harus diisi pada keterangan.',
                'keterangans.*.matress.*.jumlah_matress.numeric' => 'Jumlah matress harus berupa angka/tidak boleh ada tanda koma(,).',              
            ]);
            
        }

        if(isset($this->stateWorkStepPond)){
            $this->validate([        
                'filePisauPond' => 'required',
                'dataPisauPond.keperluan' => 'required',
                'dataPisauPond.jumlah_film' => 'required',
                'dataPisauPond.ukuran_film' => 'required',
            ], [
                'filePisauPond.required' => 'File Pisau Pond harus diupload.',           
                'dataPisauPond.keperluan.required' => 'Data Pisau Pond harus diisi.',           
                'dataPisauPond.jumlah_film.required' => 'Data Pisau Pond harus diisi.',           
                'dataPisauPond.ukuran_film.required' => 'Data Pisau Pond harus diisi.',           
            ]);
        }

        $deleteWarna = WarnaPlate::where('instruction_id', $this->instructionCurrentId)->delete();

        foreach ($this->keterangans as $key => $item) {
            $keterangan = Keterangan::where('instruction_id', $this->instructionCurrentId)->where('form_id', $key)->first();
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
                    ]
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

            if(isset($item['foil'])){
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

            if(isset($item['matress'])){
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

        $currentStep = WorkStep::find($this->workStepCurrentId);
        $nextStep = WorkStep::where('instruction_id', $this->instructionCurrentId)
                ->where('step', $currentStep->step + 1)
                ->first();

        if($this->catatanProsesPengerjaan){
            $dataCatatanProsesPengerjaan = WorkStep::find($this->workStepCurrentId);

            // Ambil alasan pause yang sudah ada dari database
            $existingCatatanProsesPengerjaan = json_decode($dataCatatanProsesPengerjaan->alasan_pause, true);

            // Tambahkan alasan pause yang baru ke dalam array existingCatatanProsesPengerjaan
            $timestampedKeterangan = $this->catatanProsesPengerjaan . ' - [' . now() . ']';
            $existingCatatanProsesPengerjaan[] = $timestampedKeterangan;

            // Simpan data ke database sebagai JSON
            $updateCatatanPengerjaan = WorkStep::where('id', $this->workStepCurrentId)->update([
                'catatan_proses_pengerjaan' => json_encode($existingCatatanProsesPengerjaan),
            ]);
        }

        // Cek apakah $currentStep ada dan step berikutnya ada
        if ($currentStep) {
            $currentStep->update([
                'state_task' => 'Complete',
                'status_task' => 'Complete',
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
        broadcast(new IndexRenderEvent('refresh'));

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Setting Instruksi Kerja',
            'message' => 'Data Setting berhasil disimpan',
        ]);

        return redirect()->route('operator.dashboard');
    }

    public function saveLayout()
    {
        $this->validate([
            'fileLayout' => 'required',
        ]);
        $currentStep = WorkStep::find($this->workStepCurrentId);
        $nextStep = WorkStep::where('instruction_id', $this->instructionCurrentId)
                ->where('step', $currentStep->step + 1)
                ->first();

        $instructionData = Instruction::find($this->instructionCurrentId);
        $fileLayoutData = Files::where('instruction_id', $this->instructionCurrentId)->where('type_file', 'layout')->count();
        
        $folder = "public/".$instructionData->spk_number."/setting";

        if($nextStep->status_task == 'Waiting Revisi'){
            $nolayout = $fileLayoutData;
            foreach ($this->fileLayout as $file) {
                $fileName = Carbon::now()->format('Ymd') . '-' . $instructionData->spk_number . '-file-layout-revisi-'.$nolayout . '.' . $file->getClientOriginalExtension();
                Storage::putFileAs($folder, $file, $fileName);
                $nolayout ++;
    
                Files::create([
                    'instruction_id' => $this->instructionCurrentId,
                    "user_id" => Auth()->user()->id,
                    "type_file" => "layout",
                    "file_name" => $fileName,
                    "file_path" => $folder,
                ]);
            }
        }else{
            $nolayout = $fileLayoutData;
            foreach ($this->fileLayout as $file) {
                $fileName = Carbon::now()->format('Ymd') . '-' . $instructionData->spk_number . '-file-layout-'.$nolayout . '.' . $file->getClientOriginalExtension();
                Storage::putFileAs($folder, $file, $fileName);
                $nolayout ++;

                Files::create([
                    'instruction_id' => $this->instructionCurrentId,
                    "user_id" => Auth()->user()->id,
                    "type_file" => "layout",
                    "file_name" => $fileName,
                    "file_path" => $folder,
                ]);
            }
        }
        
        if($this->catatanProsesPengerjaan){
            $dataCatatanProsesPengerjaan = WorkStep::find($this->workStepCurrentId);

            // Ambil alasan pause yang sudah ada dari database
            $existingCatatanProsesPengerjaan = json_decode($dataCatatanProsesPengerjaan->alasan_pause, true);

            // Tambahkan alasan pause yang baru ke dalam array existingCatatanProsesPengerjaan
            $timestampedKeterangan = $this->catatanProsesPengerjaan . ' - [' . now() . ']';
            $existingCatatanProsesPengerjaan[] = $timestampedKeterangan;

            // Simpan data ke database sebagai JSON
            $updateCatatanPengerjaan = WorkStep::where('id', $this->workStepCurrentId)->update([
                'catatan_proses_pengerjaan' => json_encode($existingCatatanProsesPengerjaan),
            ]);
        }

        // Cek apakah $currentStep ada dan step berikutnya ada
        if ($currentStep) {
            $currentStep->update([
                'state_task' => 'Complete',
                'status_task' => 'Complete',
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
        broadcast(new IndexRenderEvent('refresh'));

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Setting Instruksi Kerja',
            'message' => 'Data Setting berhasil disimpan',
        ]);

        return redirect()->route('operator.dashboard');
    }

    public function messageSent($arguments)
    {
        $createdMessage = "info";
        $selectedConversation = $arguments['conversation'];
        $receiverUser = $arguments['receiver'];
        $instruction_id = $arguments['instruction_id'];

        broadcast(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, $receiverUser));
    }
}
