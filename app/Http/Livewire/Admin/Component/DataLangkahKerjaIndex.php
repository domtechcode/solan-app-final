<?php

namespace App\Http\Livewire\Admin\Component;

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
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\DB;
use App\Models\PengajuanBarangPersonal;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DataLangkahKerjaIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginateLangkahKerja = 10;
    public $searchLangkahKerja = '';

    public $idLangkahKerja;

    public $name;

    public $nameUpdate;

    protected $listeners = ['indexRender' => '$refresh'];

    public function updatingSearchLangkahKerja()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->searchLangkahKerja = request()->query('search', $this->searchLangkahKerja);
    }

    public function render()
    {
        $dataLangkahKerja = WorkStepList::where(function ($query) {
            $searchTerms = '%' . $this->searchLangkahKerja . '%';
            $query
                ->where('name', 'like', $searchTerms);
        })->paginate($this->paginateLangkahKerja);

        return view('livewire.admin.component.data-langkah-kerja-index', ['dataLangkahKerja' => $dataLangkahKerja])
            ->extends('layouts.app')
            ->layoutData(['title' => 'Data Langkah Kerja']);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
        ]);

        $currentWorkStepList = WorkStepList::count();

        $createWorkStepList = WorkStepList::create([
            'name' => $this->name,
            'no_urut' => $currentWorkStepList + 1,
        ]);

        $createJob = Job::create([
            'desc_job' => $this->name,
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Data User',
            'message' => 'Data User berhasil disimpan',
        ]);
        
        $this->name = null;

        $this->emit('indexRender');
    }

    public function modalDetailsLangkahKerja($langkahKerjaId)
    {
        $this->idLangkahKerja = $langkahKerjaId;
        $langkahKerja = WorkStepList::find($langkahKerjaId);
        $this->nameUpdate = $langkahKerja->name;
    }

    public function update()
    {
        $this->validate([
            'nameUpdate' => 'required',
        ]);

        $createWorkStepList = WorkStepList::where('id', $this->idLangkahKerja)->update([
            'name' => $this->nameUpdate,
        ]);

        $createJob = Job::where('id', $this->idLangkahKerja)->update([
            'desc_job' => $this->nameUpdate,
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Data User',
            'message' => 'Data User berhasil disimpan',
        ]);

        $this->dispatchBrowserEvent('close-modal-langkah-kerja');
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
