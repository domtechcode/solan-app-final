<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["id"=>"1","desc_status"=>"Pending Approved"],
            ["id"=>"2","desc_status"=>"Process"],
            ["id"=>"3","desc_status"=>"Reject"],
            ["id"=>"4","desc_status"=>"Cancel"],
            ["id"=>"5","desc_status"=>"Hold"],
            ["id"=>"6","desc_status"=>"Late"],
            ["id"=>"7","desc_status"=>"Complete"],
            ["id"=>"8","desc_status"=>"Pending"],
            ["id"=>"9","desc_status"=>"Process Stock"],
            ["id"=>"10","desc_status"=>"Process Accounting"],
            ["id"=>"11","desc_status"=>"Process RAB"],
            ["id"=>"12","desc_status"=>"Reply Stock"],
            ["id"=>"13","desc_status"=>"Approve Accounting"],
            ["id"=>"14","desc_status"=>"Approve RAB"],
            ["id"=>"15","desc_status"=>"Beli"],
            ["id"=>"16","desc_status"=>"Complete"],
            ["id"=>"17","desc_status"=>"Reject RAB"],
            ["id"=>"18","desc_status"=>"Reject Accounting"],
            ["id"=>"19","desc_status"=>"Not Running"],
            ["id"=>"20","desc_status"=>"Running"],
            ["id"=>"21","desc_status"=>"Revisi"],
            ["id"=>"22","desc_status"=>"Reject Requirements"],
            ["id"=>"23","desc_status"=>"Process Split"],
            ["id"=>"24","desc_status"=>"Waiting Qc"],
            ["id"=>"25","desc_status"=>"Hold RAB"],
        ];
        foreach ($data as $status) {
            Status::create($status);
        }
    }
}
