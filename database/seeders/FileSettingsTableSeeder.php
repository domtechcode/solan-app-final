<?php

namespace Database\Seeders;

use App\Models\FileSetting;
use Illuminate\Database\Seeder;

class FileSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            
            [ "id" => "55", "instruction_id" => "16", "keperluan" => "Spot UV", "ukuran_film" => "22cm x 17 cm", "jumlah_film" => "2", "file_path" => "public/P-10449/op-setting", "file_name" => "20230608-P-10449-film-spotuv-0.cdr", ],
[ "id" => "56", "instruction_id" => "16", "keperluan" => "Spot UV", "ukuran_film" => "22cm x 17 cm", "jumlah_film" => "2", "file_path" => "public/P-10449/op-setting", "file_name" => "20230608-P-10449-film-spotuv-1.cdr", ],
[ "id" => "71", "instruction_id" => "72", "keperluan" => "Label", "ukuran_film" => "14", "jumlah_film" => "14", "file_path" => "public/SLN23-10567/op-setting", "file_name" => "20230609-SLN23-10567-film-label-0.pdf", ],
[ "id" => "146", "instruction_id" => "124", "keperluan" => "Sablon", "ukuran_film" => "55cm x 27cm", "jumlah_film" => "1", "file_path" => "public/23-10163/op-setting", "file_name" => "20230613-23-10163-film-sablon-0.pdf", ],
[ "id" => "295", "instruction_id" => "364", "keperluan" => "Pisau", "ukuran_film" => "-", "jumlah_film" => "-", "file_path" => "public/SLN23-10543.GC1/op-setting", "file_name" => "20230621-SLN23-10543.GC1-film-pisau-0.png", ],
[ "id" => "301", "instruction_id" => "356", "keperluan" => "Pisau", "ukuran_film" => "19CM X 21CM", "jumlah_film" => "1", "file_path" => "public/SLN23-10657-D/op-setting", "file_name" => "20230621-SLN23-10657-D-film-pisau-0.cdr", ],
[ "id" => "306", "instruction_id" => "353", "keperluan" => "Pisau", "ukuran_film" => "20CM X 31CM", "jumlah_film" => "1", "file_path" => "public/SLN23-10657-A/op-setting", "file_name" => "20230621-SLN23-10657-A-film-pisau-0.cdr", ],
[ "id" => "366", "instruction_id" => "415", "keperluan" => "Label", "ukuran_film" => "7 x 19 CM", "jumlah_film" => "1", "file_path" => "public/SLN23-10673-A/op-setting", "file_name" => "20230622-SLN23-10673-A-film-label-1.pdf", ],
[ "id" => "373", "instruction_id" => "424", "keperluan" => "Pisau", "ukuran_film" => "12 x 25 CM", "jumlah_film" => "1", "file_path" => "public/SLN23-10674/op-setting", "file_name" => "20230623-SLN23-10674-film-pisau-0.pdf", ],
[ "id" => "380", "instruction_id" => "498", "keperluan" => "Pisau", "ukuran_film" => "31cm x 23cm", "jumlah_film" => "1", "file_path" => "public/SLN23-10698-A/op-setting", "file_name" => "20230623-SLN23-10698-A-film-pisau-0.cdr", ],
[ "id" => "387", "instruction_id" => "499", "keperluan" => "Pisau", "ukuran_film" => null, "jumlah_film" => null, "file_path" => "public/SLN23-10698-B/op-setting", "file_name" => "20230623-SLN23-10698-B-film-pisau-0.cdr", ],
[ "id" => "391", "instruction_id" => "468", "keperluan" => "Pisau", "ukuran_film" => "23cm x 12cm", "jumlah_film" => "1", "file_path" => "public/SLN23-10695-A/op-setting", "file_name" => "20230624-SLN23-10695-A-film-pisau-0.cdr", ],
[ "id" => "422", "instruction_id" => "426", "keperluan" => "Pisau", "ukuran_film" => null, "jumlah_film" => null, "file_path" => "public/SLN23-10675/op-setting", "file_name" => "20230626-SLN23-10675-film-pisau-0-revisi-1.cdr", ],
[ "id" => "522", "instruction_id" => "699", "keperluan" => "Spot UV", "ukuran_film" => "19cm x 12cm", "jumlah_film" => "1", "file_path" => "public/P-10710/op-setting", "file_name" => "20230630-P-10710-film-spotuv-0.cdr", ],
[ "id" => "523", "instruction_id" => "699", "keperluan" => "Spot UV", "ukuran_film" => "19cm x 12cm", "jumlah_film" => "1", "file_path" => "public/P-10710/op-setting", "file_name" => "20230630-P-10710-film-spotuv-1.cdr", ],
[ "id" => "640", "instruction_id" => "970", "keperluan" => "Pisau", "ukuran_film" => "-", "jumlah_film" => "-", "file_path" => "public/SLN23-10865/op-setting", "file_name" => "20230708-SLN23-10865-film-pisau-0.png", ],
[ "id" => "878", "instruction_id" => "1398", "keperluan" => "Pisau", "ukuran_film" => "-", "jumlah_film" => "-", "file_path" => "public/SLN23-10970-C/op-setting", "file_name" => "20230724-SLN23-10970-C-film-pisau-0.png", ],


        ];

        foreach ($data as $fileSetting) {
            FileSetting::create($fileSetting);
        }
    }
}
