<?php

namespace App\Http\Livewire\Accounting\Component;

use App\Models\User;
use App\Models\Files;
use App\Models\FormRab;
use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use App\Models\CatatanPengajuan;
use App\Models\PengajuanBarangSpk;
use App\Models\FormPengajuanMaklun;

class PengajuanRejectMaklunSpkIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginatePengajuanRejectMaklunSpk = 10;
    public $searchPengajuanRejectMaklunSpk = '';

    public $selectedInstruction;
    public $selectedWorkStep;
    public $selectedFileContoh;
    public $selectedFileArsip;
    public $selectedFileAccounting;
    public $selectedFileLayout;
    public $selectedFileSample;

    public $selectedInstructionParent;
    public $selectedWorkStepParent;
    public $selectedFileContohParent;
    public $selectedFileArsipParent;
    public $selectedFileAccountingParent;
    public $selectedFileLayoutParent;
    public $selectedFileSampleParent;

    public $selectedInstructionChild;

    public $selectedGroupParent;
    public $selectedGroupChild;
    public $workStepHitungBahanNew;

    public $dataMaklun;
    public $harga_satuan_maklun;
    public $qty_purchase_maklun;
    public $total_harga_maklun;

    public $notes = [];
    public $catatan;

    protected $listeners = ['indexRender' => '$refresh'];

    public function addEmptyNote()
    {
        $this->notes[] = '';
    }

    public function removeNote($index)
    {
        unset($this->notes[$index]);
        $this->notes = array_values($this->notes);
    }

    public function updatingSearchPengajuanRejectMaklunSpk()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->searchPengajuanRejectMaklunSpk = request()->query('search', $this->searchPengajuanRejectMaklunSpk);
    }

    public function render()
    {
        $dataPengajuanRejectMaklunSpk = FormPengajuanMaklun::whereIn('status', ['Reject RAB'])
        ->where('pekerjaan', 'Accounting')
            ->where(function ($query) {
                $query
                    ->where('bentuk_maklun', 'like', '%' . $this->searchPengajuanRejectMaklunSpk . '%')
                    ->orWhere('rekanan', 'like', '%' . $this->searchPengajuanRejectMaklunSpk . '%')
                    ->orWhere('tgl_keluar', 'like', '%' . $this->searchPengajuanRejectMaklunSpk . '%')
                    ->orWhere('qty_keluar', 'like', '%' . $this->searchPengajuanRejectMaklunSpk . '%');
            })
            ->with(['instruction'])
            ->orderBy('tgl_keluar', 'asc')
            ->paginate($this->paginatePengajuanRejectMaklunSpk);

        return view('livewire.accounting.component.pengajuan-reject-maklun-spk-index', ['pengajuanRejectMaklunSpk' => $dataPengajuanRejectMaklunSpk])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function ajukanRabMaklun($PengajuanMaklunSelectedRABId)
    {
        $this->validate([
            'harga_satuan_maklun' => 'required',
            'qty_purchase_maklun' => 'required',
            'total_harga_maklun' => 'required',
        ]);

        if (isset($this->notes)) {
            $this->validate([
                'notes.*.tujuan' => 'required',
                'notes.*.catatan' => 'required',
            ]);

            foreach ($this->notes as $input) {
                $catatan = CatatanPengajuan::create([
                    'tujuan' => $input['tujuan'],
                    'catatan' => $input['catatan'],
                    'kategori' => 'catatan',
                    'user_id' => Auth()->user()->id,
                    'form_pengajuan_maklun_id' => $this->dataMaklun->id,
                ]);
            }
        }

        $updateRAB = FormPengajuanMaklun::find($PengajuanMaklunSelectedRABId);
        $updateRAB->update([
            'harga_satuan_maklun' => currency_convert($this->harga_satuan_maklun),
            'qty_purchase_maklun' => currency_convert($this->qty_purchase_maklun),
            'total_harga_maklun' => currency_convert($this->total_harga_maklun),
            'status' => 'Pengajuan RAB',
            'pekerjaan' => 'RAB',
            'previous_state' => 'Accounting',
            'accounting' => 'Accounting',
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Maklun Instruksi Kerja',
            'message' => 'Data berhasil disimpan',
        ]);

        $userDestination = User::where('role', 'RAB')->get();
        foreach ($userDestination as $dataUser) {
            $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'Pengajuan Maklun', 'instruction_id' => $updateRAB->instruction_id]);
        }
        $this->emit('indexRender');
        $this->reset();
        $this->dispatchBrowserEvent('close-modal-pengajuan-new-maklun-spk');
    }

    public function approveMaklun($PengajuanMaklunSelectedApproveId)
    {
        $this->validate([
            'harga_satuan_maklun' => 'required',
            'qty_purchase_maklun' => 'required',
            'total_harga_maklun' => 'required',
        ]);

        if (isset($this->notes)) {
            $this->validate([
                'notes.*.tujuan' => 'required',
                'notes.*.catatan' => 'required',
            ]);

            foreach ($this->notes as $input) {
                $catatan = CatatanPengajuan::create([
                    'tujuan' => $input['tujuan'],
                    'catatan' => $input['catatan'],
                    'kategori' => 'catatan',
                    'user_id' => Auth()->user()->id,
                    'form_pengajuan_maklun_id' => $this->dataMaklun->id,
                ]);
            }
        }

        $updateApprove = FormPengajuanMaklun::find($PengajuanMaklunSelectedApproveId);
        $updateApprove->update([
            'harga_satuan_maklun' => currency_convert($this->harga_satuan_maklun),
            'qty_purchase_maklun' => currency_convert($this->qty_purchase_maklun),
            'total_harga_maklun' => currency_convert($this->total_harga_maklun),
            'status' => 'Approve Accounting',
            'pekerjaan' => 'Purchase',
            'previous_state' => 'Accounting',
            'accounting' => 'Accounting',
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Maklun Instruksi Kerja',
            'message' => 'Data berhasil disimpan',
        ]);

        $userDestination = User::where('role', 'Purchase')->get();
        foreach ($userDestination as $dataUser) {
            $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'Pengajuan Maklun', 'instruction_id' => $updateApprove->instruction_id]);
        }
        $this->emit('indexRender');
        $this->reset();
        $this->dispatchBrowserEvent('close-modal-pengajuan-new-maklun-spk');
    }

    public function rejectMaklun($PengajuanMaklunSelectedRejectId)
    {
        $this->validate([
            'harga_satuan_maklun' => 'required',
            'qty_purchase_maklun' => 'required',
            'total_harga_maklun' => 'required',
        ]);

        if (isset($this->notes)) {
            $this->validate([
                'notes.*.tujuan' => 'required',
                'notes.*.catatan' => 'required',
            ]);

            foreach ($this->notes as $input) {
                $catatan = CatatanPengajuan::create([
                    'tujuan' => $input['tujuan'],
                    'catatan' => $input['catatan'],
                    'kategori' => 'catatan',
                    'user_id' => Auth()->user()->id,
                    'form_pengajuan_maklun_id' => $this->dataMaklun->id,
                ]);
            }
        }

        $updateReject = FormPengajuanMaklun::find($PengajuanMaklunSelectedRejectId);
        $updateReject->update([
            'harga_satuan_maklun' => currency_convert($this->harga_satuan_maklun),
            'qty_purchase_maklun' => currency_convert($this->qty_purchase_maklun),
            'total_harga_maklun' => currency_convert($this->total_harga_maklun),
            'status' => 'Reject Accounting',
            'pekerjaan' => 'Purchase',
            'previous_state' => 'Accounting',
            'accounting' => 'Accounting',
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Maklun Instruksi Kerja',
            'message' => 'Data berhasil disimpan',
        ]);

        $userDestination = User::where('role', 'Purchase')->get();
        foreach ($userDestination as $dataUser) {
            $this->messageSent(['receiver' => $dataUser->id, 'conversation' => 'Pengajuan Maklun', 'instruction_id' => $updateReject->instruction_id]);
        }
        $this->emit('indexRender');
        $this->reset();
        $this->dispatchBrowserEvent('close-modal-pengajuan-new-maklun-spk');
    }

    public function cekTotalHargaMaklun()
    {
        $this->validate([
            'harga_satuan_maklun' => 'required',
            'qty_purchase_maklun' => 'required',
        ]);

        $hargaSatuanMaklunSelected = currency_convert($this->harga_satuan_maklun);
        $qtyPurchaseMaklunSelected = currency_convert($this->qty_purchase_maklun);

        $this->total_harga_maklun = $hargaSatuanMaklunSelected * $qtyPurchaseMaklunSelected;
        $this->total_harga_maklun = $this->total_harga_maklun;
    }

    public function modalPengajuanRejectMaklunSpk($PengajuanMaklunId, $instructionId)
    {
        $this->selectedInstruction = Instruction::find($instructionId);

        $dataworkStepHitungBahanNew = WorkStep::where('instruction_id', $instructionId)
            ->where('work_step_list_id', 5)
            ->first();
        if (isset($dataworkStepHitungBahanNew)) {
            $this->workStepHitungBahanNew = $dataworkStepHitungBahanNew->id;
        }

        $this->dataMaklun = FormPengajuanMaklun::find($PengajuanMaklunId);

        $this->harga_satuan_maklun = $this->dataMaklun->harga_satuan_maklun;
        $this->qty_purchase_maklun = $this->dataMaklun->qty_purchase_maklun;
        $this->total_harga_maklun = $this->dataMaklun->total_harga_maklun;

        $dataNote = CatatanPengajuan::where('user_id', Auth()->user()->id)
            ->where('form_pengajuan_maklun_id', $PengajuanMaklunId)
            ->get();

        if (isset($dataNote)) {
            foreach ($dataNote as $data) {
                $notes = [
                    'tujuan' => $data->tujuan,
                    'catatan' => $data->catatan,
                ];

                $this->notes[] = $notes;
            }
        }

        $this->catatan = CatatanPengajuan::where('form_pengajuan_maklun_id', $PengajuanMaklunId)
            ->with('user')
            ->get();
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
