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
use Illuminate\Support\Facades\DB;
use App\Models\PengajuanBarangPersonal;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PengajuanBarangPersonalIndex extends Component
{
    public $nama_barang;
    public $qty_barang;
    public $tgl_target_datang;
    public $keterangan;

    public function render()
    {
        return view('livewire.component.pengajuan-barang-personal-index')
            ->extends('layouts.app')
            ->layoutData(['title' => 'Form Instruksi Kerja']);
    }

    public function save()
    {
        $this->validate([
            'nama_barang' => 'required',
            'qty_barang' => 'required',
            'tgl_target_datang' => 'required',
            'keterangan' => 'required',
        ]);

        $createPengajuan = PengajuanBarangPersonal::create([
            'user_id' => Auth()->user()->id,
            'nama_barang' => $this->nama_barang,
            'tgl_pengajuan' => Carbon::now(),
            'tgl_target_datang' => $this->tgl_target_datang,
            'qty_barang' => $this->qty_barang,
            'keterangan' => $this->keterangan,
            'status_id' => 8,
            'state' => 'Purchase',
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Pengajuan Barang Instruksi Kerja',
            'message' => 'Data Pengajuan Barang berhasil disimpan',
        ]);

        $userDestination = User::where('role', 'Purchase')->get();
        foreach ($userDestination as $dataUser) {
            $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'Pengajuan Barang Personal', 'instruction_id' => 1]);
        }

        $this->reset();
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
