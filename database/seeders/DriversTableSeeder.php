<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Seeder;

class DriversTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'P. Wijaya'],
            ['name' => 'Sisman'],
            ['name' => 'Warsito'],
            ['name' => 'Adam Hidayat'],
            ['name' => 'Wahyu Ferdiansyah'],
            ['name' => 'Ucep Setiana'],
            ['name' => 'Miftah Firmansyah'],
        ];

        foreach ($data as $driver) {
            Driver::create($driver);
        }
    }
}
