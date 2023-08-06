<?php

namespace App\Http\Livewire\Accounting\Component;

use Livewire\Component;
use App\Models\Customer;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;

class CustomerIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];
    public $paginate = 10;
    public $search = '';

    public $name;
    public $taxes;
    public $selectedId;

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }
    
    public function render()
    {
        $searchTerms = '%' . $this->search . '%';

        $data = Customer::where('name', 'like', $searchTerms)
                ->orWhere('taxes', 'like', $searchTerms)
                ->paginate($this->paginate);    

        return view('livewire.accounting.component.customer-index', ['customers' => $data ])
        ->extends('layouts.app');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'taxes' => 'required',
        ]);

        $updateCustomer = Customer::find($this->selectedId);
        $updateCustomer->update([
            'name' => $this->name,
            'taxes' => $this->taxes,
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Customer',
            'message' => 'Berhasil menyimpan data Customer',
        ]);
        
        $this->reset();
        $this->reset();
        $this->dispatchBrowserEvent('close-detail-customer-edit');
    }

    public function modalCustomerEdit($customerId)
    {
        $dataCustomer = Customer::find($customerId);
        $this->name = $dataCustomer->name;
        $this->taxes = $dataCustomer->taxes;
        $this->selectedId = $dataCustomer->id;

        $this->dispatchBrowserEvent('show-detail-customer-edit');
    }

}
