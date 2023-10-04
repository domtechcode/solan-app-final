<?php

namespace App\Http\Livewire\Component\Details;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\FormFoil;
use App\Models\FormPond;
use App\Models\WorkStep;
use App\Models\FormPlate;
use App\Models\FileSetting;
use App\Models\Instruction;
use App\Models\RincianPlate;
use Livewire\WithFileUploads;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Storage;

class FormFoilIndex extends Component
{
    use WithFileUploads;
    public $instructionCurrentId;
    public $workStepCurrentId;
    public $dataInstruction;
    public $hasil_akhir;
    public $nama_matress;
    public $lokasi_matress;
    public $status_matress;
    public $catatanProsesPengerjaan;

    public $dataHasilAkhir = [];

    public $notes = [];
    public $workSteps;

    public $workStepData;
    public $catatanData;

    public function addEmptyNote()
    {
        $this->notes[] = '';
    }

    public function removeNote($index)
    {
        unset($this->notes[$index]);
        $this->notes = array_values($this->notes);
    }

    public function mount($instructionId, $workStepId)
    {
        $this->instructionCurrentId = $instructionId;
        $this->workStepCurrentId = $workStepId;
        $this->dataInstruction = Instruction::find($this->instructionCurrentId);
        $dataWorkStep = WorkStep::find($workStepId);
        $this->dataWorkSteps = WorkStep::find($workStepId);

        $this->workStepData = WorkStep::find($workStepId);
        $this->catatanData = Catatan::where('instruction_id', $instructionId)
            ->where('user_id', $this->workStepData->user_id)
            ->where('kategori', 'catatan')
            ->get();


        $dataFoil = FormFoil::where('instruction_id', $this->instructionCurrentId)
            ->where('user_id', $this->workStepData->user_id)
            ->where('step', $dataWorkStep->step)
            ->first();

        $this->workSteps = WorkStep::where('instruction_id', $instructionId)
            ->with('workStepList')
            ->get();

        if (isset($dataFoil)) {
            $this->hasil_akhir = $dataFoil['hasil_akhir'];
            $this->nama_matress = $dataFoil['nama_matress'];
            $this->lokasi_matress = $dataFoil['lokasi_matress'];
            $this->status_matress = $dataFoil['status_matress'];

            $dataFoil = FormFoil::where('instruction_id', $this->instructionCurrentId)
                ->where('user_id', $this->workStepData->user_id)
                ->where('step', $dataWorkStep->step)
                ->get();
            foreach ($dataFoil as $dataHasilAkhirFoil) {
                $rincianPlateDataHasilAkhir = [
                    'state' => $dataHasilAkhirFoil['state'],
                    'plate' => $dataHasilAkhirFoil['plate'],
                    'jumlah_lembar_cetak' => $dataHasilAkhirFoil['jumlah_lembar_cetak'],
                    'waste' => $dataHasilAkhirFoil['waste'],
                    'hasil_akhir_lembar_cetak_plate' => $dataHasilAkhirFoil['hasil_akhir_lembar_cetak_plate'],
                ];

                $this->dataHasilAkhir[] = $rincianPlateDataHasilAkhir;
            }
        } else {
            $this->hasil_akhir = null;
            $this->nama_matress = null;
            $this->lokasi_matress = null;
            $this->status_matress = null;

            $dataRincianPlateHasilAkhir = RincianPlate::where('instruction_id', $instructionId)->get();

            if (isset($dataRincianPlateHasilAkhir)) {
                $this->dataHasilAkhir = [];

                foreach ($dataRincianPlateHasilAkhir as $dataHasilAkhirPlate) {
                    $rincianPlateDataHasilAkhir = [
                        'state' => $dataHasilAkhirPlate->state,
                        'plate' => $dataHasilAkhirPlate->plate,
                        'jumlah_lembar_cetak' => $dataHasilAkhirPlate->jumlah_lembar_cetak,
                        'waste' => $dataHasilAkhirPlate->waste,
                        'hasil_akhir_lembar_cetak_plate' => null,
                    ];

                    $this->dataHasilAkhir[] = $rincianPlateDataHasilAkhir;
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.component.details.form-foil-index');
    }
}
