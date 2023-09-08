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
use App\Models\FormSortir;
use App\Models\FileSetting;
use App\Models\Instruction;
use App\Models\RincianPlate;
use App\Models\FormFinishing;
use Livewire\WithFileUploads;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use App\Models\FormOtherWorkStep;
use Illuminate\Support\Facades\Storage;

class FormSortirIndex extends Component
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
    public $workStepsBefore;
    public $workStepsAfter;

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

        $this->workStepData = WorkStep::find($workStepId);
        $this->catatanData = Catatan::where('instruction_id', $instructionId)
            ->where('user_id', $this->workStepData->user_id)
            ->where('kategori', 'catatan')
            ->get();

        $this->dataAnggota = User::where('jobdesk', 'Team Finishing')->get();

        $this->workSteps = WorkStep::where('instruction_id', $instructionId)
            ->with('workStepList')
            ->get();

        $dataWorkStepBefore = WorkStep::where('instruction_id', $instructionId)
            ->where('step', $dataWorkStep->step - 1)
            ->with('workStepList')
            ->first();
        $workStepsAfter = WorkStep::where('instruction_id', $instructionId)
            ->where('step', $dataWorkStep->step + 1)
            ->with('workStepList')
            ->first();

        $this->workStepsBefore = $dataWorkStepBefore->workStepList->name;
        $this->workStepsAfter = $workStepsAfter->workStepList->name;

        $dataSortir = FormSortir::where('instruction_id', $this->instructionCurrentId)
            ->where('jenis_pekerjaan', $dataWorkStep->workStepList->name)
            ->where('pekerjaan_sebelum', $this->workStepsBefore)
            ->where('pekerjaan_sesudah', $this->workStepsAfter)
            ->first();

        if (isset($dataSortir)) {
            $this->jenis_pekerjaan = $dataSortir['jenis_pekerjaan'];
            $this->hasil_akhir = $dataSortir['hasil_akhir'];
            $this->jumlah_barang_gagal = $dataSortir['jumlah_barang_gagal'];
            $this->satuan = $dataSortir['satuan'];
        } else {
            $this->jenis_pekerjaan = $dataWorkStep->workStepList->name;
            $this->hasil_akhir = '';
            $this->jumlah_barang_gagal = '';
            $this->satuan = '';
        }

        $dataAnggotaCurrent = FormSortir::where('instruction_id', $this->instructionCurrentId)
            ->where('jenis_pekerjaan', $dataWorkStep->workStepList->name)
            ->where('pekerjaan_sebelum', $this->workStepsBefore)
            ->where('pekerjaan_sesudah', $this->workStepsAfter)
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
    }

    public function render()
    {
        return view('livewire.component.details.form-sortir-index');
    }
}
