<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KeteranganScreen;

class KeteranganScreensTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            
            ["id"=>"1","instruction_id"=>"2","keterangan_id"=>"1","state_screen"=>"repeat","jumlah_screen"=>"24","ukuran_screen"=>"24"],
["id"=>"6","instruction_id"=>"3","keterangan_id"=>"6","state_screen"=>"repeat","jumlah_screen"=>"345","ukuran_screen"=>"345"]

            
                    ];
            
                    foreach ($data as $keteranganscreen) {
                        KeteranganScreen::create($keteranganscreen);
                    }
    }
}
