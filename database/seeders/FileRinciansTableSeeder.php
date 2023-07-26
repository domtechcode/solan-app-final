<?php

namespace Database\Seeders;

use App\Models\FileRincian;
use Illuminate\Database\Seeder;

class FileRinciansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            
            ["id"=>"1","instruction_id"=>"2","keterangan_id"=>"1","file_name"=>"P-10002-file-rincian-1.xlsx","file_path"=>"public/P-10002/hitung-bahan"]



        ];

        foreach ($data as $rincianfile) {
            FileRincian::create($rincianfile);
        }
    }
}
