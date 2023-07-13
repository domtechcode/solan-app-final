<?php

namespace App\Http\Livewire\HitungBahan;

use Livewire\Component;

class CreateFormHitungBahanIndex extends Component
{
    public $formFields = [];

    public function addFormField()
    {
        $this->formFields[] = count($this->formFields) + 1;
    }

    public function removeFormField($index)
    {
        unset($this->formFields[$index]);
        $this->formFields = array_values($this->formFields);
    }
    
    public function render()
    {
        return view('livewire.hitung-bahan.create-form-hitung-bahan-index')->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Form Hitung Bahan']);
    }
}
