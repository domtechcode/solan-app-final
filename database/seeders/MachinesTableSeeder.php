<?php

namespace Database\Seeders;

use App\Models\Machine;
use Illuminate\Database\Seeder;

class MachinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["id"=>"1","machine_identity"=>"Mesin Plate A","type"=>"Mesin Plate"],
            ["id"=>"2","machine_identity"=>"Mesin 46","type"=>"Mesin Cetak"],
            ["id"=>"3","machine_identity"=>"Mesin 52 A","type"=>"Mesin Cetak"],
            ["id"=>"4","machine_identity"=>"Mesin 52 B","type"=>"Mesin Cetak"],
            ["id"=>"5","machine_identity"=>"Mesin 52 ALL COLOR","type"=>"Mesin Cetak"],
            ["id"=>"6","machine_identity"=>"Mesin 58 A (2 WARNA)","type"=>"Mesin Cetak"],
            ["id"=>"7","machine_identity"=>"Mesin 58 B (2 WARNA)","type"=>"Mesin Cetak"],
            ["id"=>"8","machine_identity"=>"Mesin 58 A (4 WARNA)","type"=>"Mesin Cetak"],
            ["id"=>"9","machine_identity"=>"Mesin Cetak Label","type"=>"Mesin Cetak Label"],
            ["id"=>"10","machine_identity"=>"Mesin Laminating Thermal A","type"=>"Mesin Cetak"],
            ["id"=>"11","machine_identity"=>"Mesin Laminating Waterbase A","type"=>"Mesin Cetak"],
            ["id"=>"12","machine_identity"=>"Mesin Vernish A","type"=>"Mesin Cetak"],
            ["id"=>"13","machine_identity"=>"Mesin Foil A","type"=>"Mesin Cetak"],
            ["id"=>"14","machine_identity"=>"Mesin Sablon A","type"=>"Mesin Cetak"],
            ["id"=>"15","machine_identity"=>"Mesin Pond A","type"=>"Mesin Cetak"],
            ["id"=>"16","machine_identity"=>"Mesin Pond B","type"=>"Mesin Cetak"],
            ["id"=>"17","machine_identity"=>"Mesin Pond C","type"=>"Mesin Cetak"],
            ["id"=>"18","machine_identity"=>"Mesin Pond D","type"=>"Mesin Cetak"],
            ["id"=>"19","machine_identity"=>"Mesin Pond E","type"=>"Mesin Cetak"],
            ["id"=>"20","machine_identity"=>"Mesin Lem A","type"=>"Mesin Cetak"],
            ["id"=>"21","machine_identity"=>"Mesin Mata Itik A","type"=>"Mesin Cetak"],
            ["id"=>"22","machine_identity"=>"Mesin Hot Cutting A","type"=>"Mesin Cetak"],
            ["id"=>"23","machine_identity"=>"Mesin Bor A","type"=>"Mesin Cetak"],
            ["id"=>"24","machine_identity"=>"Mesin Potong Jadi A","type"=>"Mesin Potong Jadi"],
            ["id"=>"25","machine_identity"=>"Mesin Potong Bahan A","type"=>"Mesin Potong Bahan"],
            ["id"=>"26","machine_identity"=>"Mesin Potong Jadi B","type"=>"Mesin Potong Jadi"],
            ["id"=>"27","machine_identity"=>"Mesin Plate Label","type"=>"Mesin Plate"]
        ];
        foreach ($data as $machine) {
            Machine::create($machine);
        }
    }
}
