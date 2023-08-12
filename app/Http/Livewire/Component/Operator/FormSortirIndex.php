<?php

namespace App\Http\Livewire\Component\Operator;

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
        return view('livewire.component.operator.form-sortir-index');
    }

    public function save()
    {
        $this->validate([
            'anggota.*.nama' => 'required',
            'anggota.*.hasil' => 'required',
            'jenis_pekerjaan' => 'required',
            'hasil_akhir' => 'required',
            'jumlah_barang_gagal' => 'required',
            'satuan' => 'required',
        ]);

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

        if (isset($this->anggota)) {
            $deleteFormFinishing = FormSortir::where('instruction_id', $this->instructionCurrentId)
                ->where('jenis_pekerjaan', $currentStep->workStepList->name)
                ->where('pekerjaan_sebelum', $this->workStepsBefore)
                ->where('pekerjaan_sesudah', $this->workStepsAfter)
                ->delete();

            foreach ($this->anggota as $dataAnggota) {
                $createFormFinishing = FormSortir::create([
                    'instruction_id' => $this->instructionCurrentId,
                    'hasil_akhir' => $this->hasil_akhir,
                    'jumlah_barang_gagal' => $this->jumlah_barang_gagal,
                    'jenis_pekerjaan' => $this->jenis_pekerjaan,
                    'pekerjaan_sebelum' => $this->workStepsBefore,
                    'pekerjaan_sesudah' => $this->workStepsAfter,
                    'satuan' => $this->satuan,
                    'nama_anggota' => $dataAnggota['nama'],
                    'hasil_per_anggota' => $dataAnggota['hasil'],
                ]);
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
