<?php

namespace App\Http\Livewire\Component\Details;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\FormPlate;
use App\Models\FormSablon;
use App\Models\FileSetting;
use App\Models\Instruction;
use Livewire\WithFileUploads;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Storage;

class FormSablonIndex extends Component
{
    use WithFileUploads;
    public $instructionCurrentId;
    public $workStepCurrentId;
    public $dataInstruction;
    public $hasil_akhir_sablon;
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
        $dataSablon = FormSablon::where('instruction_id', $this->instructionCurrentId)->first();

        $this->workSteps = WorkStep::where('instruction_id', $instructionId)
            ->with('workStepList')
            ->get();

        $this->workStepData = WorkStep::find($workStepId);
        $this->catatanData = Catatan::where('instruction_id', $instructionId)
            ->where('user_id', $this->workStepData->user_id)
            ->where('kategori', 'catatan')
            ->get();

        if (isset($dataSablon)) {
            $this->hasil_akhir_sablon = $dataSablon['hasil_akhir_sablon'];
        } else {
            $this->hasil_akhir_sablon = '';
        }
    }

    public function render()
    {
        return view('livewire.component.details.form-sablon-index');
    }
}
