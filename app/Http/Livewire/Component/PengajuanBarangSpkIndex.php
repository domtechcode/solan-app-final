<?php

namespace App\Http\Livewire\Component;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\User;
use App\Models\Files;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\Customer;
use App\Models\WorkStep;
use App\Models\Instruction;
use Illuminate\Support\Str;
use App\Models\WorkStepList;
use Livewire\WithFileUploads;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use App\Models\PengajuanBarangSpk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Models\FilesPengajuanBarangSpk;
use App\Models\PengajuanBarangPersonal;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PengajuanBarangSpkIndex extends Component
{
    use WithFileUploads;

    public $nama_barang;
    public $qty_barang;
    public $tgl_target_datang;
    public $keterangan;

    public $pengajuanBarang;
    public $dataSpkNumber;

    public function addPengajuanBarang($idSelect)
    {
        $dataWorkStepList = WorkStepList::where('name', Auth()->user()->jobdesk)->first();

        $this->pengajuanBarang[] = [
            'work_step_list' => $dataWorkStepList->name,
            'work_step_list_id' => $dataWorkStepList->id,
            'instruction_id' => null,
            'nama_barang' => null,
            'tgl_target_datang' => null,
            'qty_barang' => null,
            'keterangan' => null,
            'file_barang' => [],
            'status_id' => '8',
            'status' => 'Pending',
            'state_pengajuan' => 'New',
        ];

        // Init Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target' => '#spk_number-' . $idSelect,
        ]);
    }

    public function removePengajuanBarang($indexBarang)
    {
        unset($this->pengajuanBarang[$indexBarang]);
        $this->pengajuanBarang = array_values($this->pengajuanBarang);
    }

    public function mount()
    {
        $dataWorkStepListMount = WorkStepList::where('name', Auth()->user()->jobdesk)->first();
        $this->dataSpkNumber = Instruction::whereHas('workStep', function ($query) {   
                $query->where('spk_status', 'Running');
        })->get();

        if (empty($this->pengajuanBarang)) {
            $this->pengajuanBarang[] = [
                'work_step_list' => $dataWorkStepListMount->name,
                'work_step_list_id' => $dataWorkStepListMount->id,
                'instruction_id' => null,
                'nama_barang' => null,
                'tgl_target_datang' => null,
                'qty_barang' => null,
                'keterangan' => null,
                'file_barang' => [],
                'status_id' => '8',
                'status' => 'Pending',
                'state_pengajuan' => 'New',
            ];
        }
    }

    public function render()
    {

        $this->dispatchBrowserEvent('pharaonic.select2.init');
        return view('livewire.component.pengajuan-barang-spk-index')
            ->extends('layouts.app')
            ->layoutData(['title' => 'Form Instruksi Kerja']);
    }

    public function ajukanBarang()
    {
        $this->validate([
            'pengajuanBarang.*.nama_barang' => 'required',
            'pengajuanBarang.*.tgl_target_datang' => 'required',
            'pengajuanBarang.*.qty_barang' => 'required',
            'pengajuanBarang.*.instruction_id' => 'required',
        ]);

        if (isset($this->pengajuanBarang)) {
            foreach ($this->pengajuanBarang as $key => $item) {
                $selectedInstruction = $item['instruction_id'];
                if ($item['state_pengajuan'] == 'New') {
                    $createPengajuan = PengajuanBarangSpk::create([
                        'instruction_id' => $item['instruction_id'],
                        'work_step_list_id' => $item['work_step_list_id'],
                        'nama_barang' => $item['nama_barang'],
                        'user_id' => Auth()->user()->id,
                        'tgl_pengajuan' => Carbon::now(),
                        'tgl_target_datang' => $item['tgl_target_datang'],
                        'qty_barang' => $item['qty_barang'],
                        'keterangan' => $item['keterangan'],
                        'status_id' => $item['status_id'],
                        'state' => 'Purchase',
                    ]);
                }

                if(isset($item['file_barang'])){
                    $dataInstruction = Instruction::find($item['instruction_id']);

                    $folder = 'public/' . $dataInstruction->spk_number . '/purchase';

                    foreach ($item['file_barang'] as $file) {
                        
                        $lastDotPosition = strrpos($file->getClientOriginalName(), '.');
                        $extension = substr($file->getClientOriginalName(), $lastDotPosition + 1);

                        $uniqueId = uniqid();
                        $fileName = $dataInstruction->spk_number . '-file-' . $item['nama_barang'] . '-' . $uniqueId . '.' . $extension;
                        Storage::putFileAs($folder, $file, $fileName);

                        FilesPengajuanBarangSpk::create([
                            'instruction_id' => $item['instruction_id'],
                            'user_id' => Auth()->user()->id,
                            'pengajuan_barang_spk_id' => $createPengajuan->id,
                            'type_file' => 'file-pengajuan',
                            'file_name' => $fileName,
                            'file_path' => $folder,
                        ]);
                    }
                }
            }
        }

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Pengajuan Barang Instruksi Kerja',
            'message' => 'Data Pengajuan Barang berhasil disimpan',
        ]);

        $userDestination = User::where('role', 'Purchase')->get();
        foreach ($userDestination as $dataUser) {
            $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'Pengajuan Barang SPK', 'instruction_id' => $selectedInstruction]);
        }
        event(new IndexRenderEvent('refresh'));

        $previous = URL::previous();
        return redirect($previous);
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
