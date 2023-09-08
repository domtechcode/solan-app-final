<?php

namespace App\Http\Livewire\Component\Details;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\FormCetak;
use App\Models\FormPlate;
use App\Models\WarnaPlate;
use App\Models\FileSetting;
use App\Models\Instruction;
use App\Models\RincianPlate;
use Livewire\WithFileUploads;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Storage;

class FormCetakIndex extends Component
{
    use WithFileUploads;
    public $instructionCurrentId;
    public $workStepCurrentId;
    public $dataInstruction;
    public $hasil_akhir_lembar_cetak;
    public $catatanProsesPengerjaan;
    public $de;
    public $l;
    public $a;
    public $b;
    public $dataWarna = [];
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
        $dataRincianPlate = RincianPlate::where('instruction_id', $instructionId)->first();

        $this->workStepData = WorkStep::find($workStepId);
        $this->catatanData = Catatan::where('instruction_id', $instructionId)
            ->where('user_id', $this->workStepData->user_id)
            ->where('kategori', 'catatan')
            ->get();

        $dataFormCetak = FormCetak::where('instruction_id', $instructionId)
            ->where('user_id', Auth()->user()->id)
            ->where('step', $dataWorkStep->step)
            ->first();

        if (isset($dataFormCetak)) {
            $this->hasil_akhir_lembar_cetak = $dataFormCetak['hasil_akhir_lembar_cetak'];

            $dataCetak = FormCetak::where('instruction_id', $instructionId)
                ->where('user_id', Auth()->user()->id)
                ->where('step', $dataWorkStep->step)
                ->get();

            foreach ($dataCetak as $dataHasilAkhirCetak) {
                $rincianPlateDataHasilAkhir = [
                    'state' => $dataHasilAkhirCetak['state'],
                    'plate' => $dataHasilAkhirCetak['plate'],
                    'jumlah_lembar_cetak' => $dataHasilAkhirCetak['jumlah_lembar_cetak'],
                    'waste' => $dataHasilAkhirCetak['waste'],
                    'hasil_akhir_lembar_cetak_plate' => $dataHasilAkhirCetak['hasil_akhir_lembar_cetak_plate'],
                ];

                $this->dataHasilAkhir[] = $rincianPlateDataHasilAkhir;
            }
        } else {
            $dataRincianPlateHasilAkhir = RincianPlate::where('instruction_id', $instructionId)->get();

            if (isset($dataRincianPlateHasilAkhir)) {
                $this->dataHasilAkhir = [];

                foreach ($dataRincianPlateHasilAkhir as $dataHasilAkhirPond) {
                    $rincianPlateDataHasilAkhir = [
                        'state' => $dataHasilAkhirPond->state,
                        'plate' => $dataHasilAkhirPond->plate,
                        'jumlah_lembar_cetak' => $dataHasilAkhirPond->jumlah_lembar_cetak,
                        'waste' => $dataHasilAkhirPond->waste,
                        'hasil_akhir_lembar_cetak_plate' => null,
                    ];

                    $this->dataHasilAkhir[] = $rincianPlateDataHasilAkhir;
                }
            }
        }

        $this->workSteps = WorkStep::where('instruction_id', $instructionId)
            ->with('workStepList')
            ->get();

        if (isset($dataRincianPlate)) {
            $this->de = $dataRincianPlate['de'];
            $this->l = $dataRincianPlate['l'];
            $this->a = $dataRincianPlate['a'];
            $this->b = $dataRincianPlate['b'];
        } else {
            $this->de = null;
            $this->l = null;
            $this->a = null;
            $this->b = null;
        }

        $dataWarnaPlate = RincianPlate::where('instruction_id', $instructionId)
            ->with('warnaPlate')
            ->get();

        if (isset($dataWarnaPlate)) {
            $this->dataWarna = [];

            foreach ($dataWarnaPlate as $dataPlate) {
                $rincianPlateData = [
                    'id' => $dataPlate->id,
                    'plate' => $dataPlate->plate,
                    'name' => $dataPlate->name,
                    'warnaCetak' => [],
                ];

                if ($dataPlate->warnaPlate->isNotEmpty()) {
                    foreach ($dataPlate->warnaPlate as $warnaPlate) {
                        $rincianPlateData['warnaCetak'][] = [
                            'id' => $warnaPlate->id,
                            'warna' => $warnaPlate->warna,
                            'keterangan' => $warnaPlate->keterangan,
                            'de' => $warnaPlate->de,
                            'l' => $warnaPlate->l,
                            'a' => $warnaPlate->a,
                            'b' => $warnaPlate->b,
                        ];
                    }
                }

                $this->dataWarna['rincianPlate'][] = $rincianPlateData;
            }
        } else {
            $this->dataWarna['rincianPlate'][] = [
                'id' => null,
                'plate' => null,
                'name' => null,
                'warnaCetak' => [
                    [
                        'id' => null,
                        'warna' => null,
                        'keterangan' => null,
                        'de' => null,
                        'l' => null,
                        'a' => null,
                        'b' => null,
                    ],
                ],
            ];
        }
    }

    public function render()
    {
        return view('livewire.component.details.form-cetak-index');
    }
}
