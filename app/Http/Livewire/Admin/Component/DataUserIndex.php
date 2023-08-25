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

class DataUserIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    public $paginateUser = 10;
    public $searchUser = '';

    public $idUser;

    public $name;
    public $role;
    public $jobdesk;
    public $username;
    public $password;
    public $dataJobDesk;

    public $nameUpdate;
    public $roleUpdate;
    public $jobdeskUpdate;
    public $usernameUpdate;
    public $passwordUpdate;
    public $currentUpdate;

    protected $listeners = ['indexRender' => '$refresh'];

    public function updatingSearchUser()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->dataJobDesk = Job::whereNotIn('id', ['1', '2', '3', '4'])->get();
        $this->searchUser = request()->query('search', $this->searchUser);
    }

    public function render()
    {
        $dataUser = User::where(function ($query) {
            $searchTerms = '%' . $this->searchUser . '%';
            $query
                ->where('name', 'like', $searchTerms)
                ->orWhere('username', 'like', $searchTerms)
                ->orWhere('role', 'like', $searchTerms)
                ->orWhere('jobdesk', 'like', $searchTerms);
        })->paginate($this->paginateUser);

        return view('livewire.admin.component.data-user-index', ['dataUser' => $dataUser])
            ->extends('layouts.app')
            ->layoutData(['title' => 'Data User']);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'role' => 'required',
            'jobdesk' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',
        ]);

        $createUser = User::create([
            'name' => $this->name,
            'role' => $this->role,
            'jobdesk' => $this->jobdesk,
            'username' => $this->username,
            'password' => bcrypt($this->password),
            'current' => $this->password,
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Data User',
            'message' => 'Data User berhasil disimpan',
        ]);
        
        $this->name = null;
        $this->role = null;
        $this->jobdesk = null;
        $this->username = null;
        $this->password = null;

        $this->emit('indexRender');
    }

    public function modalDetailsUser($userId)
    {
        $this->idUser = $userId;
        $dataUser = User::find($userId);
        $this->nameUpdate = $dataUser->name;
        $this->usernameUpdate = $dataUser->username;
        $this->roleUpdate = $dataUser->role;
        $this->jobdeskUpdate = $dataUser->jobdesk;
        $this->passwordUpdate = $dataUser->current;
        $this->currentUpdate = $dataUser->current;
    }

    public function update()
    {
        $this->validate([
            'nameUpdate' => 'required',
            'roleUpdate' => 'required',
            'jobdeskUpdate' => 'required',
            'usernameUpdate' => 'required',
            'passwordUpdate' => 'required',
        ]);

        $createUser = User::where('id', $this->idUser)->update([
            'name' => $this->nameUpdate,
            'role' => $this->roleUpdate,
            'jobdesk' => $this->jobdeskUpdate,
            'username' => $this->usernameUpdate,
            'password' => bcrypt($this->passwordUpdate),
            'current' => $this->passwordUpdate,
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Data User',
            'message' => 'Data User berhasil disimpan',
        ]);

        $this->dispatchBrowserEvent('close-modal-user');
        $this->emit('indexRender');

        $this->nameUpdate = null;
        $this->roleUpdate = null;
        $this->jobdeskUpdate = null;
        $this->usernameUpdate = null;
        $this->passwordUpdate = null;
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
