<?php

namespace App\Http\Livewire\Rab;

use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use App\Models\LayoutBahan;
use App\Models\KeteranganPlate;

class CreateFormRabIndex extends Component
{
    public $rabItems = [];
    public $instructionItems = [];
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
        $this->currentInstructionId = $instructionId;
        
        $cekGroup = Instruction::where('id', $instructionId)
            ->whereNotNull('group_id')
            ->whereNotNull('group_priority')
            ->first();

        if (!$cekGroup){
            $this->instructionData = Instruction::where('id', $instructionId)->get();
            foreach ($this->instructionData as $instruction) {
                $this->instructionItems[] = [
                    'spk_number' => $instruction->spk_number,
                    'price' => currency_idr($instruction->price),
                ];
            }
        }else{
            $instructionGroup = Instruction::where('group_id', $cekGroup->group_id)->get();
            $this->instructionData = Instruction::whereIn('id', $instructionGroup->pluck('id'))->get();
            foreach ($this->instructionData as $instruction) {
                $this->instructionItems[] = [
                    'spk_number' => $instruction->spk_number,
                    'price' => currency_idr($instruction->price),
                ];
            }
        }

        $this->workSteps = WorkStep::where('instruction_id', $instructionId)->with('workStepList')->get();
        $dataWorkSteps = WorkStep::where('instruction_id', $instructionId)->get();

        $priceBahanBaku = LayoutBahan::where('instruction_id', $instructionId)->get();
        $totalPrice = 0;

        foreach ($priceBahanBaku as $layoutBahan) {
            $totalPrice += $layoutBahan->jumlah_bahan * $layoutBahan->harga_bahan;
        }

        $this->rabItems[] = [
            'jenisPengeluaran' => 'Bahan Baku',
            'rab' => currency_idr($totalPrice),
        ];

        $plateTotal = KeteranganPlate::where('instruction_id', $instructionId)->get();
        $totalPlate = 0;

        foreach ($plateTotal as $keteranganPlate) {
            $totalPlate += $keteranganPlate->jumlah_plate;
        }

        foreach ($dataWorkSteps as $workStep) {
            if ($workStep->work_step_list_id == 7) {
                $this->rabItems[] = [
                    'jenisPengeluaran' => 'Plate',
                    'rab' => $totalPlate,
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
