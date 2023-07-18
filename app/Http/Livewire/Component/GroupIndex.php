<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use App\Models\WorkStep;
use Livewire\WithPagination;

class GroupIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];
    public $paginate = 10;
    public $search = '';

    public $inputsNewGroup = [];
    public $inputsCurrentGroup = [];

    public function addFieldNewGroup($type, $spk_number, $id)
    {
        $this->inputsNewGroup[] = [
            'type' => $type,
            'spk_number' => $spk_number,
            'id' => $id
        ];
    }

    public function removeFieldNewGroup($index)
    {
        unset($this->inputsNewGroup[$index]);
        $this->inputsNewGroup = array_values($this->inputsNewGroup);
    }

    public function addFieldCurrentGroup($spk_number, $id)
    {
        $this->inputsCurrentGroup[] = [
            'spk_number' => $spk_number,
            'id' => $id
        ];
    }

    public function removeFieldCurrentGroup($index)
    {
        unset($this->inputsCurrentGroup[$index]);
        $this->inputsCurrentGroup = array_values($this->inputsCurrentGroup);
    }

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }
    
    public function render()
    {
        return view('livewire.component.group-index', [
            'instructions' => $this->search === null ?
                            WorkStep::where('work_step_list_id', 1)
                                        ->whereHas('instruction', function ($query) {
                                            $query->orderBy('shipping_date', 'asc');
                                        })
                                        ->with(['status', 'jobs'])
                                        ->paginate($this->paginate) :
                            WorkStep::where('work_step_list_id', 1)
                                        ->whereHas('instruction', function ($query) {
                                            $query->where('spk_number', 'like', '%' . $this->search . '%')
                                            ->orWhere('spk_type', 'like', '%' . $this->search . '%')
                                            ->orWhere('customer_name', 'like', '%' . $this->search . '%')
                                            ->orWhere('order_name', 'like', '%' . $this->search . '%')
                                            ->orWhere('customer_number', 'like', '%' . $this->search . '%')
                                            ->orWhere('code_style', 'like', '%' . $this->search . '%')
                                            ->orWhere('shipping_date', 'like', '%' . $this->search . '%')
                                            ->orderBy('shipping_date', 'asc');
                                        })
                                        ->with(['status', 'job'])
                                        ->paginate($this->paginate)
        ])
        ->extends('layouts.app')
        ->layoutData(['title' => 'Form Instruksi Kerja']);
    }

    public function newGroup()
    {
        dd($this->inputsNewGroup);
    }

    public function currentGroup()
    {
        dd($this->inputsCurrentGroup);
    }
}
