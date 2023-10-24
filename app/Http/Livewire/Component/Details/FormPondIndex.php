<?php

namespace App\Http\Livewire\Component\Details;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
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

class FormPondIndex extends Component
{
    use WithFileUploads;
    public $instructionCurrentId;
    public $workStepCurrentId;
    public $dataInstruction;
    public $dataWorkSteps;
    public $jenis_pekerjaan;
    public $hasil_akhir;
    public $nama_pisau;
    public $lokasi_pisau;
    public $status_pisau;
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

        $this->workSteps = WorkStep::where('instruction_id', $instructionId)
            ->with('workStepList')
            ->get();

        $dataPond = FormPond::where('instruction_id', $this->instructionCurrentId)
            ->where('jenis_pekerjaan', $dataWorkStep->workStepList->name)
            ->where('user_id', $dataWorkStep->user_id)
            ->where('step', $dataWorkStep->step)
            ->first();

        if (isset($dataPond)) {
            $this->jenis_pekerjaan = $dataPond['jenis_pekerjaan'];
            $this->hasil_akhir = $dataPond['hasil_akhir'];
            $this->nama_pisau = $dataPond['nama_pisau'];
            $this->lokasi_pisau = $dataPond['lokasi_pisau'];
            $this->status_pisau = $dataPond['status_pisau'];
            $this->nama_matress = $dataPond['nama_matress'];
            $this->lokasi_matress = $dataPond['lokasi_matress'];
            $this->status_matress = $dataPond['status_matress'];

            $dataPondGet = FormPond::where('instruction_id', $this->instructionCurrentId)
                ->where('jenis_pekerjaan', $dataWorkStep->workStepList->name)
                ->where('user_id', $dataWorkStep->user_id)
                ->where('step', $dataWorkStep->step)
                ->get();

            foreach ($dataPondGet as $dataHasilAkhirPond) {
                $rincianPlateDataHasilAkhir = [
                    'state' => $dataHasilAkhirPond['state'],
                    'plate' => $dataHasilAkhirPond['plate'],
                    'jumlah_lembar_cetak' => $dataHasilAkhirPond['jumlah_lembar_cetak'],
                    'waste' => $dataHasilAkhirPond['waste'],
                    'hasil_akhir_lembar_cetak_plate' => $dataHasilAkhirPond['hasil_akhir_lembar_cetak_plate'],
                    'hasil_akhir' => $dataHasilAkhirPond['hasil_akhir'],
                ];

                $this->dataHasilAkhir[] = $rincianPlateDataHasilAkhir;
            }
        } else {
            $this->jenis_pekerjaan = $dataWorkStep->workStepList->name;
            $this->hasil_akhir = null;
            $this->nama_pisau = null;
            $this->lokasi_pisau = null;
            $this->status_pisau = null;
            $this->nama_matress = null;
            $this->lokasi_matress = null;
            $this->status_matress = null;

            $dataRincianPlateHasilAkhir = RincianPlate::where('instruction_id', $instructionId)->get();

            if (isset($dataRincianPlateHasilAkhir)) {
                $this->dataHasilAkhir = [];

                foreach ($dataRincianPlateHasilAkhir as $dataHasilAkhirPond) {
                    $rincianPlateDataHasilAkhir = [
                        'state' => $dataHasilAkhirPond->state,
                        'plate' => $dataHasilAkhirPond->plate,
                        'jumlah_lembar_cetak' => $dataHasilAkhirPond->jumlah_lembar_cetak,
                        'waste' => $dataHasilAkhirPond->waste,
                        'hasil_akhir_lembar_cetak_plate' => $dataHasilAkhirPond->hasil_akhir_lembar_cetak_plate,
                    ];

                    $this->dataHasilAkhir[] = $rincianPlateDataHasilAkhir;
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.component.details.form-pond-index');
    }
}
