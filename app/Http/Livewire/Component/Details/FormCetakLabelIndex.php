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
use App\Models\FormCetakLabel;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Storage;

class FormCetakLabelIndex extends Component
{
    use WithFileUploads;
    public $instructionCurrentId;
    public $workStepCurrentId;
    public $dataInstruction;
    public $hasil_akhir;
    public $catatanProsesPengerjaan;

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
        $dataCetakLabel = FormCetakLabel::where('instruction_id', $this->instructionCurrentId)->first();
        $this->workSteps = WorkStep::where('instruction_id', $instructionId)
            ->with('workStepList')
            ->get();

            $this->workStepData = WorkStep::find($workStepId);
        $this->catatanData = Catatan::where('instruction_id', $instructionId)
            ->where('user_id', $this->workStepData->user_id)
            ->where('kategori', 'catatan')
            ->get();


        if (isset($dataCetakLabel)) {
            $this->hasil_akhir = $dataCetakLabel['hasil_akhir'];
        } else {
            $this->hasil_akhir = '';
        }
    }

    public function render()
    {
        return view('livewire.component.details.form-cetak-label-index');
    }
}
