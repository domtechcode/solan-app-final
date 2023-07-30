<?php

namespace Database\Seeders;

use App\Models\KeteranganFoil;
use Illuminate\Database\Seeder;

class KeteranganFoilsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ "id" => "1", "instruction_id" => "274", "keterangan_id" => "134", "state_foil" => "baru", "jumlah_foil" => "1", ],


            
                    ];
            
                    foreach ($data as $keteranganFoil) {
                        KeteranganFoil::create($keteranganFoil);
                    }
    }
}
