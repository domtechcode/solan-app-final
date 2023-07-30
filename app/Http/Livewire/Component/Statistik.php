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


    protected $listeners = ['notifSent' => 'refreshIndex', 'indexRender' => 'renderIndex'];

    public function refreshIndex($data)
    {
            $instruction_id = $data['instruction_id'];
            $user_id = $data['user_id'];
            $message = $data['message'];
            $conversation_id = $data['conversation_id'];
            $receiver_id = $data['receiver_id'];
            if($instruction_id){
                $instructionData = Instruction::find($instruction_id);
        
                $this->emit('flashMessage', [
                            'type' => $message,
                            'title' => $conversation_id,
                            'message' => 'SPK '.$instructionData->spk_number,
                    ]);
            }
    }

    public function renderIndex()
    {
        $this->render();
    }

   
    public function render()
    {
        $this->totalOrder = Instruction::count();
        $this->prosesOrder = Instruction::whereHas('workstep', function ($query) {
                            $query->where('spk_status', '!=', 'Training Program')
                                  ->where('status_id', 2);
                        })->count();

        $this->pendingOrder = Instruction::whereHas('workstep', function ($query) {
                            $query->where('spk_status', '!=', 'Training Program')
                            ->where('status_id', 1);
                        })->count();

        $this->completeOrder = Instruction::where('spk_state', 'Selesai')->count();

        $this->spkLayout = Instruction::where('type_order', 'layout')->count();
        $this->spkSample = Instruction::where('type_order', 'sample')->count();
        $this->spkProduction = Instruction::where('type_order', 'production')->count();
        $this->spkStock = Instruction::where('type_order', 'stock')->count();

        $this->spkProsesLayout = Instruction::where('type_order', 'layout')
                                ->whereHas('workstep', function ($query) {
                                    $query->where('spk_status', '!=', 'Training Program')->where('status_id', 2);
                                })->count();

        $this->spkProsesSample = Instruction::where('type_order', 'sample')
                                ->whereHas('workstep', function ($query) {
                                    $query->where('spk_status', '!=', 'Training Program')->where('status_id', 2);
                                })->count();

        $this->spkProsesProduction = Instruction::where('type_order', 'production')
                                ->whereHas('workstep', function ($query) {
                                    $query->where('spk_status', '!=', 'Training Program')->where('status_id', 2);
                                })->count();

        $this->spkProsesStock = Instruction::where('type_order', 'stock')
                                ->whereHas('workstep', function ($query) {
                                    $query->where('spk_status', '!=', 'Training Program')->where('status_id', 2);
                                })->count();

        $this->spkPendingLayout = Instruction::where('type_order', 'layout')
                                ->whereHas('workstep', function ($query) {
                                    $query->where('spk_status', '!=', 'Training Program')->where('status_id', 1);
                                })->count();

        $this->spkPendingSample = Instruction::where('type_order', 'sample')
                                ->whereHas('workstep', function ($query) {
                                    $query->where('spk_status', '!=', 'Training Program')->where('status_id', 1);
                                })->count();

        $this->spkPendingProduction = Instruction::where('type_order', 'production')
                                ->whereHas('workstep', function ($query) {
                                    $query->where('spk_status', '!=', 'Training Program')->where('status_id', 1);
                                })->count();

        $this->spkPendingStock = Instruction::where('type_order', 'stock')
                                ->whereHas('workstep', function ($query) {
                                    $query->where('spk_status', '!=', 'Training Program')->where('status_id', 1);
                                })->count();

        $this->spkCompleteLayout = Instruction::where('type_order', 'layout')->where('spk_state', 'Selesai')->count();
        $this->spkCompleteSample = Instruction::where('type_order', 'sample')->where('spk_state', 'Selesai')->count();
        $this->spkCompleteProduction = Instruction::where('type_order', 'production')->where('spk_state', 'Selesai')->count();
        $this->spkCompleteStock = Instruction::where('type_order', 'stock')->where('spk_state', 'Selesai')->count();

        return view('livewire.component.statistik');
    }
}
