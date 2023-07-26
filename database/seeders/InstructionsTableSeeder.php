<?php

namespace Database\Seeders;

use App\Models\Instruction;
use Illuminate\Database\Seeder;

class InstructionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["id"=>"1","spk_number"=>"P-10001","spk_type"=>"layout","taxes_type"=>"nonpajak","spk_state"=>"New","repeat_from"=>null,"request_kekurangan"=>null,"spk_parent"=>null,"sub_spk"=>null,"spk_fsc"=>null,"spk_number_fsc"=>null,"fsc_type"=>null,"order_date"=>"2023-07-25","shipping_date"=>"2023-07-27","customer_name"=>"PT. ADIMITRA ABADI MULIA","customer_number"=>null,"order_name"=>"2","code_style"=>null,"quantity"=>"0","stock"=>null,"follow_up"=>null,"spk_layout_number"=>null,"spk_sample_number"=>null,"price"=>"","group_id"=>null,"group_priority"=>null,"type_order"=>"layout","shipping_date_first"=>"2023-07-27","type_ppn"=>"","ppn"=>"0.112","count"=>null],
            ["id"=>"2","spk_number"=>"P-10002","spk_type"=>"sample","taxes_type"=>"nonpajak","spk_state"=>"New","repeat_from"=>null,"request_kekurangan"=>null,"spk_parent"=>null,"sub_spk"=>null,"spk_fsc"=>null,"spk_number_fsc"=>null,"fsc_type"=>null,"order_date"=>"2023-07-25","shipping_date"=>"2023-07-25","customer_name"=>"PT. ADIMITRA ABADI MULIA","customer_number"=>null,"order_name"=>"3","code_style"=>null,"quantity"=>"4","stock"=>null,"follow_up"=>null,"spk_layout_number"=>null,"spk_sample_number"=>null,"price"=>"","group_id"=>null,"group_priority"=>null,"type_order"=>"sample","shipping_date_first"=>"2023-07-25","type_ppn"=>null,"ppn"=>"0.112","count"=>null],
            ["id"=>"3","spk_number"=>"23-10154","spk_type"=>"production","taxes_type"=>"nonpajak","spk_state"=>"New","repeat_from"=>null,"request_kekurangan"=>null,"spk_parent"=>null,"sub_spk"=>null,"spk_fsc"=>null,"spk_number_fsc"=>null,"fsc_type"=>null,"order_date"=>"2023-07-25","shipping_date"=>"2023-07-27","customer_name"=>"PT. ADIMITRA ABADI MULIA","customer_number"=>null,"order_name"=>"4","code_style"=>null,"quantity"=>"35235","stock"=>null,"follow_up"=>null,"spk_layout_number"=>null,"spk_sample_number"=>null,"price"=>"235","group_id"=>null,"group_priority"=>null,"type_order"=>"production","shipping_date_first"=>"2023-07-27","type_ppn"=>"Include","ppn"=>"0.112","count"=>null]            
        ];
        foreach ($data as $instruction) {
            Instruction::create($instruction);
        }
    }
}
