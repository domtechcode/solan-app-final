<?php

namespace App\Http\Livewire\Component\Operator;

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
    public $totalQty;

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

        $dataAnggotaCurrent = FormPengiriman::where('instruction_id', $this->instructionCurrentId)->get();
        if (isset($dataAnggotaCurrent)) {
            foreach ($dataAnggotaCurrent as $item) {
                $anggota = [
                    'driver' => $item['driver'],
                    'kernet' => $item['kernet'],
                    'qty' => $item['qty'],
                    'status' => $item['status'],
                ];

                $this->totalQty += $item['qty'];
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

            $this->totalQty = 0;
        }
    }

    public function render()
    {
        return view('livewire.component.operator.form-pengiriman-index');
    }

    public function save()
    {
        $this->validate([
            'anggota.*.driver' => 'required',
            'anggota.*.qty' => 'required',
            'anggota.*.status' => 'required',
        ]);

        $currentStep = WorkStep::find($this->workStepCurrentId);
        $previousStep = WorkStep::where('instruction_id', $this->instructionCurrentId)
            ->where('step', $currentStep->step - 1)
            ->first();

        if ($previousStep->flag == 'Split' && $previousStep->state_task != 'Complete') {
            $this->emit('flashMessage', [
                'type' => 'error',
                'title' => 'Error Submit',
                'message' => 'Data tidak bisa di submit, karena langkah kerja sebelumnya tidak/belum complete',
            ]);
        } else {
            $instructionData = Instruction::find($this->instructionCurrentId);

            $totalQty = 0;

            foreach ($this->anggota as $item) {
                $totalQty += intval($item['qty']);
            }

            $totalPermintaan = $instructionData->quantity - $instructionData->stock;

            if ($totalPermintaan < $totalQty) {
                $this->emit('flashMessage', [
                    'type' => 'error',
                    'title' => 'Error Submit',
                    'message' => 'Total QTY Pengiriman Lebih besar dari permintaan',
                ]);
            } else {
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

                $currentStep = WorkStep::find($this->workStepCurrentId);

                if (isset($this->anggota)) {
                    $deleteFormPengiriman = FormPengiriman::where('instruction_id', $this->instructionCurrentId)->delete();
                    foreach ($this->anggota as $dataAnggota) {
                        $createFormPengiriman = FormPengiriman::create([
                            'instruction_id' => $this->instructionCurrentId,
                            'driver' => $dataAnggota['driver'],
                            'kernet' => $dataAnggota['kernet'],
                            'qty' => $dataAnggota['qty'],
                            'status' => $dataAnggota['status'],
                        ]);
                    }
                }

                $updateSpkSelesai = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                    'status_id' => 7,
                    'job_id' => $currentStep->work_step_list_id,
                    'status_task' => 'Complete',
                    'state_task' => 'Complete',
                    'spk_status' => 'Selesai',
                ]);

                $userDestination = User::where('role', 'Penjadwalan')->get();
                foreach ($userDestination as $dataUser) {
                    $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Pengiriman Selesai Oleh ' . $currentStep->workStepList->name, 'instruction_id' => $this->instructionCurrentId]);
                }

                if ($totalQty < $totalPermintaan) {
                    $qtyKekurangan = $totalPermintaan - $totalQty;
                    $createPengajuanQc = PengajuanKekuranganQc::create([
                        'instruction_id' => $instructionData->id,
                        'qty_permintaan' => $totalPermintaan,
                        'qty_kirim' => $totalQty,
                        'qty_kekurangan' => $qtyKekurangan,
                        'status' => 'Pending',
                    ]);

                    $updateSpkKekurangan = WorkStep::where('instruction_id', $this->instructionCurrentId)->update([
                        'spk_status' => 'Kekurangan QTY Kirim',
                    ]);
                }

                $cariWaitingStk = Instruction::where('spk_stock_number', $instructionData->spk_number)->first();
                if(isset($cariWaitingStk)) {
                    WorkStep::where('instruction_id', $cariWaitingStk->id)->update([
                        'spk_status' => 'Running',
                    ]);
                }

                $this->emit('flashMessage', [
                    'type' => 'success',
                    'title' => 'Pengiriman Instruksi Kerja',
                    'message' => 'Data Pengiriman berhasil disimpan',
                ]);

                return redirect()->route('operator.dashboard');
            }
        }
    }

    public function update()
    {
        $this->validate([
            'anggota.*.driver' => 'required',
            'anggota.*.qty' => 'required',
            'anggota.*.status' => 'required',
        ]);

        $instructionData = Instruction::find($this->instructionCurrentId);

        $totalQty = 0;

        foreach ($this->anggota as $item) {
            $totalQty += intval($item['qty']);
        }

        $totalPermintaan = $instructionData->quantity - $instructionData->stock;

        if ($totalPermintaan <= $totalQty) {
            $this->emit('flashMessage', [
                'type' => 'error',
                'title' => 'Error Submit',
                'message' => 'Total QTY Pengiriman Lebih besar dari permintaan',
            ]);
        } else {
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

            if (isset($this->anggota)) {
                $deleteFormPengiriman = FormPengiriman::where('instruction_id', $this->instructionCurrentId)->delete();
                foreach ($this->anggota as $dataAnggota) {
                    $createFormPengiriman = FormPengiriman::create([
                        'instruction_id' => $this->instructionCurrentId,
                        'driver' => $dataAnggota['driver'],
                        'kernet' => $dataAnggota['kernet'],
                        'qty' => $dataAnggota['qty'],
                        'status' => $dataAnggota['status'],
                    ]);
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

    public function messageSent($arguments)
    {
        $createdMessage = 'info';
        $selectedConversation = $arguments['conversation'];
        $receiverUser = $arguments['receiver'];
        $instruction_id = $arguments['instruction_id'];

        event(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, $receiverUser));
    }
}
