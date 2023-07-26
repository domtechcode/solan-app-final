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
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Storage;

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

    public function addWarnaField($keteranganIndex, $rincianIndexPlate)
    {
        $this->keterangans[$keteranganIndex]['rincianPlate'][$rincianIndexPlate]['rincianWarna'][] = '';
    }

    public function removeRincianPlate($keteranganIndex, $rincianIndexPlate)
    {
        unset($this->keterangans[$keteranganIndex]['rincianPlate'][$rincianIndexPlate]);
        $this->keterangans[$keteranganIndex]['rincianPlate'] = array_values($this->keterangans[$keteranganIndex]['rincianPlate']);
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
            $keteranganData = Keterangan::where('instruction_id', $this->instructionCurrentId)
                ->with('keteranganPlate', 'keteranganPisauPond', 'keteranganScreen', 'rincianPlate', 'rincianScreen', 'fileRincian', 'rincianPlate.warnaPlate')
                ->get();

            foreach ($keteranganData as $dataKeterangan) {
                $keterangan = [
                    'rincianPlate' => [],
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

                $this->keterangans[] = $keterangan;
            }

        }
    }

    public function render()
    {
        return view('livewire.component.operator.form-setting-index');
    }

    public function saveSampleAndProduction()
    {
        foreach ($this->keterangans as $key => $item) {
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
        }

        $updateRincianPlateDeleted = RincianPlate::where('instruction_id', $this->instructionCurrentId)
                    ->whereNull('name')
                    ->update([
                        'status' => 'Deleted by Setting',
                    ]);
        
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
