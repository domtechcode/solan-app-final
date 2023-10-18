<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\WorkStep;
use Illuminate\Console\Command;

class UpdateWorksteps extends Command
{
    protected $signature = 'update:worksteps';

    protected $description = 'Update the worksteps';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = Carbon::now()->toDateString();
        $cari = WorkStep::select('instruction_id')->where('target_date', '<', $today)->whereNotIn('status_task', ['Complete', 'Waiting', 'Selesai'])->where('spk_status', 'Running')->distinct()->get()->toArray();
        $cariPengiriman = WorkStep::select('instruction_id')
                        ->whereNotIn('status_task', ['Complete', 'Waiting', 'Selesai'])
                        ->where('spk_status', 'Running')
                        ->whereHas('instruction', function ($query) use ($today) {
                            $query->where('shipping_date', '<', $today);
                        })
                        ->distinct()
                        ->get()
                        ->toArray();

        if(isset($cari) && isset($cariPengiriman)){
            for ($i = 0; $i < count($cari); $i++) {
                WorkStep::where('instruction_id', $cari[$i]['instruction_id'])->whereNotIn('status_task', ['Complete', 'Waiting', 'Selesai'])->where('spk_status', 'Running')->whereNotIn('work_step_list_id', [3, 4, 5])->update([
                    'schedule_state' => 'Late By Schedule',
                ]);
                WorkStep::where('instruction_id', $cari[$i]['instruction_id'])->whereIn('work_step_list_id', [1, 2])->update([
                    'schedule_state' => 'Late By Schedule',
                ]);
            }

            for ($i = 0; $i < count($cariPengiriman); $i++) {
                WorkStep::where('instruction_id', $cariPengiriman[$i]['instruction_id'])->whereNotIn('status_task', ['Complete', 'Waiting', 'Selesai'])->where('spk_status', 'Running')->whereNotIn('work_step_list_id', [3, 4, 5])->update([
                    'delivery_state' => 'Late By Delivery',
                ]);
                WorkStep::where('instruction_id', $cariPengiriman[$i]['instruction_id'])->whereIn('work_step_list_id', [1, 2])->update([
                    'delivery_state' => 'Late By Delivery',
                ]);
            }
        }

        $this->info('Worksteps updated successfully.');
    }
}
