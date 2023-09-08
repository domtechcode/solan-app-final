<?php

namespace App\Http\Livewire\Component\Details;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Files;
use App\Models\Driver;
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
use App\Models\FormPengiriman;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use App\Models\PengajuanKekuranganQc;
use Illuminate\Support\Facades\Storage;

class FormPengirimanIndex extends Component
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
    public $dataDriver;
    public $anggota = [];

    public $workStepData;
    public $catatanData;

    public function addAnggota()
    {
        $this->anggota[] = ['driver' => '', 'kernet' => '', 'qty' => '', 'status' => 'Kirim'];
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
        $this->dataDriver = Driver::all();

        $this->workStepData = WorkStep::find($workStepId);
        $this->catatanData = Catatan::where('instruction_id', $instructionId)
            ->where('user_id', $this->workStepData->user_id)
            ->where('kategori', 'catatan')
            ->get();

        $dataAnggotaCurrent = FormPengiriman::where('instruction_id', $this->instructionCurrentId)->get();
        if (isset($dataAnggotaCurrent)) {
            foreach ($dataAnggotaCurrent as $item) {
                $anggota = [
                    'driver' => $item['driver'],
                    'kernet' => $item['kernet'],
                    'qty' => $item['qty'],
                    'status' => $item['status'],
                ];

                $this->anggota[] = $anggota;
            }
        }

        if (empty($this->anggota)) {
            $this->anggota[] = [
                'driver' => '',
                'kernet' => '',
                'qty' => '',
                'status' => 'Kirim',
            ];
        }
    }

    public function render()
    {
        return view('livewire.component.details.form-pengiriman-index');
    }
}
