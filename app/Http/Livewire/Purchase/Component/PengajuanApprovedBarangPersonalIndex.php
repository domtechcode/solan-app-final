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
use App\Models\PengajuanBarangPersonal;

class PengajuanApprovedBarangPersonalIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginatePengajuanApprovedBarangPersonal = 10;
    public $searchPengajuanApprovedBarangPersonal = '';

    public $selectedInstruction;
    public $selectedWorkStep;
    public $selectedFileContoh;
    public $selectedFileArsip;
    public $selectedFileAccounting;
    public $selectedFileLayout;
    public $selectedFileSample;
    public $notes = [];

    public $workStepHitungBahanNew;

    public $dataBarang;
    public $harga_satuan;
    public $qty_purchase;
    public $total_harga;
    public $stock;

    protected $listeners = ['indexRender' => '$refresh'];

    public function updatingSearchPengajuanApprovedBarangPersonal()
    {
        $this->resetPage();
    }

    public function addEmptyNote()
    {
        $this->notes[] = '';
    }

    public function removeNote($index)
    {
        unset($this->notes[$index]);
        $this->notes = array_values($this->notes);
    }

    public function mount()
    {
        $this->searchPengajuanApprovedBarangPersonal = request()->query('search', $this->searchPengajuanApprovedBarangPersonal);
    }

    public function render()
    {
        $dataPengajuanApprovedBarangPersonal = PengajuanBarangPersonal::whereIn('status_id', [13, 14])->where('state', 'Purchase')
            ->where(function ($query) {
                $query
                    ->where('qty_barang', 'like', '%' . $this->searchPengajuanApprovedBarangPersonal . '%')
                    ->orWhere('nama_barang', 'like', '%' . $this->searchPengajuanApprovedBarangPersonal . '%')
                    ->orWhere('tgl_target_datang', 'like', '%' . $this->searchPengajuanApprovedBarangPersonal . '%')
                    ->orWhere('tgl_pengajuan', 'like', '%' . $this->searchPengajuanApprovedBarangPersonal . '%');
            })
            ->with(['status', 'user'])
            ->orderBy('tgl_target_datang', 'asc')
            ->paginate($this->paginatePengajuanApprovedBarangPersonal);

        return view('livewire.purchase.component.pengajuan-approved-barang-personal-index', ['pengajuanApprovedBarangPersonal' => $dataPengajuanApprovedBarangPersonal])
            ->extends('layouts.app')
            ->section('content')
            ->layoutData(['title' => 'Dashboard']);
    }

    public function beliBarang($PengajuanBarangSelectedBeliId)
    {
        $this->validate(
            [
                'harga_satuan' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
                'qty_purchase' => 'required',
                'stock' => 'required',
                'total_harga' => 'required',
            ],
            [
                'harga_satuan.numeric' => 'Price harus berupa angka/tidak boleh ada tanda koma(,).',
            ],
        );

        $updateBeli = PengajuanBarangPersonal::find($PengajuanBarangSelectedBeliId);
        $updateBeli->update([
            'harga_satuan' => currency_convert($this->harga_satuan),
            'qty_purchase' => currency_convert($this->qty_purchase),
            'total_harga' => currency_convert($this->total_harga),
            'stock' => currency_convert($this->stock),
            'status_id' => 15,
            'state' => 'Purchase',
            'previous_state' => 'Purchase',
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Stock Instruksi Kerja',
            'message' => 'Data berhasil disimpan',
        ]);

        $this->emit('indexRender');
        $this->reset();
        $this->dispatchBrowserEvent('close-modal-pengajuan-approved-barang-personal');
    }

    public function modalPengajuanApprovedBarangPersonal($PengajuanBarangId)
    {
        $this->notes = [];

        $this->dataBarang = PengajuanBarangPersonal::find($PengajuanBarangId);

        if (isset($this->dataBarang) && $this->dataBarang->harga_satuan != null) {
            $this->harga_satuan = $this->dataBarang->harga_satuan;
            $this->qty_purchase = $this->dataBarang->qty_purchase;
            $this->stock = $this->dataBarang->stock;
            $this->total_harga = $this->dataBarang->total_harga;
        } else {
            $this->harga_satuan = '';
            $this->qty_purchase = '';
            $this->stock = '';
            $this->total_harga = '';
        }

        $dataNote = CatatanPengajuan::where('user_id', Auth()->user()->id)->where('form_pengajuan_barang_personal_id', $PengajuanBarangId)->get();

        if(isset($dataNote)){
            foreach ($dataNote as $data) {
                $notes = [
                    'tujuan' => $data->tujuan,
                    'catatan' => $data->catatan,
                ];

                $this->notes [] = $notes;
            }
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
