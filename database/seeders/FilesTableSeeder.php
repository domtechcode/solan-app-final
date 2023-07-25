<?php

namespace Database\Seeders;

use App\Models\Files;
use Illuminate\Database\Seeder;

class FilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["id"=>"1","instruction_id"=>"1","user_id"=>"2","type_file"=>"contoh","file_name"=>"P-10001-file-contoh-1.png","file_path"=>"public/P-10001/follow-up"],
            ["id"=>"2","instruction_id"=>"1","user_id"=>"2","type_file"=>"arsip","file_name"=>"P-10001-file-arsip-1.png","file_path"=>"public/P-10001/follow-up"],
            ["id"=>"3","instruction_id"=>"2","user_id"=>"2","type_file"=>"contoh","file_name"=>"P-10002-file-contoh-1.png","file_path"=>"public/P-10002/follow-up"],
            ["id"=>"4","instruction_id"=>"2","user_id"=>"2","type_file"=>"arsip","file_name"=>"P-10002-file-arsip-1.jpg","file_path"=>"public/P-10002/follow-up"],
            ["id"=>"5","instruction_id"=>"2","user_id"=>"2","type_file"=>"accounting","file_name"=>"P-10002-file-arsip-accounting-1.jpg","file_path"=>"public/P-10002/follow-up"],
            ["id"=>"6","instruction_id"=>"3","user_id"=>"2","type_file"=>"contoh","file_name"=>"23-10154-file-contoh-1.png","file_path"=>"public/23-10154/follow-up"],
            ["id"=>"7","instruction_id"=>"3","user_id"=>"2","type_file"=>"arsip","file_name"=>"23-10154-file-arsip-1.jpg","file_path"=>"public/23-10154/follow-up"],
            ["id"=>"8","instruction_id"=>"3","user_id"=>"2","type_file"=>"accounting","file_name"=>"23-10154-file-arsip-accounting-1.png","file_path"=>"public/23-10154/follow-up"],
            ["id"=>"9","instruction_id"=>"3","user_id"=>"2","type_file"=>"accounting","file_name"=>"23-10154-file-arsip-accounting-2.png","file_path"=>"public/23-10154/follow-up"]

        ];

        foreach ($data as $file) {
            Files::create($file);
        }
    }
}
