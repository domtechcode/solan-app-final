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
        // $dataCollect = WorkStep::where('spk_status', 'Training Program')->get();
        // foreach ($dataCollect as $key => $data) {
        //     $current = WorkStep::where('instruction_id', $data['instruction_id'])->where('work_step_list_id', 1)->first();
        //     if(isset($current)){
        //         WorkStep::where('instruction_id', $data['instruction_id'])->update([
        //             'status_task' => 'Selesai',
        //             'state_task' => 'Selesai',
        //             'status_id' => '7',
        //             'spk_status' => 'Selesai',
        //         ]);
        //     }else{
        //         $create = WorkStep::create([
        //             'instruction_id' => $data['instruction_id'],
        //             'work_step_list_id' => 1,
        //             'user_id' => 2,
        //         ]);

        //         WorkStep::where('instruction_id', $data['instruction_id'])->update([
        //             'status_task' => 'Selesai',
        //             'state_task' => 'Selesai',
        //             'status_id' => '7',
        //             'job_id' => $data['job_id'],
        //             'spk_status' => 'Selesai',
        //         ]);
        //     }
        // }

        $this->totalOrder = Instruction::count();

        $this->prosesOrder = Instruction::whereHas('workstep', function ($query) {
            $query->where('work_step_list_id', 1)->where('status_id', 2)->where('spk_status', 'Running');
        })->count();

        $this->pendingOrder = Instruction::whereHas('workstep', function ($query) {
            $query->where('work_step_list_id', 1)->where('status_id', 1)->where('spk_status', 'Running');
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
                $query->where('work_step_list_id', 1)->where('status_id', 2)->where('spk_status', 'Running');
            })
            ->count();

        $this->spkProsesSample = Instruction::where('type_order', 'sample')
            ->whereHas('workstep', function ($query) {
                $query->where('work_step_list_id', 1)->where('status_id', 2)->where('spk_status', 'Running');
            })
            ->count();

        $this->spkProsesProduction = Instruction::where('type_order', 'production')
            ->whereHas('workstep', function ($query) {
                $query->where('work_step_list_id', 1)->where('status_id', 2)->where('spk_status', 'Running');
            })
            ->count();

        $this->spkProsesStock = Instruction::where('type_order', 'stock')
            ->whereHas('workstep', function ($query) {
                $query->where('work_step_list_id', 1)->where('status_id', 2)->where('spk_status', 'Running');
            })
            ->count();

        $this->spkPendingLayout = Instruction::where('type_order', 'layout')
            ->whereHas('workstep', function ($query) {
                $query->where('work_step_list_id', 1)->where('status_id', 1)->where('spk_status', 'Running');
            })
            ->count();

        $this->spkPendingSample = Instruction::where('type_order', 'sample')
            ->whereHas('workstep', function ($query) {
                $query->where('work_step_list_id', 1)->where('status_id', 1)->where('spk_status', 'Running');
            })
            ->count();

        $this->spkPendingProduction = Instruction::where('type_order', 'production')
            ->whereHas('workstep', function ($query) {
                $query->where('work_step_list_id', 1)->where('status_id', 1)->where('spk_status', 'Running');
            })
            ->count();

        $this->spkPendingStock = Instruction::where('type_order', 'stock')
            ->whereHas('workstep', function ($query) {
                $query->where('work_step_list_id', 1)->where('status_id', 1)->where('spk_status', 'Running');
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
