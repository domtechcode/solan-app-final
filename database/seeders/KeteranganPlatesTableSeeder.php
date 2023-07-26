<?php

namespace Database\Seeders;

use App\Models\KeteranganPlate;
use Illuminate\Database\Seeder;

class KeteranganPlatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            
            ["id"=>"1","instruction_id"=>"2","keterangan_id"=>"1","state_plate"=>"baru","jumlah_plate"=>"2","ukuran_plate"=>"42"],
["id"=>"2","instruction_id"=>"2","keterangan_id"=>"1","state_plate"=>"sample","jumlah_plate"=>"24","ukuran_plate"=>"24"],
["id"=>"11","instruction_id"=>"3","keterangan_id"=>"6","state_plate"=>"baru","jumlah_plate"=>"345","ukuran_plate"=>"345"],
["id"=>"12","instruction_id"=>"3","keterangan_id"=>"6","state_plate"=>"sample","jumlah_plate"=>"5345","ukuran_plate"=>"34"]


            
                    ];
            
                    foreach ($data as $keteranganplate) {
                        KeteranganPlate::create($keteranganplate);
                    }
    }
}
