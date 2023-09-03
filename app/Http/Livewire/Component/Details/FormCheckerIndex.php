<?php

namespace App\Http\Livewire\Component\Details;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\FileSetting;
use App\Models\Instruction;
use Livewire\WithFileUploads;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Storage;

class FormCheckerIndex extends Component
{
    use WithFileUploads;
    public $fileLayout = [];
    public $fileLayoutData = [];
    public $fileFilmData = [];
    public $fileChecker = [];
    public $instructionCurrentId;
    public $workStepCurrentId;
    public $dataInstruction;
    public $catatanProsesPengerjaan;
    public $catatanRevisi;
    public $historyRevisi;

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
        $dataFileLayout = Files::where('instruction_id', $this->instructionCurrentId)
            ->where('type_file', 'layout')
            ->get();

        $this->workSteps = WorkStep::where('instruction_id', $instructionId)
            ->with('workStepList')
            ->get();

        $this->workStepData = WorkStep::find($workStepId);

        $this->catatanData = Catatan::where('instruction_id', $instructionId)
            ->where('user_id', $this->workStepData->user_id)
            ->where('kategori', 'catatan')
            ->get();

        if (isset($dataFileLayout)) {
            foreach ($dataFileLayout as $dataFile) {
                $fileLayout = [
                    'id' => $dataFile['id'],
                    'file_name' => $dataFile['file_name'],
                    'file_path' => $dataFile['file_path'],
                    'type_file' => $dataFile['type_file'],
                ];

                $this->fileLayoutData[] = $fileLayout;
            }
        }

        $dataFileFilm = FileSetting::where('instruction_id', $this->instructionCurrentId)->get();
        if (isset($dataFileFilm)) {
            foreach ($dataFileFilm as $dataFile) {
                $fileFilm = [
                    'id' => $dataFile['id'],
                    'file_name' => $dataFile['file_name'],
                    'file_path' => $dataFile['file_path'],
                    'keperluan' => $dataFile['keperluan'],
                    'jumlah_film' => $dataFile['jumlah_film'],
                    'ukuran_film' => $dataFile['ukuran_film'],
                ];

                $this->fileFilmData[] = $fileFilm;
            }
        }

        $this->historyRevisi = Catatan::where('instruction_id', $this->instructionCurrentId)
            ->where('tujuan', 6)
            ->where('kategori', 'revisi')
            ->get();
    }

    public function render()
    {
        return view('livewire.component.details.form-checker-index');
    }
}
