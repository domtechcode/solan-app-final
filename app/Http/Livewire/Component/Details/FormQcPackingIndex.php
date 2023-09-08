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
use App\Models\FormQcPacking;
use Livewire\WithFileUploads;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Storage;

class FormQcPackingIndex extends Component
{
    use WithFileUploads;
    public $instructionCurrentId;
    public $workStepCurrentId;
    public $dataInstruction;
    public $dataWorkSteps;
    public $hasil_akhir;
    public $jumlah_barang_gagal;
    public $jumlah_stock;
    public $lokasi_stock;
    public $catatanProsesPengerjaan;
    public $dataAnggota;
    public $anggota = [];

    public $workStepData;
    public $catatanData;

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
        $this->dataWorkSteps = WorkStep::find($workStepId);

        $this->workStepData = WorkStep::find($workStepId);
        $this->catatanData = Catatan::where('instruction_id', $instructionId)
            ->where('user_id', $this->workStepData->user_id)
            ->where('kategori', 'catatan')
            ->get();

        $this->dataAnggota = User::where('jobdesk', 'Team Qc Packing')->get();
        $dataQcPacking = FormQcPacking::where('instruction_id', $this->instructionCurrentId)->first();
        if (isset($dataQcPacking)) {
            $this->hasil_akhir = $dataQcPacking['hasil_akhir'];
            $this->jumlah_barang_gagal = $dataQcPacking['jumlah_barang_gagal'];
            $this->jumlah_stock = $dataQcPacking['jumlah_stock'];
            $this->lokasi_stock = $dataQcPacking['lokasi_stock'];
        } else {
            $this->hasil_akhir = '';
            $this->jumlah_barang_gagal = '';
            $this->jumlah_stock = '';
            $this->lokasi_stock = '';
        }

        $dataAnggotaCurrent = FormQcPacking::where('instruction_id', $this->instructionCurrentId)->get();
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
        return view('livewire.component.details.form-qc-packing-index');
    }
}
