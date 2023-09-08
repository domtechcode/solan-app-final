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
use App\Models\FormFinishing;
use Livewire\WithFileUploads;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use App\Models\FormOtherWorkStep;
use Illuminate\Support\Facades\Storage;

class FormOtherWorkStepIndex extends Component
{
    use WithFileUploads;
    public $instructionCurrentId;
    public $workStepCurrentId;
    public $dataInstruction;
    public $jenis_pekerjaan;
    public $hasil_akhir;
    public $satuan;
    public $dataAnggota;
    public $anggota = [];
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

    public function addAnggota()
    {
        $this->anggota[] = ['nama' => '', 'hasil' => ''];
    }

    public function removeAnggota($index)
    {
        unset($this->anggota[$index]);
        $this->anggota = array_values($this->anggota);
    }

    public function mount($instructionId, $workStepId)
    {
        $this->instructionCurrentId = $instructionId;
        $this->workStepCurrentId = $workStepId;
        $this->dataInstruction = Instruction::find($this->instructionCurrentId);
        $dataWorkStep = WorkStep::find($workStepId);
        $this->dataAnggota = User::where('jobdesk', 'Team Finishing')->get();

        $this->workStepData = WorkStep::find($workStepId);
        $this->catatanData = Catatan::where('instruction_id', $instructionId)
            ->where('user_id', $this->workStepData->user_id)
            ->where('kategori', 'catatan')
            ->get();

        $this->workSteps = WorkStep::where('instruction_id', $instructionId)
            ->with('workStepList')
            ->get();

        if (Auth()->user()->jobdesk == 'Finishing') {
            $dataOtherFinishing = FormFinishing::where('instruction_id', $this->instructionCurrentId)
                ->where('jenis_pekerjaan', $dataWorkStep->workStepList->name)
                ->first();
            if (isset($dataOtherFinishing)) {
                $this->jenis_pekerjaan = $dataOtherFinishing['jenis_pekerjaan'];
                $this->hasil_akhir = $dataOtherFinishing['hasil_akhir'];
                $this->satuan = $dataOtherFinishing['satuan'];
            } else {
                $this->jenis_pekerjaan = $dataWorkStep->workStepList->name;
                $this->hasil_akhir = '';
                $this->satuan = '';
            }

            $dataAnggotaCurrent = FormFinishing::where('instruction_id', $this->instructionCurrentId)
                ->where('jenis_pekerjaan', $dataWorkStep->workStepList->name)
                ->get();
            if (isset($dataAnggotaCurrent)) {
                foreach ($dataAnggotaCurrent as $item) {
                    $anggota = [
                        'nama' => $item['nama_anggota'],
                        'hasil' => $item['hasil_per_anggota'],
                    ];

                    $this->anggota[] = $anggota;
                }
            }

            if (empty($this->anggota)) {
                $this->anggota[] = [
                    'nama' => '',
                    'hasil' => '',
                ];
            }
        } else {
            $dataOtherWorkStep = FormOtherWorkStep::where('instruction_id', $this->instructionCurrentId)
                ->where('jenis_pekerjaan', $dataWorkStep->workStepList->name)
                ->first();

            if (isset($dataOtherWorkStep)) {
                $this->jenis_pekerjaan = $dataOtherWorkStep['jenis_pekerjaan'];
                $this->hasil_akhir = $dataOtherWorkStep['hasil_akhir'];
                $this->satuan = $dataOtherWorkStep['satuan'];
            } else {
                $this->jenis_pekerjaan = $dataWorkStep->workStepList->name;
                $this->hasil_akhir = '';
                $this->satuan = '';
            }
        }
    }

    public function render()
    {
        return view('livewire.component.details.form-other-work-step-index');
    }
}
