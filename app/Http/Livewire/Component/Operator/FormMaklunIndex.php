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
use App\Models\FormMaklun;
use App\Models\FileSetting;
use App\Models\Instruction;
use App\Models\RincianPlate;
use App\Models\FormQcPacking;
use Livewire\WithFileUploads;
use App\Models\FormPengiriman;
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


    public function addMaklunPengajuan()
    {
        $this->maklunPengajuan[] = [
            'bentuk_maklun' => $this->dataWorkSteps->workStepList->name,
            'rekanan' => '',
            'tgl_keluar' => '',
            'qty_keluar' => '',
            'satuan_keluar' => '',
            'status' => 'Pengajuan Purchase',
        ];
    }

    public function removeMaklunPengajuan($index)
    {
        unset($this->maklunPengajuan[$index]);
        $this->maklunPengajuan = array_values($this->maklunPengajuan);
    }

    public function addMaklunPenerimaan()
    {
        $this->maklunPenerimaan[] = [
            'bentuk_maklun' => $this->dataWorkSteps->workStepList->name,
            'rekanan' => '',
            'tgl_keluar' => '',
            'qty_keluar' => '',
            'satuan_keluar' => '',
            'status' => 'Barang Diterima',
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
        
        $dataMaklunPengajuan = FormPengajuanMaklun::where('instruction_id', $this->instructionCurrentId)->get();
        if(isset($dataMaklunPengajuan)){
            foreach($dataMaklunPengajuan as $item){
                $maklunPengajuan = [
                    'bentuk_maklun' => $item['bentuk_maklun'],
                    'rekanan' => $item['rekanan'],
                    'tgl_keluar' => $item['tgl_keluar'],
                    'qty_keluar' => $item['qty_keluar'],
                    'satuan_keluar' => $item['satuan_keluar'],
                    'status' => $item['status'],
                ];

                $this->maklunPengajuan[] = $maklunPengajuan;
            }
        }

        if(empty($this->maklunPengajuan)){
            $this->maklunPengajuan [] = [
                'bentuk_maklun' => $this->dataWorkSteps->workStepList->name,
                'rekanan' => '',
                'tgl_keluar' => '',
                'qty_keluar' => '',
                'satuan_keluar' => '',
                'status' => 'Pengajuan Purchase',
            ];
        } 
        
        $datamaklunPenerimaan = FormPenerimaanMaklun::where('instruction_id', $this->instructionCurrentId)->get();
        if(isset($datamaklunPenerimaan)){
            foreach($datamaklunPenerimaan as $item){
                $maklunPenerimaan = [
                    'bentuk_maklun' => $item['bentuk_maklun'],
                    'rekanan' => $item['rekanan'],
                    'tgl_kembali' => $item['tgl_kembali'],
                    'qty_kembali' => $item['qty_kembali'],
                    'satuan_kembali' => $item['satuan_kembali'],
                    'status' => $item['status'],
                ];

                $this->maklunPenerimaan[] = $maklunPenerimaan;
            }
        }

        if(empty($this->maklunPenerimaan)){
            $this->maklunPenerimaan [] = [
                'bentuk_maklun' => $this->dataWorkSteps->workStepList->name,
                'rekanan' => '',
                'tgl_keluar' => '',
                'qty_keluar' => '',
                'satuan_keluar' => '',
                'status' => 'Barang Diterima',
            ];
        } 
    }

    public function render()
    {
        return view('livewire.component.operator.form-maklun-index');
    }

    public function pengajuanPurchase()
    {
        $this->validate([
            'maklunPengajuan.*.bentuk_maklun' => 'required',
            'maklunPengajuan.*.rekanan' => 'required',
            'maklunPengajuan.*.tgl_keluar' => 'required',
            'maklunPengajuan.*.qty_keluar' => 'required',
            'maklunPengajuan.*.satuan_keluar' => 'required',
        ]);

        $instructionData = Instruction::find($this->instructionCurrentId);

        if(isset($this->maklunPengajuan)){
            $deleteFormPengajuanMaklun = FormPengajuanMaklun::where('instruction_id', $this->instructionCurrentId)->delete();
            foreach($this->maklunPengajuan as $dataMaklunPengajuan){
                $createFormPengajuanMaklun = FormPengajuanMaklun::create([
                    'instruction_id' => $this->instructionCurrentId,
                    'bentuk_maklun' => $dataMaklunPengajuan['bentuk_maklun'],
                    'rekanan' => $dataMaklunPengajuan['rekanan'],
                    'tgl_keluar' => $dataMaklunPengajuan['tgl_keluar'],
                    'qty_keluar' => $dataMaklunPengajuan['qty_keluar'],
                    'satuan_keluar' => $dataMaklunPengajuan['satuan_keluar'],
                    'status' => $dataMaklunPengajuan['status'],
                ]);
            }
        }

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Maklun Instruksi Kerja',
            'message' => 'Data Maklun berhasil diajukan',
        ]);
    }

    public function save()
    {        
        $instructionData = Instruction::find($this->instructionCurrentId);

        if($this->catatanProsesPengerjaan){
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
        $backtojadwal = WorkStep::where('instruction_id', $this->instructionCurrentId)
                ->where('work_step_list_id', 2)
                ->first();
        $nextStep = WorkStep::where('instruction_id', $this->instructionCurrentId)
                ->where('step', $currentStep->step + 1)
                ->first();
        
        if($currentStep->status_task == 'Reject Requirements'){
            $currentStep->update([
                'state_task' => 'Complete',
                'status_task' => 'Complete',
            ]);

            $findSourceReject = WorkStep::where('instruction_id', $this->instructionCurrentId)->where('work_step_list_id', $currentStep->reject_from_id)->first();

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
                'selesai' => Carbon::now()->toDateTimeString()
            ]);

            $this->messageSent(['conversation' => 'SPK Perbaikan', 'instruction_id' => $this->instructionCurrentId, 'receiver' => $findSourceReject->user_id]);
            broadcast(new IndexRenderEvent('refresh'));
        }else{
            // Cek apakah $currentStep ada dan step berikutnya ada
            if ($currentStep) {
                $currentStep->update([
                    'state_task' => 'Complete',
                    'status_task' => 'Complete',
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

                    $userDestination = User::where('role', 'Penjadwalan')->get();
                    foreach($userDestination as $dataUser){
                        $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'SPK Selesai Oleh '. $currentStep->workStepList->name, 'instruction_id' => $this->instructionCurrentId]);
                    }
                    broadcast(new IndexRenderEvent('refresh'));

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

    public function update()
    {
        $this->validate([
            'maklunPenerimaan.*.bentuk_maklun' => 'required',
            'maklunPenerimaan.*.rekanan' => 'required',
            'maklunPenerimaan.*.tgl_kembali' => 'required',
            'maklunPenerimaan.*.qty_kembali' => 'required',
            'maklunPenerimaan.*.satuan_kembali' => 'required',
        ]);

        $instructionData = Instruction::find($this->instructionCurrentId);

        if(isset($this->maklunPenerimaan)){
            $deleteFormPenerimaanMaklun = FormPenerimaanMaklun::where('instruction_id', $this->instructionCurrentId)->delete();
            foreach($this->maklunPenerimaan as $dataMaklunPenerimaan){
                $createFormPenerimaanMaklun = FormPenerimaanMaklun::create([
                    'instruction_id' => $this->instructionCurrentId,
                    'bentuk_maklun' => $dataMaklunPenerimaan['bentuk_maklun'],
                    'rekanan' => $dataMaklunPenerimaan['rekanan'],
                    'tgl_kembali' => $dataMaklunPenerimaan['tgl_kembali'],
                    'qty_kembali' => $dataMaklunPenerimaan['qty_kembali'],
                    'satuan_kembali' => $dataMaklunPenerimaan['satuan_kembali'],
                    'status' => $dataMaklunPenerimaan['status'],
                ]);
            }
        }

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Maklun Instruksi Kerja',
            'message' => 'Data Maklun berhasil disimpan',
        ]);
    }

    public function messageSent($arguments)
    {
        $createdMessage = "info";
        $selectedConversation = $arguments['conversation'];
        $receiverUser = $arguments['receiver'];
        $instruction_id = $arguments['instruction_id'];

        broadcast(new NotificationSent(Auth()->user()->id, $createdMessage, $selectedConversation, $instruction_id, $receiverUser));
    }
}
