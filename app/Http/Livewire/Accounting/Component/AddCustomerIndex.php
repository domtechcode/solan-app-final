<?php

namespace App\Http\Livewire\Accounting\Component;

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
use Livewire\WithFileUploads;
use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AddCustomerIndex extends Component
{
    use WithFileUploads;
    public $name;
    public $taxes;

    public function render()
    {
        return view('livewire.accounting.component.add-customer-index')
            ->extends('layouts.app')
            ->layoutData(['title' => 'Form Instruksi Kerja']);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'taxes' => 'required',
        ]);

        $createCustomer = Customer::create([
            'name' => $this->name,
            'taxes' => $this->taxes,
        ]);

        $this->emit('flashMessage', [
            'type' => 'success',
            'title' => 'Customer',
            'message' => 'Berhasil menyimpan data Customer',
        ]);

        $this->reset();
        $this->render();
    }
}
