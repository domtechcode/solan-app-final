<?php

namespace App\Http\Livewire\Component\Operator;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\FormPlate;
use App\Models\FileSetting;
use App\Models\Instruction;
use App\Models\RincianPlate;
use Livewire\WithFileUploads;
use App\Models\FormPotongJadi;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Storage;

class FormPotongIndex extends Component
{
    use WithFileUploads;
    public $instructionCurrentId;
    public $workStepCurrentId;
    public $dataInstruction;
    public $catatanProsesPengerjaan;
    public $stateWorkStep;
    public $hasil_akhir;
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
        $dataWorkStep = WorkStep::find($this->workStepCurrentId);

        $this->stateWorkStep = $dataWorkStep->work_step_list_id;

        $this->workSteps = WorkStep::where('instruction_id', $instructionId)
            ->with('workStepList')
            ->get();

        if ($dataWorkStep->work_step_list_id == 9) {
            $currentPotongJadi = FormPotongJadi::where('instruction_id', $this->instructionCurrentId)->first();

            if (isset($currentPotongJadi)) {
                $this->hasil_akhir = $currentPotongJadi->hasil_akhir;
            } else {
                $this->hasil_akhir = '';
            }

            $dataRincianPlateHasilAkhir = RincianPlate::where('instruction_id', $instructionId)
                ->where(function ($query) {
                    $query->where('status', '!=', 'Deleted by Setting')->orWhereNull('status');
                })
                ->with('formPotongJadi')
                ->get();

            if (isset($dataRincianPlateHasilAkhir)) {
                $this->dataHasilAkhir = [];

                foreach ($dataRincianPlateHasilAkhir as $dataHasilAkhirPlate) {
                    if (isset($dataHasilAkhirPlate->formPotongJadi) && count($dataHasilAkhirPlate->formPotongJadi) > 0) {
                        foreach ($dataHasilAkhirPlate['formPotongJadi'] as $item) {
                            $rincianPlateDataHasilAkhir = [
                                'rincian_plate_id' => $dataHasilAkhirPlate->id,
                                'state' => $dataHasilAkhirPlate->state,
                                'plate' => $dataHasilAkhirPlate->plate,
                                'jumlah_lembar_cetak' => $dataHasilAkhirPlate->jumlah_lembar_cetak,
                                'waste' => $dataHasilAkhirPlate->waste,
                                'hasil_akhir_lembar_cetak_plate' => $item->hasil_akhir_lembar_cetak_plate,
                            ];

                            $this->dataHasilAkhir[] = $rincianPlateDataHasilAkhir;
                        }
                    } else {
                        $rincianPlateDataHasilAkhir = [
                            'rincian_plate_id' => $dataHasilAkhirPlate->id,
                            'state' => $dataHasilAkhirPlate->state,
                            'plate' => $dataHasilAkhirPlate->plate,
                            'jumlah_lembar_cetak' => $dataHasilAkhirPlate->jumlah_lembar_cetak,
                            'waste' => $dataHasilAkhirPlate->waste,
                            'hasil_akhir_lembar_cetak_plate' => '',
                        ];

                        $this->dataHasilAkhir[] = $rincianPlateDataHasilAkhir;
                    }
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.component.operator.form-potong-index');
    }

    public function save()
    {
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

        if ($this->notes) {
            foreach ($this->notes as $input) {
                $catatan = Catatan::create([
                    'tujuan' => $input['tujuan'],
                    'catatan' => $input['catatan'],
                    'kategori' => 'catatan',
                    'instruction_id' => $this->instructionCurrentId,
                    'user_id' => Auth()->user()->id,
                ]);
            }
        }

        $currentStep = WorkStep::find($this->workStepCurrentId);
        $backtojadwal = WorkStep::where('instruction_id', $this->instructionCurrentId)
            ->where('work_step_list_id', 2)
            ->first();
        $nextStep = WorkStep::where('instruction_id', $this->instructionCurrentId)
            ->where('step', $currentStep->step + 1)
            ->first();

        $dataWorkStep = WorkStep::find($this->workStepCurrentId);
        if ($dataWorkStep->work_step_list_id == 9) {
            $this->validate([
                'hasil_akhir' => 'required',
                'dataHasilAkhir.*.hasil_akhir_lembar_cetak_plate' => 'required',
            ]);

            if (isset($this->dataHasilAkhir)) {
                $currentPotongJadi = FormPotongJadi::where('instruction_id', $this->instructionCurrentId)->delete();
                foreach ($this->dataHasilAkhir as $item) {
                    $createPotongJadi = FormPotongJadi::create([
                        'instruction_id' => $this->instructionCurrentId,
                        'hasil_akhir' => $this->hasil_akhir,
                        'rincian_plate_id' => $item['rincian_plate_id'],
                        'hasil_akhir_lembar_cetak_plate' => $item['hasil_akhir_lembar_cetak_plate'],
                    ]);
                }
            }
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
            'title' => 'Plate Instruksi Kerja',
            'message' => 'Data Plate berhasil disimpan',
        ]);

        return redirect()->route('operator.dashboard');
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
