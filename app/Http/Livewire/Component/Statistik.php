<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use App\Models\WorkStep;
use App\Models\Instruction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Statistik extends Component
{
    public $totalOrder;
    public $prosesOrder;
    public $pendingOrder;
    public $completeOrder;

    public $spkLayout;
    public $spkSample;
    public $spkProduction;
    public $spkStock;

    public $spkProsesLayout;
    public $spkProsesSample;
    public $spkProsesProduction;
    public $spkProsesStock;

    public $spkPendingLayout;
    public $spkPendingSample;
    public $spkPendingProduction;
    public $spkPendingStock;

    public $spkCompleteLayout;
    public $spkCompleteSample;
    public $spkCompleteProduction;
    public $spkCompleteStock;
    public $userId;

    public function getListeners()
    {
        $this->userId = Auth()->user()->id;
        return [
            "echo:notif.{$this->userId},NotificationSent" => 'refreshIndex',
        ];
    }

    public function refreshIndex($data)
    {
        $instruction_id = $data['instruction_id'];
        $user_id = $data['user_id'];
        $message = $data['message'];
        $conversation_id = $data['conversation_id'];
        $receiver_id = $data['receiver_id'];
        if ($instruction_id != null) {
            $instructionData = Instruction::find($instruction_id);

            $this->emit('flashMessage', [
                'type' => 'info',
                'title' => $conversation_id,
                'message' => 'SPK ' . $instructionData->spk_number,
            ]);
        } else {
            $this->emit('flashMessage', [
                'type' => 'info',
                'title' => $conversation_id,
                'message' => $conversation_id,
            ]);
        }
    }

    public function mount()
    {
        $this->totalOrder = Instruction::count();
        $this->prosesOrder = Instruction::whereHas('workstep', function ($query) {
            $query->where('spk_state', '!=', 'Training Program')->where('status_id', 2);
        })->count();

        $this->pendingOrder = Instruction::whereHas('workstep', function ($query) {
            $query->where('spk_state', '!=', 'Training Program')->where('status_id', 1);
        })->count();

        $this->completeOrder = Instruction::whereHas('workstep', function ($query) {
            $query->where('work_step_list_id', 1)->where('spk_status', 'Selesai');
        })->count();

        $this->spkLayout = Instruction::where('type_order', 'layout')->count();
        $this->spkSample = Instruction::where('type_order', 'sample')->count();
        $this->spkProduction = Instruction::where('type_order', 'production')->count();
        $this->spkStock = Instruction::where('type_order', 'stock')->count();

        $this->spkProsesLayout = Instruction::where('type_order', 'layout')
            ->whereHas('workstep', function ($query) {
                $query->where('spk_state', '!=', 'Training Program')->where('status_id', 2);
            })
            ->count();

        $this->spkProsesSample = Instruction::where('type_order', 'sample')
            ->whereHas('workstep', function ($query) {
                $query->where('spk_state', '!=', 'Training Program')->where('status_id', 2);
            })
            ->count();

        $this->spkProsesProduction = Instruction::where('type_order', 'production')
            ->whereHas('workstep', function ($query) {
                $query->where('spk_state', '!=', 'Training Program')->where('status_id', 2);
            })
            ->count();

        $this->spkProsesStock = Instruction::where('type_order', 'stock')
            ->whereHas('workstep', function ($query) {
                $query->where('spk_state', '!=', 'Training Program')->where('status_id', 2);
            })
            ->count();

        $this->spkPendingLayout = Instruction::where('type_order', 'layout')
            ->whereHas('workstep', function ($query) {
                $query->where('spk_state', '!=', 'Training Program')->where('status_id', 1);
            })
            ->count();

        $this->spkPendingSample = Instruction::where('type_order', 'sample')
            ->whereHas('workstep', function ($query) {
                $query->where('spk_state', '!=', 'Training Program')->where('status_id', 1);
            })
            ->count();

        $this->spkPendingProduction = Instruction::where('type_order', 'production')
            ->whereHas('workstep', function ($query) {
                $query->where('spk_state', '!=', 'Training Program')->where('status_id', 1);
            })
            ->count();

        $this->spkPendingStock = Instruction::where('type_order', 'stock')
            ->whereHas('workstep', function ($query) {
                $query->where('spk_state', '!=', 'Training Program')->where('status_id', 1);
            })
            ->count();

        $this->spkCompleteLayout = Instruction::where('type_order', 'layout')
            ->whereHas('workstep', function ($query) {
                $query->where('work_step_list_id', 1)->where('spk_status', 'Selesai');
            })
            ->count();

        $this->spkCompleteSample = Instruction::where('type_order', 'sample')
            ->whereHas('workstep', function ($query) {
                $query->where('work_step_list_id', 1)->where('spk_status', 'Selesai');
            })
            ->count();

        $this->spkCompleteProduction = Instruction::where('type_order', 'production')
            ->whereHas('workstep', function ($query) {
                $query->where('work_step_list_id', 1)->where('spk_status', 'Selesai');
            })
            ->count();
        $this->spkCompleteStock = Instruction::where('type_order', 'stock')
            ->whereHas('workstep', function ($query) {
                $query->where('work_step_list_id', 1)->where('spk_status', 'Selesai');
            })
            ->count();
    }

    public function render()
    {           
        return view('livewire.component.statistik');
    }
}
