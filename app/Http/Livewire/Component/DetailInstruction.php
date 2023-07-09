<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use App\Models\Instruction;

class DetailInstruction extends Component
{
    public $selectedInstruction;

    protected $listeners = [
        'detailInstruction' => 'showModal'
    ];

    public function showModal($instructionId)
    {
        $this->selectedInstruction = Instruction::find($instructionId);
        $this->emit('showModal', 'detailinstructionsmodal');
    }

    public function mount()
    {
        $this->initializedProperties();
    }

    public function render()
    {
        return view('livewire.component.detail-instruction');
    }


    private function initializedProperties()
    {
        $this->resetErrorBag();
    }
}
