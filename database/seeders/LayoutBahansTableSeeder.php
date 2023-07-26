<?php

namespace Database\Seeders;

use App\Models\LayoutBahan;
use Illuminate\Database\Seeder;

class LayoutBahansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            
            ["id"=>"1","user_id"=>"8","instruction_id"=>"2","jenis_pengeluaran"=>"Bahan Baku","rab"=>"5.061","real"=>null,"catatan"=>null,"count"=>null],
            ["id"=>"2","user_id"=>"8","instruction_id"=>"2","jenis_pengeluaran"=>"Plate","rab"=>"26","real"=>null,"catatan"=>null,"count"=>null],
            ["id"=>"3","user_id"=>"8","instruction_id"=>"2","jenis_pengeluaran"=>"Film","rab"=>"12.523","real"=>null,"catatan"=>null,"count"=>null],
            ["id"=>"4","user_id"=>"8","instruction_id"=>"2","jenis_pengeluaran"=>"UV/WB/Laminating","rab"=>"345","real"=>null,"catatan"=>null,"count"=>null],
            ["id"=>"5","user_id"=>"8","instruction_id"=>"2","jenis_pengeluaran"=>"Pisau Pon","rab"=>"345","real"=>null,"catatan"=>null,"count"=>null],
            ["id"=>"6","user_id"=>"8","instruction_id"=>"2","jenis_pengeluaran"=>"Jasa Maklun","rab"=>"345","real"=>null,"catatan"=>null,"count"=>null],
            ["id"=>"7","user_id"=>"8","instruction_id"=>"2","jenis_pengeluaran"=>"Biaya Pengiriman","rab"=>"346","real"=>null,"catatan"=>null,"count"=>null],
            ["id"=>"8","user_id"=>"8","instruction_id"=>"2","jenis_pengeluaran"=>"Biaya Lainnya","rab"=>"346","real"=>null,"catatan"=>null,"count"=>null],
            ["id"=>"9","user_id"=>"8","instruction_id"=>"3","jenis_pengeluaran"=>"Bahan Baku","rab"=>"119.716","real"=>null,"catatan"=>null,"count"=>null],
            ["id"=>"10","user_id"=>"8","instruction_id"=>"3","jenis_pengeluaran"=>"Plate","rab"=>"5690","real"=>null,"catatan"=>null,"count"=>null],
            ["id"=>"11","user_id"=>"8","instruction_id"=>"3","jenis_pengeluaran"=>"Film","rab"=>"2.3423","real"=>null,"catatan"=>null,"count"=>null],
            ["id"=>"12","user_id"=>"8","instruction_id"=>"3","jenis_pengeluaran"=>"UV/WB/Laminating","rab"=>"5.235","real"=>null,"catatan"=>null,"count"=>null],
            ["id"=>"13","user_id"=>"8","instruction_id"=>"3","jenis_pengeluaran"=>"Pisau Pon","rab"=>"235","real"=>null,"catatan"=>null,"count"=>null],
            ["id"=>"14","user_id"=>"8","instruction_id"=>"3","jenis_pengeluaran"=>"Mata Itik + Pasang","rab"=>"235","real"=>null,"catatan"=>null,"count"=>null],
            ["id"=>"15","user_id"=>"8","instruction_id"=>"3","jenis_pengeluaran"=>"Jasa Maklun","rab"=>"456","real"=>null,"catatan"=>null,"count"=>null],
            ["id"=>"16","user_id"=>"8","instruction_id"=>"3","jenis_pengeluaran"=>"Biaya Pengiriman","rab"=>"4564","real"=>null,"catatan"=>null,"count"=>null],
            ["id"=>"17","user_id"=>"8","instruction_id"=>"3","jenis_pengeluaran"=>"Biaya Lainnya","rab"=>"56","real"=>null,"catatan"=>null,"count"=>null]
            
                    ];
            
                    foreach ($data as $layoutbahan) {
                        LayoutBahan::create($layoutbahan);
                    }
    }
}
