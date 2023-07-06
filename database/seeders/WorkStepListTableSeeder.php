<?php

namespace Database\Seeders;

use App\Models\WorkStepList;
use Illuminate\Database\Seeder;

class WorkStepListTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["id"=>"1","name"=>"Follow Up"],
            ["id"=>"2","name"=>"Penjadwalan"],
            ["id"=>"3","name"=>"RAB"],
            ["id"=>"4","name"=>"Cari/Ambil Stock"],
            ["id"=>"5","name"=>"Hitung Bahan"],
            ["id"=>"6","name"=>"Setting"],
            ["id"=>"7","name"=>"Plate"],
            ["id"=>"8","name"=>"Potong Bahan"],
            ["id"=>"9","name"=>"Potong Jadi"],
            ["id"=>"10","name"=>"Cetak"],
            ["id"=>"11","name"=>"Qc Cetak"],
            ["id"=>"12","name"=>"Cetak Label"],
            ["id"=>"13","name"=>"Bor"],
            ["id"=>"14","name"=>"Tali"],
            ["id"=>"15","name"=>"Vernish Doff"],
            ["id"=>"16","name"=>"Vernish Gloss"],
            ["id"=>"17","name"=>"Laminating Doff"],
            ["id"=>"18","name"=>"Laminating Gloss"],
            ["id"=>"19","name"=>"Hot Cutting"],
            ["id"=>"20","name"=>"Hot Cutting Folding"],
            ["id"=>"21","name"=>"Lipat Perahu"],
            ["id"=>"22","name"=>"Lipat Kanan Kiri"],
            ["id"=>"23","name"=>"Sablon"],
            ["id"=>"24","name"=>"Pond"],
            ["id"=>"25","name"=>"Emboss"],
            ["id"=>"26","name"=>"Deboss"],
            ["id"=>"27","name"=>"Rail"],
            ["id"=>"28","name"=>"Foil"],
            ["id"=>"29","name"=>"Perforasi"],
            ["id"=>"30","name"=>"UV"],
            ["id"=>"31","name"=>"Spot UV"],
            ["id"=>"32","name"=>"Blok Lem"],
            ["id"=>"33","name"=>"Lem Lainnya"],
            ["id"=>"34","name"=>"Mata Itik + Pasang"],
            ["id"=>"35","name"=>"Qc Packing"],
            ["id"=>"36","name"=>"Pengiriman"],
            ["id"=>"37","name"=>"Checker"],
            ["id"=>"38","name"=>"Potong Sample"],
            ["id"=>"39","name"=>"Maklun"],
            ["id"=>"40","name"=>"Sortir Barang Keluar"],
            ["id"=>"41","name"=>"Sortir Barang Masuk"],
            ["id"=>"42","name"=>"Laminating Metalize"],
            ["id"=>"43","name"=>"Laminating Lubang"]
        ];

        foreach ($data as $worksteplist) {
            WorkStepList::create($worksteplist);
        }
    }
}
