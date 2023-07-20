<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["id"=>"1","desc_job"=>"Follow Up"],
            ["id"=>"2","desc_job"=>"Penjadwalan"],
            ["id"=>"3","desc_job"=>"RAB"],
            ["id"=>"4","desc_job"=>"Cari/Ambil Stock"],
            ["id"=>"5","desc_job"=>"Hitung Bahan"],
            ["id"=>"6","desc_job"=>"Setting"],
            ["id"=>"7","desc_job"=>"Plate"],
            ["id"=>"8","desc_job"=>"Potong Bahan"],
            ["id"=>"9","desc_job"=>"Potong Jadi"],
            ["id"=>"10","desc_job"=>"Cetak"],
            ["id"=>"11","desc_job"=>"Qc Cetak"],
            ["id"=>"12","desc_job"=>"Cetak Label"],
            ["id"=>"13","desc_job"=>"Bor"],
            ["id"=>"14","desc_job"=>"Tali"],
            ["id"=>"15","desc_job"=>"Vernish Doff"],
            ["id"=>"16","desc_job"=>"Vernish Gloss"],
            ["id"=>"17","desc_job"=>"Laminating Doff"],
            ["id"=>"18","desc_job"=>"Laminating Gloss"],
            ["id"=>"19","desc_job"=>"Hot Cutting"],
            ["id"=>"20","desc_job"=>"Hot Cutting Folding"],
            ["id"=>"21","desc_job"=>"Lipat Perahu"],
            ["id"=>"22","desc_job"=>"Lipat Kanan Kiri"],
            ["id"=>"23","desc_job"=>"Sablon"],
            ["id"=>"24","desc_job"=>"Pond"],
            ["id"=>"25","desc_job"=>"Emboss"],
            ["id"=>"26","desc_job"=>"Deboss"],
            ["id"=>"27","desc_job"=>"Rail"],
            ["id"=>"28","desc_job"=>"Foil"],
            ["id"=>"29","desc_job"=>"Perforasi"],
            ["id"=>"30","desc_job"=>"UV"],
            ["id"=>"31","desc_job"=>"Spot UV"],
            ["id"=>"32","desc_job"=>"Blok Lem"],
            ["id"=>"33","desc_job"=>"Lem Lainnya"],
            ["id"=>"34","desc_job"=>"Mata Itik + Pasang"],
            ["id"=>"35","desc_job"=>"Qc Packing"],
            ["id"=>"36","desc_job"=>"Pengiriman"],
            ["id"=>"37","desc_job"=>"Checker"],
            ["id"=>"38","desc_job"=>"Potong Sample"],
            ["id"=>"39","desc_job"=>"Maklun"],
            ["id"=>"40","desc_job"=>"Sortir Barang Keluar"],
            ["id"=>"41","desc_job"=>"Sortir Barang Masuk"],
            ["id"=>"42","desc_job"=>"Laminating Metalize"],
            ["id"=>"43","desc_job"=>"Laminating Lubang"]
        ];
        foreach ($data as $job) {
            Job::create($job);
        }
    }
}
