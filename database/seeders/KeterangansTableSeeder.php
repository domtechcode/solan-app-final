<?php

namespace Database\Seeders;

use App\Models\Keterangan;
use Illuminate\Database\Seeder;

class KeterangansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            
            ["id"=>"1","instruction_id"=>"2","form_id"=>"0","notes"=>"12"],
["id"=>"6","instruction_id"=>"3","form_id"=>"0","notes"=>"124"]

            
                    ];
            
                    foreach ($data as $keterangan) {
                        Keterangan::create($keterangan);
                    }
    }
}
