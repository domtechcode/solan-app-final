<?php

namespace App\Http\Livewire\Admin\Component;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\User;
use App\Models\Files;
use App\Models\Driver;
use App\Models\Catatan;
use Livewire\Component;
use App\Models\Customer;
use App\Models\WorkStep;
use App\Models\Instruction;
use Illuminate\Support\Str;
use App\Models\WorkStepList;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\DB;
use App\Models\PengajuanBarangPersonal;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DataDriverIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginateDriver = 10;
    public $searchDriver = '';

    public $idDriver;

    public $name;

    public $nameUpdate;

    protected $listeners = ['indexRender' => '$refresh'];

    public function updatingSearchDriver()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->searchDriver = request()->query('search', $this->searchDriver);
    }

    public function render()
    {
        $dataDriver = Driver::where(function ($query) {
            $searchTerms = '%' . $this->searchDriver . '%';
            $query
                ->where('name', 'like', $searchTerms);
        })->paginate($this->paginateDriver);

        return view('livewire.admin.component.data-driver-index', ['dataDriver' => $dataDriver])
            ->extends('layouts.app')
            ->layoutData(['title' => 'Data Driver']);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
        ]);

        $createDriver = Driver::create([
            'name' => $this->name,
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Data Driver',
            'message' => 'Data Driver berhasil disimpan',
        ]);
        
        $this->name = null;

        $this->emit('indexRender');
    }

    public function modalDetailsDriver($driverId)
    {
        $this->idDriver = $driverId;
        $dataUser = Driver::find($driverId);
        $this->nameUpdate = $dataUser->name;
    }

    public function update()
    {
        $this->validate([
            'nameUpdate' => 'required',
        ]);

        $createDriver = Driver::where('id', $this->idDriver)->update([
            'name' => $this->nameUpdate,
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Data Driver',
            'message' => 'Data Driver berhasil disimpan',
        ]);

        $this->dispatchBrowserEvent('close-modal-driver');
        $this->emit('indexRender');

        $this->nameUpdate = null;
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
