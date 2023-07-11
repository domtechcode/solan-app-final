<?php

namespace App\Http\Livewire\FollowUp;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Instruction;
use App\Models\WorkStepList;

class EditInstructionIndex extends Component
{
    public $instructions;
    public $spk_type;
    public $customer;
    public $customerCurrent;
    public $taxes_type;
    public $sub_spk;
    public $spk_parent;
    public $spk_number;
    public $spk_fsc;
    public $fsc_type;
    public $spk_number_fsc;
    public $order_date;
    public $shipping_date;
    public $customer_number;
    public $order_name;
    public $code_style;
    public $quantity;
    public $price;
    public $follow_up;
    public $type_ppn;
    public $ppn = 11.2 / 100;
    public $spk_layout_number;
    public $spk_sample_number;

    //data
    public $datacustomers = [];
    public $dataparents = [];
    public $datalayouts = [];
    public $datasamples = [];
    public $dataworksteplists = [];

    public function mount($instructionId)
    {
        $this->datacustomers = Customer::all();
        $this->dataparents = Instruction::where('spk_number', 'LIKE', '%-A')->orderByDesc('created_at')->get();
        $this->datalayouts = Instruction::where('spk_type', 'layout')->orderByDesc('created_at')->get();
        $this->datasamples = Instruction::where('spk_type', 'sample')->orderByDesc('created_at')->get();
        $this->dataworksteplists = WorkStepList::whereNotIn('name', ['Follow Up', 'Penjadwalan', 'RAB'])->get();

        $this->instructions = Instruction::findorfail($instructionId);
        $this->spk_type = $this->instructions->type_order;
        $this->sub_spk = $this->instructions->sub_spk;
        $this->customerCurrent = Customer::where('name', $this->instructions->customer_name)->where('taxes', $this->instructions->taxes_type)->first();
        $this->customer = $this->customerCurrent->id;
        $this->spk_parent = $this->instructions->spk_parent;
        $this->spk_number = $this->instructions->spk_number;
        $this->spk_fsc = $this->instructions->spk_fsc;
        $this->fsc_type = $this->instructions->fsc_type;
        $this->order_date = $this->instructions->order_date;
        $this->shipping_date = $this->instructions->shipping_date;
        $this->customer_number = $this->instructions->customer_number;
        $this->order_name = $this->instructions->order_name;
        $this->code_style = $this->instructions->code_style;
        $this->quantity = currency_idr($this->instructions->quantity);
        $this->price = currency_idr($this->instructions->price);
        $this->follow_up = $this->instructions->follow_up;
        $this->type_ppn = $this->instructions->type_ppn;
        $this->spk_layout_number = $this->instructions->spk_layout_number;
        $this->spk_sample_number = $this->instructions->spk_sample_number;

        $this->select2();
    }

    public function select2()
    {
        // Init Event
        $this->dispatchBrowserEvent('pharaonic.select2.init');
        
        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target'    => '#customer'
        ]);
        
        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target'    => '#spk_parent'
        ]);
        
        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target'    => '#spk_layout_number'
        ]);
        
        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target'    => '#spk_parent'
        ]);
    }
    
    public function render()
    {
        return view('livewire.follow-up.edit-instruction-index', [
            'title' => 'Form Edit Instruksi Kerja'
        ])
        ->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Form Edit Instruksi Kerja']);
    }

    public function update()
    {
        dd($this->spk_number);
    }
}
