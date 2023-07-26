<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KeteranganPisauPond;

class KeteranganPisauPondsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["id"=>"1","instruction_id"=>"2","keterangan_id"=>"1","state_pisau"=>"baru","jumlah_pisau"=>"242"],
["id"=>"2","instruction_id"=>"2","keterangan_id"=>"1","state_pisau"=>"sample","jumlah_pisau"=>"24"],
["id"=>"11","instruction_id"=>"3","keterangan_id"=>"6","state_pisau"=>"baru","jumlah_pisau"=>"345"],
["id"=>"12","instruction_id"=>"3","keterangan_id"=>"6","state_pisau"=>"sample","jumlah_pisau"=>"345"]

            
                    ];
            
                    foreach ($data as $keteranganpisaupond) {
                        KeteranganPisauPond::create($keteranganpisaupond);
                    }
    }
}
