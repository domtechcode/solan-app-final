<?php

namespace App\Http\Livewire\Purchase\Component;

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

class PengajuanApprovedMaklunSpkIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginatePengajuanApprovedMaklunSpk = 10;
    public $searchPengajuanApprovedMaklunSpk = '';

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

    public function updatingSearchPengajuanApprovedMaklunSpk()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->searchPengajuanApprovedMaklunSpk = request()->query('search', $this->searchPengajuanApprovedMaklunSpk);
    }

    public function render()
    {
        $dataPengajuanApprovedMaklunSpk = FormPengajuanMaklun::whereIn('status', ['Approve Accounting', 'Approve RAB'])
            ->where('pekerjaan', 'Purchase')
            ->where(function ($query) {
                $query
                    ->whereHas('instruction', function ($instructionQuery) {
                        $instructionQuery
                            ->where('spk_number', 'like', '%' . $this->searchPengajuanApprovedMaklunSpk . '%')
                            ->orWhere('spk_type', 'like', '%' . $this->searchPengajuanApprovedMaklunSpk . '%')
                            ->orWhere('customer_name', 'like', '%' . $this->searchPengajuanApprovedMaklunSpk . '%')
                            ->orWhere('order_name', 'like', '%' . $this->searchPengajuanApprovedMaklunSpk . '%')
                            ->orWhere('customer_number', 'like', '%' . $this->searchPengajuanApprovedMaklunSpk . '%')
                            ->orWhere('code_style', 'like', '%' . $this->searchPengajuanApprovedMaklunSpk . '%')
                            ->orWhere('shipping_date', 'like', '%' . $this->searchPengajuanApprovedMaklunSpk . '%')
                            ->orWhere('ukuran_barang', 'like', '%' . $this->searchPengajuanApprovedMaklunSpk . '%')
                            ->orWhere('spk_number_fsc', 'like', '%' . $this->searchPengajuanApprovedMaklunSpk . '%');
                    })
                    ->OrWhere(function ($sub) {
                        $sub->where('bentuk_maklun', 'like', '%' . $this->searchPengajuanApprovedMaklunSpk . '%')
                            ->orWhere('rekanan', 'like', '%' . $this->searchPengajuanApprovedMaklunSpk . '%')
                            ->orWhere('tgl_keluar', 'like', '%' . $this->searchPengajuanApprovedMaklunSpk . '%')
                            ->orWhere('qty_keluar', 'like', '%' . $this->searchPengajuanApprovedMaklunSpk . '%');
                    });
            })
            ->with(['instruction'])
            ->orderBy('tgl_keluar', 'asc')
            ->paginate($this->paginatePengajuanApprovedMaklunSpk);

        return view('livewire.purchase.component.pengajuan-approved-maklun-spk-index', ['pengajuanApprovedMaklunSpk' => $dataPengajuanApprovedMaklunSpk])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function completeMaklun($PengajuanMaklunSelectedCompleteId)
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

            $deleteCatatan = CatatanPengajuan::where('user_id', Auth()->user()->id)
                ->where('form_pengajuan_maklun_id', $this->dataMaklun->id)
                ->delete();
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

        $updateComplete = FormPengajuanMaklun::find($PengajuanMaklunSelectedCompleteId);
        $updateComplete->update([
            'harga_satuan_maklun' => currency_convert($this->harga_satuan_maklun),
            'qty_purchase_maklun' => currency_convert($this->qty_purchase_maklun),
            'total_harga_maklun' => currency_convert($this->total_harga_maklun),
            'status' => 'Complete',
            'pekerjaan' => 'Purchase',
            'previous_state' => 'Purchase',
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Maklun Instruksi Kerja',
            'message' => 'Data berhasil disimpan',
        ]);
        $this->emit('indexRender');
        $this->reset();
        $this->dispatchBrowserEvent('close-modal-pengajuan-approved-maklun-spk');
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

    public function modalPengajuanApprovedMaklunSpk($PengajuanMaklunId, $instructionId)
    {
        $this->reset();
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
