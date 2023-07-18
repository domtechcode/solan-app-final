<?php

namespace App\Http\Livewire\Rab;

use Livewire\Component;
use App\Models\WorkStep;

class CreateFormRabIndex extends Component
{
    public $rabItems = [];
    public $workSteps;
    public $keteranganReject;
    public $currentInstructionId;
    public $notes = [];

    public function addRAB()
    {
        $this->rabItems[] = [
            'jenisPengeluaran' => '',
            'rab' => '',
        ];
    }

    public function removeRAB($index)
    {
        unset($this->rabItems[$index]);
        $this->rabItems = array_values($this->rabItems);
    }

    public function addEmptyNote()
    {
        $this->notes[] = '';
    }

    public function removeNote($index)
    {
        unset($this->notes[$index]);
        $this->notes = array_values($this->notes);
    }

    public function mount($instructionId)
    {
        $this->workSteps = WorkStep::where('instruction_id', $instructionId)->with('workStepList')->get();
        $dataWorkSteps = WorkStep::where('instruction_id', $instructionId)->get();

        $this->rabItems[] = [
            'jenisPengeluaran' => 'Bahan Baku',
            'rab' => '',
        ];

        foreach ($dataWorkSteps as $workStep) {
            if ($workStep->work_step_list_id == 7) {
                $this->rabItems[] = [
                    'jenisPengeluaran' => 'Plate',
                    'rab' => '',
                ];
            }
        }

        $this->rabItems[] = [
            'jenisPengeluaran' => 'Film',
            'rab' => '',
        ];

        $shouldAddUVWB = false;

        foreach ($dataWorkSteps as $workStep) {
            if ($workStep->work_step_list_id == 16 || $workStep->work_step_list_id == 17 || $workStep->work_step_list_id == 18 || $workStep->work_step_list_id == 23 || $workStep->work_step_list_id == 30) {
                $shouldAddUVWB = true;
            }
        }

        if ($shouldAddUVWB) {
            $this->rabItems[] = [
                'jenisPengeluaran' => 'UV/WB/Laminating',
                'rab' => '',
            ];
        }

        foreach ($dataWorkSteps as $workStep) {
            if ($workStep->work_step_list_id == 31) {
                $this->rabItems[] = [
                    'jenisPengeluaran' => 'Spot UV',
                    'rab' => '',
                ];
            }
        }

        foreach ($dataWorkSteps as $workStep) {
            if ($workStep->work_step_list_id == 24) {
                $this->rabItems[] = [
                    'jenisPengeluaran' => 'Pisau Pon',
                    'rab' => '',
                ];
            }
        }

        foreach ($dataWorkSteps as $workStep) {
            if ($workStep->work_step_list_id == 32) {
                $this->rabItems[] = [
                    'jenisPengeluaran' => 'Blok Lem',
                    'rab' => '',
                ];
            }
        }

        foreach ($dataWorkSteps as $workStep) {
            if ($workStep->work_step_list_id == 33) {
                $this->rabItems[] = [
                    'jenisPengeluaran' => 'Lem Lainnya',
                    'rab' => '',
                ];
            }
        }

        $shouldAddMatress = false;

        foreach ($dataWorkSteps as $workStep) {
            if ($workStep->work_step_list_id == 25 || $workStep->work_step_list_id == 26 || $workStep->work_step_list_id == 28) {
                $shouldAddMatress = true;
            }
        }

        if ($shouldAddMatress) {
            $this->rabItems[] = [
                'jenisPengeluaran' => 'Matress Foil/Emboss',
                'rab' => '',
            ];
        }

        foreach ($dataWorkSteps as $workStep) {
            if ($workStep->work_step_list_id == 34) {
                $this->rabItems[] = [
                    'jenisPengeluaran' => 'Mata Itik + Pasang',
                    'rab' => '',
                ];
            }
        }

        foreach ($dataWorkSteps as $workStep) {
            if ($workStep->work_step_list_id == 14) {
                $this->rabItems[] = [
                    'jenisPengeluaran' => 'Tali + Pasang',
                    'rab' => '',
                ];
            }
        }

        $this->rabItems[] = [
            'jenisPengeluaran' => 'Jasa Maklun',
            'rab' => '',
        ];

        foreach ($dataWorkSteps as $workStep) {
            if ($workStep->work_step_list_id == 12) {
                $this->rabItems[] = [
                    'jenisPengeluaran' => 'Biaya Packing',
                    'rab' => '',
                ];
            }
        }
        
        $this->rabItems[] = [
            'jenisPengeluaran' => 'Biaya Pengiriman',
            'rab' => '',
        ];


    }

    public function render()
    {
        return view('livewire.rab.create-form-rab-index')->extends('layouts.app')
        ->section('content')
        ->layoutData(['title' => 'Form RAB']);
    }
}
