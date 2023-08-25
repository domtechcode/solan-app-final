<?php

namespace App\Http\Livewire\Admin\Component;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\User;
use App\Models\Files;
use App\Models\Catatan;
use App\Models\Machine;
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

class DataMachineIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginateMachine = 10;
    public $searchMachine = '';

    public $idMachine;

    public $machine;
    public $type;

    public $machineUpdate;
    public $typeUpdate;

    protected $listeners = ['indexRender' => '$refresh'];

    public function updatingSearchMachine()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->searchMachine = request()->query('search', $this->searchMachine);
    }

    public function render()
    {
        $dataMachine = Machine::where(function ($query) {
            $searchTerms = '%' . $this->searchMachine . '%';
            $query
                ->where('machine_identity', 'like', $searchTerms)
                ->orWhere('type', 'like', $searchTerms);
        })->paginate($this->paginateMachine);

        return view('livewire.admin.component.data-machine-index', ['dataMachine' => $dataMachine])
            ->extends('layouts.app')
            ->layoutData(['title' => 'Data Machine']);
    }

    public function save()
    {
        $this->validate([
            'machine' => 'required',
            'type' => 'required',
        ]);

        $createMachine = Machine::create([
            'machine_identity' => $this->machine,
            'type' => $this->type,
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Data Machine',
            'message' => 'Data Machine berhasil disimpan',
        ]);
        
        $this->machine = null;
        $this->type = null;

        $this->emit('indexRender');
    }

    public function modalDetailsMachine($machineId)
    {
        $this->idMachine = $machineId;
        $dataMachine = Machine::find($machineId);
        $this->machineUpdate = $dataMachine->machine_identity;
        $this->typeUpdate = $dataMachine->type;
    }

    public function update()
    {
        $this->validate([
            'machineUpdate' => 'required',
            'typeUpdate' => 'required',
        ]);

        $createMachine = Machine::where('id', $this->idMachine)->update([
            'machine_identity' => $this->machineUpdate,
            'type' => $this->typeUpdate,
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Data Machine',
            'message' => 'Data Machine berhasil disimpan',
        ]);

        $this->dispatchBrowserEvent('close-modal-machine');
        $this->emit('indexRender');

        $this->machineUpdate = null;
        $this->typeUpdate = null;
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
