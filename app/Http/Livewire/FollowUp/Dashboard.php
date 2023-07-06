<?php

namespace App\Http\Livewire\FollowUp;

use Livewire\Component;
use App\Models\Instruction;
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
                            Instruction::latest()->paginate($this->paginate) :
                            Instruction::latest()->where('spk_number', 'like', '%' . $this->search . '%')->paginate($this->paginate)
        ]);
    }
}
