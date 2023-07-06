<?php

namespace App\Http\Livewire\FollowUp;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
    public $search = '';
    protected $updatesQueryString = ['search'];
    
    public $data;
    
    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }

    public function render()
    {
        return view('livewire.follow-up.dashboard',[
            'instructions' => $this->search === null ?
                            User::latest()->paginate($this->paginate) :
                            User::latest()->where('name', 'like', '%' . $this->search . '%')->paginate($this->paginate)
        ]);
    }
}
