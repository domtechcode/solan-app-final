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
            ["id"=>"1","desc_job"=>"Follow Up","prefix"=>"follow-up"],
            ["id"=>"2","desc_job"=>"Penjadwalan","prefix"=>"penjadwalan"],
            ["id"=>"3","desc_job"=>"Hitung Bahan","prefix"=>"hitung-bahan"],
            ["id"=>"4","desc_job"=>"RAB","prefix"=>"rab"],
            ["id"=>"5","desc_job"=>"Purchase","prefix"=>"purchase"],
            ["id"=>"6","desc_job"=>"Accounting","prefix"=>"accounting"],
            ["id"=>"7","desc_job"=>"Stock","prefix"=>"stock"],
            ["id"=>"8","desc_job"=>"Setting","prefix"=>"setting"],
            ["id"=>"9","desc_job"=>"Checker","prefix"=>"checker"],
            ["id"=>"10","desc_job"=>"Plate","prefix"=>"plate"],
            ["id"=>"11","desc_job"=>"Potong Bahan","prefix"=>"potong-bahan"],
            ["id"=>"12","desc_job"=>"Potong Jadi","prefix"=>"potong-jadi"],
            ["id"=>"13","desc_job"=>"Cetak","prefix"=>"cetak"],
            ["id"=>"14","desc_job"=>"Cetak Label","prefix"=>"cetak-label"],
            ["id"=>"15","desc_job"=>"Qc Cetak","prefix"=>"qc-cetak"],
            ["id"=>"16","desc_job"=>"Pond","prefix"=>"pond"],
            ["id"=>"17","desc_job"=>"Foil","prefix"=>"foil"],
            ["id"=>"18","desc_job"=>"Coating","prefix"=>"coating"],
            ["id"=>"19","desc_job"=>"Blok Lem","prefix"=>"blok-lem"],
            ["id"=>"20","desc_job"=>"Sablon","prefix"=>"sablon"],
            ["id"=>"21","desc_job"=>"Finishing","prefix"=>"finishing"],
            ["id"=>"22","desc_job"=>"Maklun","prefix"=>"maklun"],
            ["id"=>"23","desc_job"=>"Qc Packing","prefix"=>"qc-packing"],
            ["id"=>"24","desc_job"=>"Pengiriman","prefix"=>"pengiriman"],
            ["id"=>"25","desc_job"=>"Team Finishing","prefix"=>"team-finishing"],
            ["id"=>"26","desc_job"=>"Team Qc Packing","prefix"=>"team-qc-packing"],
        ];
        foreach ($data as $job) {
            Job::create($job);
        }
    }
}
