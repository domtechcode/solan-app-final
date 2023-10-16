<?php

namespace App\Http\Livewire\Component\Operator;

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
        return view('livewire.component.operator.form-cetak-index');
    }

    public function save()
    {
        $this->validate([
            'hasil_akhir_lembar_cetak' => 'required',
            'dataHasilAkhir.*.hasil_akhir_lembar_cetak_plate' => 'required',
        ]);

        // if (isset($this->hasil_akhir_lembar_cetak)) {
        //     $deleteCetak = FormCetak::where('instruction_id', $this->instructionCurrentId)->delete();
        //     $createCetak = FormCetak::create([
        //         'instruction_id' => $this->instructionCurrentId,
        //         'hasil_akhir_lembar_cetak' => $this->hasil_akhir_lembar_cetak,
        //     ]);
        // }

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

            if (isset($this->notes)) {
                $this->validate([
                    'notes.*.tujuan' => 'required',
                    'notes.*.catatan' => 'required',
                ]);

                foreach ($this->notes as $input) {
                    if($input['tujuan'] == 'semua') {
                        foreach ($this->workSteps as $item) {
                            $catatanSemua = Catatan::create([
                                'tujuan' => $item['work_step_list_id'],
                                'catatan' => $input['catatan'],
                                'kategori' => 'catatan',
                                'instruction_id' => $this->instructionCurrentId,
                                'user_id' => Auth()->user()->id,
                            ]);
                        }
                    }else{
                        $catatan = Catatan::create([
                            'tujuan' => $input['tujuan'],
                            'catatan' => $input['catatan'],
                            'kategori' => 'catatan',
                            'instruction_id' => $this->instructionCurrentId,
                            'user_id' => Auth()->user()->id,
                        ]);
                    }
                }
            }

            if (isset($this->dataHasilAkhir)) {
                $deleteCetak = FormCetak::where('instruction_id', $this->instructionCurrentId)
                    ->where('user_id', Auth()->user()->id)
                    ->where('step', $currentStep->step)
                    ->delete();
                foreach ($this->dataHasilAkhir as $item) {
                    $createCetak = FormCetak::create([
                        'instruction_id' => $this->instructionCurrentId,
                        'user_id' => Auth()->user()->id,
                        'step' => $currentStep->step,
                        'state' => $item['state'],
                        'plate' => $item['plate'],
                        'jumlah_lembar_cetak' => $item['jumlah_lembar_cetak'],
                        'waste' => $item['waste'],
                        'hasil_akhir_lembar_cetak_plate' => $item['hasil_akhir_lembar_cetak_plate'],
                        'hasil_akhir_lembar_cetak' => $this->hasil_akhir_lembar_cetak,
                    ]);
                }
            }

            if (isset($this->dataWarna['rincianPlate'])) {
                foreach ($this->dataWarna['rincianPlate'] as $rincianPlate) {
                    // Now, update the related WarnaPlate models
                    if (isset($rincianPlate['warnaCetak'])) {
                        foreach ($rincianPlate['warnaCetak'] as $warnaCetak) {
                            $warnaPlateModel = WarnaPlate::find($warnaCetak['id']);

                            if ($warnaPlateModel) {
                                $warnaPlateModel->warna = $warnaCetak['warna'];
                                $warnaPlateModel->keterangan = $warnaCetak['keterangan'];
                                $warnaPlateModel->de = $warnaCetak['de'];
                                $warnaPlateModel->l = $warnaCetak['l'];
                                $warnaPlateModel->a = $warnaCetak['a'];
                                $warnaPlateModel->b = $warnaCetak['b'];
                                $warnaPlateModel->save();
                            }
                        }
                    }
                }
            }

            if (isset($this->de) && isset($this->l) && isset($this->a) && isset($this->b)) {
                $update = RincianPlate::where('instruction_id', $this->instructionCurrentId)
                    ->where(function ($query) {
                        $query->where('status', '!=', 'Deleted by Setting')->orWhereNull('status');
                    })
                    ->update([
                        'de' => $this->de,
                        'l' => $this->l,
                        'a' => $this->a,
                        'b' => $this->b,
                        'status' => 'Pengembalian Plate',
                    ]);
            }

            if ($currentStep->reject_from_id != null) {
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
                'title' => 'Plate Instruksi Kerja',
                'message' => 'Data Plate berhasil disimpan',
            ]);

            return redirect()->route('operator.dashboard');
        }
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
