<?php

namespace App\Http\Livewire\FollowUp;

use Livewire\Component;
use App\Models\Instruction;
use Livewire\WithPagination;

class ShowInstruction extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];
    protected $listeners = [
        'reloadTableInstruction' => '$refresh'
    ];

    public $paginate = 10;
    public $search = '';
    public $data;

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }

    public function render()
    {
        return view('livewire.follow-up.show-instruction',[
            'instructions' => $this->search === null ?
                            Instruction::latest()->paginate($this->paginate) :
                            Instruction::latest()->where('spk_number', 'like', '%' . $this->search . '%')->paginate($this->paginate),
            'title' => 'Dashboard'
        ])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Dashboard']);
    }
}
