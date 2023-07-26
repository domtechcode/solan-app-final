<?php

namespace Database\Seeders;

use App\Models\Catatan;
use Illuminate\Database\Seeder;

class CatatansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["id"=>"1","user_id"=>"2","instruction_id"=>"1","catatan"=>"34","tujuan"=>"6","kategori"=>"catatan"],
            ["id"=>"2","user_id"=>"2","instruction_id"=>"1","catatan"=>"34","tujuan"=>"37","kategori"=>"catatan"],
            ["id"=>"3","user_id"=>"2","instruction_id"=>"2","catatan"=>"234234","tujuan"=>"5","kategori"=>"catatan"],
            ["id"=>"4","user_id"=>"2","instruction_id"=>"2","catatan"=>"234234","tujuan"=>"3","kategori"=>"catatan"],
            ["id"=>"9","user_id"=>"5","instruction_id"=>"3","catatan"=>"234234","tujuan"=>"4","kategori"=>"catatan"],
            ["id"=>"10","user_id"=>"5","instruction_id"=>"3","catatan"=>"234234","tujuan"=>"2","kategori"=>"catatan"],
            ["id"=>"11","user_id"=>"5","instruction_id"=>"3","catatan"=>"235235","tujuan"=>"5","kategori"=>"catatan"]
        ];

        foreach ($data as $catatan) {
            Catatan::create($catatan);
        }
    }
}
