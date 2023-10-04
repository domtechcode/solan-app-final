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
use App\Models\FormMaklun;
use App\Models\FileSetting;
use App\Models\Instruction;
use App\Models\RincianPlate;
use App\Models\FormQcPacking;
use Livewire\WithFileUploads;
use App\Models\FormPengiriman;
use App\Models\FormPotongJadi;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use App\Models\FormPengajuanMaklun;
use App\Models\FormPenerimaanMaklun;
use Illuminate\Support\Facades\Storage;

class FormMaklunIndex extends Component
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
    public $maklunPengajuan = [];
    public $maklunPenerimaan = [];
    public $collectStep;
    public $collectHasilAkhir;

    public $anggotaGroupSpk;

    public function mount($instructionId, $workStepId)
    {
        $this->instructionCurrentId = $instructionId;
        $this->workStepCurrentId = $workStepId;
        $this->dataInstruction = Instruction::find($this->instructionCurrentId);
        $this->dataWorkSteps = WorkStep::find($workStepId);

        $stateBefore = WorkStep::where('instruction_id', $this->dataWorkSteps->instruction_id)
            ->where('step', $this->dataWorkSteps->step - 1)
            ->first();

        if ($this->dataInstruction->group_priority == 'parent') {
            $this->anggotaGroupSpk = Instruction::where('group_id', $this->dataInstruction->group_id)->get();
            $dataAnggota = Instruction::where('group_id', $this->dataInstruction->group_id)->pluck('id');

            $dataMaklunPengajuan = FormPengajuanMaklun::whereIn('instruction_id', $dataAnggota)
                ->where('bentuk_maklun', $this->dataWorkSteps->workStepList->name)
                ->get();

            if (isset($dataMaklunPengajuan)) {
                foreach ($dataMaklunPengajuan as $item) {
                    $maklunPengajuan = [
                        'id' => $item['id'],
                        'instruction_id' => $item['instruction_id'],
                        'bentuk_maklun' => $item['bentuk_maklun'],
                        'rekanan' => $item['rekanan'],
                        'tgl_keluar' => $item['tgl_keluar'],
                        'qty_keluar' => $item['qty_keluar'],
                        'satuan_keluar' => $item['satuan_keluar'],
                        'catatan' => $item['catatan'],
                        'status' => $item['status'],
                        'pekerjaan' => $item['pekerjaan'],
                    ];

                    $this->maklunPengajuan[] = $maklunPengajuan;
                }
            }

            if (empty($this->maklunPengajuan)) {
                $this->maklunPengajuan[] = [
                    'id' => '',
                    'instruction_id' => '',
                    'bentuk_maklun' => $this->dataWorkSteps->workStepList->name,
                    'rekanan' => '',
                    'tgl_keluar' => '',
                    'qty_keluar' => '',
                    'satuan_keluar' => '',
                    'status' => 'Pengajuan Purchase',
                    'pekerjaan' => 'Purchase',
                    'catatan' => '',
                ];
            }

            $datamaklunPenerimaan = FormPenerimaanMaklun::whereIn('instruction_id', $dataAnggota)
                ->where('bentuk_maklun', $this->dataWorkSteps->workStepList->name)
                ->get();
            if (isset($datamaklunPenerimaan)) {
                foreach ($datamaklunPenerimaan as $item) {
                    $maklunPenerimaan = [
                        'id' => $item['id'],
                        'instruction_id' => $item['instruction_id'],
                        'bentuk_maklun' => $item['bentuk_maklun'],
                        'rekanan' => $item['rekanan'],
                        'tgl_kembali' => $item['tgl_kembali'],
                        'qty_kembali' => $item['qty_kembali'],
                        'satuan_kembali' => $item['satuan_kembali'],
                        'status' => $item['status'],
                        'catatan' => $item['catatan'],
                    ];

                    $this->maklunPenerimaan[] = $maklunPenerimaan;
                }
            }

            if (empty($this->maklunPenerimaan)) {
                $this->maklunPenerimaan[] = [
                    'id' => '',
                    'instruction_id' => '',
                    'bentuk_maklun' => $this->dataWorkSteps->workStepList->name,
                    'rekanan' => '',
                    'tgl_kembali' => '',
                    'qty_kembali' => '',
                    'satuan_kembali' => '',
                    'status' => 'Barang Diterima',
                    'catatan' => 'Barang Diterima',
                ];
            }
        } else {
            $dataMaklunPengajuan = FormPengajuanMaklun::where('instruction_id', $this->instructionCurrentId)
                ->where('bentuk_maklun', $this->dataWorkSteps->workStepList->name)
                ->get();
            if (isset($dataMaklunPengajuan)) {
                foreach ($dataMaklunPengajuan as $item) {
                    $maklunPengajuan = [
                        'id' => $item['id'],
                        'bentuk_maklun' => $item['bentuk_maklun'],
                        'rekanan' => $item['rekanan'],
                        'tgl_keluar' => $item['tgl_keluar'],
                        'qty_keluar' => $item['qty_keluar'],
                        'satuan_keluar' => $item['satuan_keluar'],
                        'catatan' => $item['catatan'],
                        'status' => $item['status'],
                        'pekerjaan' => $item['pekerjaan'],
                    ];

                    $this->maklunPengajuan[] = $maklunPengajuan;
                }
            }

            if (empty($this->maklunPengajuan)) {
                $this->maklunPengajuan[] = [
                    'id' => '',
                    'bentuk_maklun' => $this->dataWorkSteps->workStepList->name,
                    'rekanan' => '',
                    'tgl_keluar' => '',
                    'qty_keluar' => '',
                    'satuan_keluar' => '',
                    'status' => 'Pengajuan Purchase',
                    'pekerjaan' => 'Purchase',
                    'catatan' => '',
                ];
            }

            $datamaklunPenerimaan = FormPenerimaanMaklun::where('instruction_id', $this->instructionCurrentId)
                ->where('bentuk_maklun', $this->dataWorkSteps->workStepList->name)
                ->get();
            if (isset($datamaklunPenerimaan)) {
                foreach ($datamaklunPenerimaan as $item) {
                    $maklunPenerimaan = [
                        'id' => $item['id'],
                        'bentuk_maklun' => $item['bentuk_maklun'],
                        'rekanan' => $item['rekanan'],
                        'tgl_kembali' => $item['tgl_kembali'],
                        'qty_kembali' => $item['qty_kembali'],
                        'satuan_kembali' => $item['satuan_kembali'],
                        'status' => $item['status'],
                        'catatan' => $item['catatan'],
                    ];

                    $this->maklunPenerimaan[] = $maklunPenerimaan;
                }
            }

            if (empty($this->maklunPenerimaan)) {
                $this->maklunPenerimaan[] = [
                    'id' => '',
                    'bentuk_maklun' => $this->dataWorkSteps->workStepList->name,
                    'rekanan' => '',
                    'tgl_kembali' => '',
                    'qty_kembali' => '',
                    'satuan_kembali' => '',
                    'status' => 'Barang Diterima',
                    'catatan' => '',
                ];
            }
        }

        if (isset($stateBefore)) {
            if ($stateBefore->work_step_list_id == 9) {
                $collect = FormPotongJadi::where('instruction_id', $this->dataWorkSteps->instruction_id)->first();
                $this->collectStep = 'Potong Jadi';
                $this->collectHasilAkhir = $collect->hasil_akhir;
            } elseif ($stateBefore->work_step_list_id == 24) {
                $collect = FormPond::where('instruction_id', $this->dataWorkSteps->instruction_id)->first();
                $this->collectStep = 'Pond';
                $this->collectHasilAkhir = $collect->hasil_akhir;
            } else {
            }
        }
    }

    public function render()
    {
        return view('livewire.component.details.form-maklun-index');
    }
}
