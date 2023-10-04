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

    public function addMaklunPengajuan()
    {
        $this->maklunPengajuan[] = [
            'id' => '',
            'bentuk_maklun' => $this->dataWorkSteps->workStepList->name,
            'rekanan' => '',
            'tgl_keluar' => '',
            'qty_keluar' => '',
            'satuan_keluar' => '',
            'status' => 'Pengajuan Purchase',
            'pekerjaan' => 'Purchase',
        ];
    }

    public function removeMaklunPengajuan($index)
    {
        unset($this->maklunPengajuan[$index]);
        $this->maklunPengajuan = array_values($this->maklunPengajuan);
    }

    public function addMaklunPengajuanGroup()
    {
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
        ];
    }

    public function removeMaklunPengajuanGroup($index)
    {
        unset($this->maklunPengajuan[$index]);
        $this->maklunPengajuan = array_values($this->maklunPengajuan);
    }

    public function addMaklunPenerimaan()
    {
        $this->maklunPenerimaan[] = [
            'id' => '',
            'bentuk_maklun' => $this->dataWorkSteps->workStepList->name,
            'rekanan' => '',
            'tgl_keluar' => '',
            'qty_keluar' => '',
            'satuan_keluar' => '',
            'status' => 'Barang Diterima',
            'catatan' => '',
        ];
    }

    public function removeMaklunPenerimaan($index)
    {
        unset($this->maklunPenerimaan[$index]);
        $this->maklunPenerimaan = array_values($this->maklunPenerimaan);
    }

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
                    'tgl_keluar' => '',
                    'qty_keluar' => '',
                    'satuan_keluar' => '',
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
                    'tgl_keluar' => '',
                    'qty_keluar' => '',
                    'satuan_keluar' => '',
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

    public function pengajuanPurchase()
    {
        $this->validate([
            'maklunPengajuan.*.bentuk_maklun' => 'required',
            'maklunPengajuan.*.rekanan' => 'required',
            'maklunPengajuan.*.tgl_keluar' => 'required',
            'maklunPengajuan.*.qty_keluar' => 'required',
            'maklunPengajuan.*.satuan_keluar' => 'required',
            'maklunPengajuan.*.catatan' => 'required',
        ]);

        $instructionData = Instruction::find($this->instructionCurrentId);

        if (isset($this->maklunPengajuan)) {
            foreach ($this->maklunPengajuan as $dataMaklunPengajuan) {
                $deleteFormPengajuanMaklun = FormPengajuanMaklun::where('id', $dataMaklunPengajuan['id'])->delete();
                $createFormPengajuanMaklun = FormPengajuanMaklun::create([
                    'instruction_id' => $this->instructionCurrentId,
                    'bentuk_maklun' => $dataMaklunPengajuan['bentuk_maklun'],
                    'rekanan' => $dataMaklunPengajuan['rekanan'],
                    'tgl_keluar' => $dataMaklunPengajuan['tgl_keluar'],
                    'qty_keluar' => $dataMaklunPengajuan['qty_keluar'],
                    'satuan_keluar' => $dataMaklunPengajuan['satuan_keluar'],
                    'status' => $dataMaklunPengajuan['status'],
                    'pekerjaan' => $dataMaklunPengajuan['pekerjaan'],
                    'catatan' => $dataMaklunPengajuan['catatan'],
                ]);
            }
        }

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Maklun Instruksi Kerja',
            'message' => 'Data Maklun berhasil diajukan',
        ]);

        $userDestination = User::where('role', 'Purchase')->get();
        foreach ($userDestination as $dataUser) {
            $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'Pengajuan Maklun', 'instruction_id' => $this->instructionCurrentId]);
        }
    }

    public function save()
    {
        $this->update();
        $currentStep = WorkStep::find($this->workStepCurrentId);
        $backtojadwal = WorkStep::where('instruction_id', $this->instructionCurrentId)
            ->where('work_step_list_id', 2)
            ->first();

        $nextStep = WorkStep::where('instruction_id', $this->instructionCurrentId)
            ->where('step', $currentStep->step + 1)
            ->first();

        $previousStep = WorkStep::where('instruction_id', $this->instructionCurrentId)
            ->where('step', $currentStep->step - 1)
            ->first();

        if ($currentStep->flag == 'Split' && $previousStep->state_task != 'Complete' && $previousStep->work_step_list_id != 2) {
            $this->emit('flashMessage', [
                'type' => 'error',
                'title' => 'Error Submit',
                'message' => 'Data tidak bisa di submit, karena langkah kerja sebelumnya tidak/belum complete',
            ]);
        } else {
            $instructionData = Instruction::find($this->instructionCurrentId);

            if ($this->catatanProsesPengerjaan) {
                $dataCatatanProsesPengerjaan = WorkStep::find($this->workStepCurrentId);

                // Ambil alasan pause yang sudah ada dari database
                $existingCatatanProsesPengerjaan = json_decode($dataCatatanProsesPengerjaan->catatan_proses_pengerjaan, true);

                // Tambahkan alasan pause yang baru ke dalam array existingCatatanProsesPengerjaan
                $timestampedKeterangan = $this->catatanProsesPengerjaan . ' - [' . now() . ']';
                $existingCatatanProsesPengerjaan[] = $timestampedKeterangan;

                // Simpan data ke database sebagai JSON
                $updateCatatanPengerjaan = WorkStep::where('id', $this->workStepCurrentId)->update([
                    'catatan_proses_pengerjaan' => json_encode($existingCatatanProsesPengerjaan),
                ]);
            }

            if ($currentStep->status_task == 'Reject Requirements') {
                $currentStep->update([
                    'state_task' => 'Complete',
                    'status_task' => 'Complete',
                ]);

                $findSourceReject = WorkStep::find($currentStep->reject_from_id);

                $findSourceReject->update([
                    'state_task' => 'Running',
                    'status_task' => 'Pending Approved',
                ]);

                $updateJobStatus = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                    'status_id' => 1,
                    'job_id' => $findSourceReject->work_step_list_id,
                ]);

                $currentStep->update([
                    'reject_from_id' => null,
                    'reject_from_status' => null,
                    'reject_from_job' => null,
                    'selesai' => Carbon::now()->toDateTimeString(),
                ]);

                $this->messageSent(['conversation' => 'SPK Perbaikan', 'instruction_id' => $this->instructionCurrentId, 'receiver' => $findSourceReject->user_id]);
                event(new IndexRenderEvent('refresh'));
            } else {
                if ($currentStep->flag == 'Split' || $currentStep->flag == 'Duet') {
                    if ($currentStep) {
                        $currentStep->update([
                            'state_task' => 'Complete',
                            'status_task' => 'Complete',
                        ]);

                        // Cek apakah step berikutnya ada sebelum melanjutkan
                        if ($nextStep) {
                            //group
                            $dataInstruction = Instruction::find($this->instructionCurrentId);
                            if (isset($dataInstruction->group_id) && isset($dataInstruction->group_priority)) {
                                $datachild = Instruction::where('group_id', $dataInstruction->group_id)
                                    ->where('group_priority', 'child')
                                    ->get();

                                foreach ($datachild as $key => $item) {
                                    $updateChildWorkStep = WorkStep::where('instruction_id', $item['instruction_id'])
                                        ->where('work_step_list_id', $currentStep->work_step_list_id)
                                        ->where('user_id', $currentStep->user_id)
                                        ->first();

                                    if (isset($updateChildWorkStep)) {
                                        $updateChildWorkStep->update([
                                            'state_task' => 'Complete',
                                            'status_task' => 'Complete',
                                            'selesai' => Carbon::now()->toDateTimeString(),
                                        ]);
                                    }
                                }
                            }

                            $userDestination = User::where('role', 'Penjadwalan')->get();
                            foreach ($userDestination as $dataUser) {
                                $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Selesai Oleh ' . $currentStep->workStepList->name, 'instruction_id' => $this->instructionCurrentId]);
                            }
                            event(new IndexRenderEvent('refresh'));
                        } else {
                            $updateSelesai = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                                'spk_status' => 'Selesai',
                                'state_task' => 'Complete',
                                'status_task' => 'Complete',
                                'selesai' => Carbon::now()->toDateTimeString(),
                            ]);

                            $updateJobStatus = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                                'job_id' => $currentStep->work_step_list_id,
                                'status_id' => 7,
                            ]);

                            //group
                            $dataInstruction = Instruction::find($this->instructionCurrentId);
                            if (isset($dataInstruction->group_id) && isset($dataInstruction->group_priority)) {
                                $datachild = Instruction::where('group_id', $dataInstruction->group_id)
                                    ->where('group_priority', 'child')
                                    ->get();

                                foreach ($datachild as $key => $item) {
                                    $updateChildWorkStep = WorkStep::where('instruction_id', $item['instruction_id'])
                                        ->where('work_step_list_id', $currentStep->work_step_list_id)
                                        ->where('user_id', $currentStep->user_id)
                                        ->first();

                                    if (isset($updateChildWorkStep)) {
                                        $updateChildWorkStep->update([
                                            'state_task' => 'Complete',
                                            'status_task' => 'Complete',
                                        ]);

                                        $updateChildJobStatus = WorkStep::where('instruction_id', $item['instruction_id'])->update([
                                            'spk_status' => 'Selesai',
                                            'state_task' => 'Complete',
                                            'status_task' => 'Complete',
                                            'job_id' => $currentStep->work_step_list_id,
                                            'status_id' => 7,
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if ($currentStep) {
                        $currentStep->update([
                            'state_task' => 'Complete',
                            'status_task' => 'Complete',
                            'selesai' => Carbon::now()->toDateTimeString(),
                        ]);

                        // Cek apakah step berikutnya ada sebelum melanjutkan
                        if ($nextStep) {
                            $nextStep->update([
                                'state_task' => 'Not Running',
                                'status_task' => 'Pending Start',
                            ]);

                            $updateJobStatus = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                                'job_id' => $currentStep->work_step_list_id,
                                'status_id' => 7,
                            ]);

                            //group
                            $dataInstruction = Instruction::find($this->instructionCurrentId);
                            if (isset($dataInstruction->group_id) && isset($dataInstruction->group_priority)) {
                                $datachild = Instruction::where('group_id', $dataInstruction->group_id)
                                    ->where('group_priority', 'child')
                                    ->get();

                                foreach ($datachild as $key => $item) {
                                    $updateChildWorkStep = WorkStep::where('instruction_id', $item['instruction_id'])
                                        ->where('work_step_list_id', $currentStep->work_step_list_id)
                                        ->where('user_id', $currentStep->user_id)
                                        ->first();

                                    if (isset($updateChildWorkStep)) {
                                        $updateChildWorkStep->update([
                                            'state_task' => 'Complete',
                                            'status_task' => 'Complete',
                                            'selesai' => Carbon::now()->toDateTimeString(),
                                        ]);

                                        $updateChildNextWorkStep = WorkStep::where('instruction_id', $item['instruction_id'])
                                            ->where('step', $updateChildWorkStep->step + 1)
                                            ->first();

                                        $updateChildNextWorkStep->update([
                                            'state_task' => 'Not Running',
                                            'status_task' => 'Pending Start',
                                        ]);

                                        $updateChildJobStatus = WorkStep::where('instruction_id', $item['instruction_id'])->update([
                                            'job_id' => $updateChildNextWorkStep->work_step_list_id,
                                            'status_id' => 7,
                                        ]);
                                    }
                                }
                            }

                            $userDestination = User::where('role', 'Penjadwalan')->get();
                            foreach ($userDestination as $dataUser) {
                                $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Selesai Oleh ' . $currentStep->workStepList->name, 'instruction_id' => $this->instructionCurrentId]);
                            }
                            event(new IndexRenderEvent('refresh'));
                        } else {
                            $updateSelesai = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                                'spk_status' => 'Selesai',
                                'state_task' => 'Complete',
                                'status_task' => 'Complete',
                                'selesai' => Carbon::now()->toDateTimeString(),
                            ]);

                            $updateJobStatus = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                                'job_id' => $currentStep->work_step_list_id,
                                'status_id' => 7,
                            ]);

                            //group
                            $dataInstruction = Instruction::find($this->instructionCurrentId);
                            if (isset($dataInstruction->group_id) && isset($dataInstruction->group_priority)) {
                                $datachild = Instruction::where('group_id', $dataInstruction->group_id)
                                    ->where('group_priority', 'child')
                                    ->get();

                                foreach ($datachild as $key => $item) {
                                    $updateChildWorkStep = WorkStep::where('instruction_id', $item['instruction_id'])
                                        ->where('work_step_list_id', $currentStep->work_step_list_id)
                                        ->where('user_id', $currentStep->user_id)
                                        ->first();

                                    if (isset($updateChildWorkStep)) {
                                        $updateChildWorkStep->update([
                                            'state_task' => 'Complete',
                                            'status_task' => 'Complete',
                                        ]);

                                        $updateChildJobStatus = WorkStep::where('instruction_id', $item['instruction_id'])->update([
                                            'spk_status' => 'Selesai',
                                            'state_task' => 'Complete',
                                            'status_task' => 'Complete',
                                            'job_id' => $currentStep->work_step_list_id,
                                            'status_id' => 7,
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $this->emit('flashMessage', [
                'type' => 'success',
                'title' => 'Pengiriman Instruksi Kerja',
                'message' => 'Data Pengiriman berhasil disimpan',
            ]);

            return redirect()->route('operator.dashboard');
        }
    }

    public function update()
    {
        $this->validate([
            'maklunPenerimaan.*.bentuk_maklun' => 'required',
            'maklunPenerimaan.*.rekanan' => 'required',
            'maklunPenerimaan.*.tgl_kembali' => 'required',
            'maklunPenerimaan.*.qty_kembali' => 'required',
            'maklunPenerimaan.*.satuan_kembali' => 'required',
            'maklunPenerimaan.*.catatan' => 'required',
        ]);

        $instructionData = Instruction::find($this->instructionCurrentId);

        if (isset($this->maklunPenerimaan)) {
            foreach ($this->maklunPenerimaan as $dataMaklunPenerimaan) {
                $deleteFormPenerimaanMaklun = FormPenerimaanMaklun::where('id', $dataMaklunPenerimaan['id'])->delete();
                $createFormPenerimaanMaklun = FormPenerimaanMaklun::create([
                    'instruction_id' => $this->instructionCurrentId,
                    'bentuk_maklun' => $dataMaklunPenerimaan['bentuk_maklun'],
                    'rekanan' => $dataMaklunPenerimaan['rekanan'],
                    'tgl_kembali' => $dataMaklunPenerimaan['tgl_kembali'],
                    'qty_kembali' => $dataMaklunPenerimaan['qty_kembali'],
                    'satuan_kembali' => $dataMaklunPenerimaan['satuan_kembali'],
                    'status' => $dataMaklunPenerimaan['status'],
                    'catatan' => $dataMaklunPenerimaan['catatan'],
                ]);
            }
        }

        $currentStep = WorkStep::find($this->workStepCurrentId);
        $nextStep = WorkStep::where('instruction_id', $this->instructionCurrentId)
            ->where('step', $currentStep->step + 1)
            ->first();

        $currentStep->update([
            'flag' => 'Split',
        ]);

        $nextStep->update([
            'state_task' => 'Running',
            'status_task' => 'Pending Approved',
        ]);

        if (isset($nextStep->user_id)) {
            $this->messageSent(['conversation' => 'SPK Baru', 'instruction_id' => $this->instructionCurrentId, 'receiver' => $nextStep->user_id]);
        }

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Maklun Instruksi Kerja',
            'message' => 'Data Maklun berhasil disimpan',
        ]);
    }

    public function pengajuanPurchaseGroup()
    {
        $this->validate([
            'maklunPengajuan.*.instruction_id' => 'required',
            'maklunPengajuan.*.bentuk_maklun' => 'required',
            'maklunPengajuan.*.rekanan' => 'required',
            'maklunPengajuan.*.tgl_keluar' => 'required',
            'maklunPengajuan.*.qty_keluar' => 'required',
            'maklunPengajuan.*.satuan_keluar' => 'required',
            'maklunPengajuan.*.catatan' => 'required',
        ]);

        if (isset($this->maklunPengajuan)) {
            foreach ($this->maklunPengajuan as $dataMaklunPengajuan) {
                $deleteFormPengajuanMaklun = FormPengajuanMaklun::where('id', $dataMaklunPengajuan['id'])->delete();
                $createFormPengajuanMaklun = FormPengajuanMaklun::create([
                    'instruction_id' => $dataMaklunPengajuan['instruction_id'],
                    'bentuk_maklun' => $dataMaklunPengajuan['bentuk_maklun'],
                    'rekanan' => $dataMaklunPengajuan['rekanan'],
                    'tgl_keluar' => $dataMaklunPengajuan['tgl_keluar'],
                    'qty_keluar' => $dataMaklunPengajuan['qty_keluar'],
                    'satuan_keluar' => $dataMaklunPengajuan['satuan_keluar'],
                    'status' => $dataMaklunPengajuan['status'],
                    'pekerjaan' => $dataMaklunPengajuan['pekerjaan'],
                    'catatan' => $dataMaklunPengajuan['catatan'],
                ]);
            }
        }

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Maklun Instruksi Kerja',
            'message' => 'Data Maklun berhasil diajukan',
        ]);
    }

    public function saveGroup()
    {
        $this->updateGroup();
        $currentStep = WorkStep::find($this->workStepCurrentId);
        $backtojadwal = WorkStep::where('instruction_id', $this->instructionCurrentId)
            ->where('work_step_list_id', 2)
            ->first();
        $nextStep = WorkStep::where('instruction_id', $this->instructionCurrentId)
            ->where('step', $currentStep->step + 1)
            ->first();

        $previousStep = WorkStep::where('instruction_id', $this->instructionCurrentId)
            ->where('step', $currentStep->step - 1)
            ->first();

        if ($currentStep->flag == 'Split' && $previousStep->state_task != 'Complete') {
            $this->emit('flashMessage', [
                'type' => 'error',
                'title' => 'Error Submit',
                'message' => 'Data tidak bisa di submit, karena langkah kerja sebelumnya tidak/belum complete',
            ]);
        } else {
            $instructionData = Instruction::find($this->instructionCurrentId);

            if ($this->catatanProsesPengerjaan) {
                $dataCatatanProsesPengerjaan = WorkStep::find($this->workStepCurrentId);

                // Ambil alasan pause yang sudah ada dari database
                $existingCatatanProsesPengerjaan = json_decode($dataCatatanProsesPengerjaan->catatan_proses_pengerjaan, true);

                // Tambahkan alasan pause yang baru ke dalam array existingCatatanProsesPengerjaan
                $timestampedKeterangan = $this->catatanProsesPengerjaan . ' - [' . now() . ']';
                $existingCatatanProsesPengerjaan[] = $timestampedKeterangan;

                // Simpan data ke database sebagai JSON
                $updateCatatanPengerjaan = WorkStep::where('id', $this->workStepCurrentId)->update([
                    'catatan_proses_pengerjaan' => json_encode($existingCatatanProsesPengerjaan),
                ]);
            }

            if ($currentStep->status_task == 'Reject Requirements') {
                $currentStep->update([
                    'state_task' => 'Complete',
                    'status_task' => 'Complete',
                ]);

                $findSourceReject = WorkStep::find($currentStep->reject_from_id);

                $findSourceReject->update([
                    'state_task' => 'Running',
                    'status_task' => 'Pending Approved',
                ]);

                $updateJobStatus = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                    'status_id' => 1,
                    'job_id' => $findSourceReject->work_step_list_id,
                ]);

                $currentStep->update([
                    'reject_from_id' => null,
                    'reject_from_status' => null,
                    'reject_from_job' => null,
                    'selesai' => Carbon::now()->toDateTimeString(),
                ]);

                $this->messageSent(['conversation' => 'SPK Perbaikan', 'instruction_id' => $this->instructionCurrentId, 'receiver' => $findSourceReject->user_id]);
                event(new IndexRenderEvent('refresh'));
            } else {
                if ($currentStep->flag == 'Split' || $currentStep->flag == 'Duet') {
                    if ($currentStep) {
                        $currentStep->update([
                            'state_task' => 'Complete',
                            'status_task' => 'Complete',
                        ]);

                        // Cek apakah step berikutnya ada sebelum melanjutkan
                        if ($nextStep) {
                            //group
                            $dataInstruction = Instruction::find($this->instructionCurrentId);
                            if (isset($dataInstruction->group_id) && isset($dataInstruction->group_priority)) {
                                $datachild = Instruction::where('group_id', $dataInstruction->group_id)
                                    ->where('group_priority', 'child')
                                    ->get();

                                foreach ($datachild as $key => $item) {
                                    $updateChildWorkStep = WorkStep::where('instruction_id', $item['instruction_id'])
                                        ->where('work_step_list_id', $currentStep->work_step_list_id)
                                        ->where('user_id', $currentStep->user_id)
                                        ->first();

                                    if (isset($updateChildWorkStep)) {
                                        $updateChildWorkStep->update([
                                            'state_task' => 'Complete',
                                            'status_task' => 'Complete',
                                            'selesai' => Carbon::now()->toDateTimeString(),
                                        ]);
                                    }
                                }
                            }

                            $userDestination = User::where('role', 'Penjadwalan')->get();
                            foreach ($userDestination as $dataUser) {
                                $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Selesai Oleh ' . $currentStep->workStepList->name, 'instruction_id' => $this->instructionCurrentId]);
                            }
                            event(new IndexRenderEvent('refresh'));
                        } else {
                            $updateSelesai = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                                'spk_status' => 'Selesai',
                                'state_task' => 'Complete',
                                'status_task' => 'Complete',
                                'selesai' => Carbon::now()->toDateTimeString(),
                            ]);

                            $updateJobStatus = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                                'job_id' => $currentStep->work_step_list_id,
                                'status_id' => 7,
                            ]);

                            //group
                            $dataInstruction = Instruction::find($this->instructionCurrentId);
                            if (isset($dataInstruction->group_id) && isset($dataInstruction->group_priority)) {
                                $datachild = Instruction::where('group_id', $dataInstruction->group_id)
                                    ->where('group_priority', 'child')
                                    ->get();

                                foreach ($datachild as $key => $item) {
                                    $updateChildWorkStep = WorkStep::where('instruction_id', $item['instruction_id'])
                                        ->where('work_step_list_id', $currentStep->work_step_list_id)
                                        ->where('user_id', $currentStep->user_id)
                                        ->first();

                                    if (isset($updateChildWorkStep)) {
                                        $updateChildWorkStep->update([
                                            'state_task' => 'Complete',
                                            'status_task' => 'Complete',
                                        ]);

                                        $updateChildJobStatus = WorkStep::where('instruction_id', $item['instruction_id'])->update([
                                            'spk_status' => 'Selesai',
                                            'state_task' => 'Complete',
                                            'status_task' => 'Complete',
                                            'job_id' => $currentStep->work_step_list_id,
                                            'status_id' => 7,
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if ($currentStep) {
                        $currentStep->update([
                            'state_task' => 'Complete',
                            'status_task' => 'Complete',
                            'selesai' => Carbon::now()->toDateTimeString(),
                        ]);

                        // Cek apakah step berikutnya ada sebelum melanjutkan
                        if ($nextStep) {
                            $nextStep->update([
                                'state_task' => 'Not Running',
                                'status_task' => 'Pending Start',
                            ]);

                            $updateJobStatus = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                                'job_id' => $currentStep->work_step_list_id,
                                'status_id' => 7,
                            ]);

                            //group
                            $dataInstruction = Instruction::find($this->instructionCurrentId);
                            if (isset($dataInstruction->group_id) && isset($dataInstruction->group_priority)) {
                                $datachild = Instruction::where('group_id', $dataInstruction->group_id)
                                    ->where('group_priority', 'child')
                                    ->get();

                                foreach ($datachild as $key => $item) {
                                    $updateChildWorkStep = WorkStep::where('instruction_id', $item['instruction_id'])
                                        ->where('work_step_list_id', $currentStep->work_step_list_id)
                                        ->where('user_id', $currentStep->user_id)
                                        ->first();

                                    if (isset($updateChildWorkStep)) {
                                        $updateChildWorkStep->update([
                                            'state_task' => 'Complete',
                                            'status_task' => 'Complete',
                                            'selesai' => Carbon::now()->toDateTimeString(),
                                        ]);

                                        $updateChildNextWorkStep = WorkStep::where('instruction_id', $item['instruction_id'])
                                            ->where('step', $updateChildWorkStep->step + 1)
                                            ->first();

                                        $updateChildNextWorkStep->update([
                                            'state_task' => 'Not Running',
                                            'status_task' => 'Pending Start',
                                        ]);

                                        $updateChildJobStatus = WorkStep::where('instruction_id', $item['instruction_id'])->update([
                                            'job_id' => $updateChildNextWorkStep->work_step_list_id,
                                            'status_id' => 7,
                                        ]);
                                    }
                                }
                            }

                            $userDestination = User::where('role', 'Penjadwalan')->get();
                            foreach ($userDestination as $dataUser) {
                                $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Selesai Oleh ' . $currentStep->workStepList->name, 'instruction_id' => $this->instructionCurrentId]);
                            }
                            event(new IndexRenderEvent('refresh'));
                        } else {
                            $updateSelesai = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                                'spk_status' => 'Selesai',
                                'state_task' => 'Complete',
                                'status_task' => 'Complete',
                                'selesai' => Carbon::now()->toDateTimeString(),
                            ]);

                            $updateJobStatus = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                                'job_id' => $currentStep->work_step_list_id,
                                'status_id' => 7,
                            ]);

                            //group
                            $dataInstruction = Instruction::find($this->instructionCurrentId);
                            if (isset($dataInstruction->group_id) && isset($dataInstruction->group_priority)) {
                                $datachild = Instruction::where('group_id', $dataInstruction->group_id)
                                    ->where('group_priority', 'child')
                                    ->get();

                                foreach ($datachild as $key => $item) {
                                    $updateChildWorkStep = WorkStep::where('instruction_id', $item['instruction_id'])
                                        ->where('work_step_list_id', $currentStep->work_step_list_id)
                                        ->where('user_id', $currentStep->user_id)
                                        ->first();

                                    if (isset($updateChildWorkStep)) {
                                        $updateChildWorkStep->update([
                                            'state_task' => 'Complete',
                                            'status_task' => 'Complete',
                                        ]);

                                        $updateChildJobStatus = WorkStep::where('instruction_id', $item['instruction_id'])->update([
                                            'spk_status' => 'Selesai',
                                            'state_task' => 'Complete',
                                            'status_task' => 'Complete',
                                            'job_id' => $currentStep->work_step_list_id,
                                            'status_id' => 7,
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $this->emit('flashMessage', [
                'type' => 'success',
                'title' => 'Pengiriman Instruksi Kerja',
                'message' => 'Data Pengiriman berhasil disimpan',
            ]);

            return redirect()->route('operator.dashboard');
        }
    }

    public function updateGroup()
    {
        $this->validate([
            'maklunPenerimaan.*.instruction_id' => 'required',
            'maklunPenerimaan.*.bentuk_maklun' => 'required',
            'maklunPenerimaan.*.rekanan' => 'required',
            'maklunPenerimaan.*.tgl_kembali' => 'required',
            'maklunPenerimaan.*.qty_kembali' => 'required',
            'maklunPenerimaan.*.satuan_kembali' => 'required',
            'maklunPenerimaan.*.catatan' => 'required',
        ]);

        if (isset($this->maklunPenerimaan)) {
            foreach ($this->maklunPenerimaan as $dataMaklunPenerimaan) {
                $deleteFormPenerimaanMaklun = FormPenerimaanMaklun::where('id', $dataMaklunPenerimaan['id'])->delete();
                $createFormPenerimaanMaklun = FormPenerimaanMaklun::create([
                    'instruction_id' => $dataMaklunPenerimaan['instruction_id'],
                    'bentuk_maklun' => $dataMaklunPenerimaan['bentuk_maklun'],
                    'rekanan' => $dataMaklunPenerimaan['rekanan'],
                    'tgl_kembali' => $dataMaklunPenerimaan['tgl_kembali'],
                    'qty_kembali' => $dataMaklunPenerimaan['qty_kembali'],
                    'satuan_kembali' => $dataMaklunPenerimaan['satuan_kembali'],
                    'status' => $dataMaklunPenerimaan['status'],
                    'catatan' => $dataMaklunPenerimaan['catatan'],
                ]);

                $currentStep = WorkStep::find($this->workStepCurrentId);
                $nextStep = WorkStep::where('instruction_id', $dataMaklunPenerimaan['instruction_id'])
                    ->where('step', $currentStep->step + 1)
                    ->first();

                $currentStep->update([
                    'flag' => 'Split',
                ]);

                $nextStep->update([
                    'state_task' => 'Running',
                    'status_task' => 'Pending Approved',
                ]);
            }
        }

        if (isset($nextStep->user_id)) {
            $this->messageSent(['conversation' => 'SPK Baru', 'instruction_id' => $this->instructionCurrentId, 'receiver' => $nextStep->user_id]);
        }

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Maklun Instruksi Kerja',
            'message' => 'Data Maklun berhasil disimpan',
        ]);
    }

    public function messageSent($arguments)
    {
        $createdMessage = 'info';
        $selectedConversation = $arguments['conversation'];
        $receiverUser = $arguments['receiver'];
        $instruction_id = $arguments['instruction_id'];

        event(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, $receiverUser));
    }
}
