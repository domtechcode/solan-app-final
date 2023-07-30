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

            
                    ];
            
                    foreach ($data as $keteranganscreen) {
                        KeteranganScreen::create($keteranganscreen);
                    }
    }
}
