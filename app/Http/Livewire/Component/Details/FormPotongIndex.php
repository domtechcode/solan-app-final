<?php

namespace App\Http\Livewire\Component\Details;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\FormPlate;
use App\Models\FileSetting;
use App\Models\Instruction;
use App\Models\RincianPlate;
use Livewire\WithFileUploads;
use App\Models\FormPotongJadi;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Storage;

class FormPotongIndex extends Component
{
    use WithFileUploads;
    public $instructionCurrentId;
    public $workStepCurrentId;
    public $dataInstruction;
    public $catatanProsesPengerjaan;
    public $stateWorkStep;
    public $hasil_akhir;
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
        $dataWorkStep = WorkStep::find($this->workStepCurrentId);

        $this->stateWorkStep = $dataWorkStep->work_step_list_id;

        $this->workSteps = WorkStep::where('instruction_id', $instructionId)
            ->with('workStepList')
            ->get();

        $this->workStepData = WorkStep::find($workStepId);
        $this->catatanData = Catatan::where('instruction_id', $instructionId)
            ->where('user_id', $this->workStepData->user_id)
            ->where('kategori', 'catatan')
            ->get();

        if ($dataWorkStep->work_step_list_id == 9) {
            $currentPotongJadi = FormPotongJadi::where('instruction_id', $this->instructionCurrentId)
                ->where('step', $dataWorkStep->step)
                ->where('user_id', Auth()->user()->id)
                ->first();

            if (isset($currentPotongJadi)) {
                $this->hasil_akhir = $currentPotongJadi->hasil_akhir;

                $dataRincianPlateHasilAkhir = FormPotongJadi::where('instruction_id', $this->instructionCurrentId)
                    ->where('step', $dataWorkStep->step)
                    ->where('user_id', Auth()->user()->id)
                    ->get();

                if (isset($dataRincianPlateHasilAkhir)) {
                    $this->dataHasilAkhir = [];
                    foreach ($dataRincianPlateHasilAkhir as $dataHasilAkhirPlate) {
                        $rincianPlateDataHasilAkhir = [
                            'rincian_plate_id' => $dataHasilAkhirPlate->rincian_plate_id,
                            'state' => $dataHasilAkhirPlate->state,
                            'plate' => $dataHasilAkhirPlate->plate,
                            'jumlah_lembar_cetak' => $dataHasilAkhirPlate->jumlah_lembar_cetak,
                            'waste' => $dataHasilAkhirPlate->waste,
                            'hasil_akhir_lembar_cetak_plate' => $dataHasilAkhirPlate->hasil_akhir_lembar_cetak_plate,
                        ];

                        $this->dataHasilAkhir[] = $rincianPlateDataHasilAkhir;
                    }
                }
            } else {
                $this->hasil_akhir = null;

                $dataRincianPlateHasilAkhir = RincianPlate::where('instruction_id', $instructionId)->get();

                if (isset($dataRincianPlateHasilAkhir)) {
                    $this->dataHasilAkhir = [];

                    foreach ($dataRincianPlateHasilAkhir as $dataHasilAkhirPlate) {
                        $rincianPlateDataHasilAkhir = [
                            'state' => $dataHasilAkhirPlate->state,
                            'plate' => $dataHasilAkhirPlate->plate,
                            'jumlah_lembar_cetak' => $dataHasilAkhirPlate->jumlah_lembar_cetak,
                            'waste' => $dataHasilAkhirPlate->waste,
                            'hasil_akhir_lembar_cetak_plate' => '',
                        ];

                        $this->dataHasilAkhir[] = $rincianPlateDataHasilAkhir;
                    }
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.component.details.form-potong-index');
    }
}
