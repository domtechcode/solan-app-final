<?php

namespace App\Http\Livewire\Accounting\Index;

use Livewire\Component;
use App\Models\Customer;
use App\Models\WorkStep;
use App\Models\Instruction;
use Livewire\WithPagination;

class IndexCustomer extends Component
{    
    public function render()
    {
        return view('livewire.accounting.index.index-customer', ['title' => 'Data Customer' ])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Data Customer']);
    }

}
