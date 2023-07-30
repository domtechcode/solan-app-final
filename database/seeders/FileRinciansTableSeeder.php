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
            
            [ "id" => "1", "instruction_id" => "43", "keterangan_id" => "103", "file_name" => "SLN23-10552 DAN GABUNGAN OK-0.xlsx", "file_path" => "public/SLN23-10552/hitungbahan", ],
            [ "id" => "2", "instruction_id" => "133", "keterangan_id" => "110", "file_name" => "SLN-23-10581 OK-0.xlsx", "file_path" => "public/SLN23-10581/hitungbahan", ],
            [ "id" => "3", "instruction_id" => "187", "keterangan_id" => "116", "file_name" => "SLN-23-10592 DAN GABUNGAN OK-0.xlsx", "file_path" => "public/SLN23-10592/hitungbahan", ],
            [ "id" => "4", "instruction_id" => "223", "keterangan_id" => "138", "file_name" => "SLN23-10607 DAN GABUNGAN-0.xlsx", "file_path" => "public/SLN23-10607/hitungbahan", ],
            [ "id" => "5", "instruction_id" => "238", "keterangan_id" => "143", "file_name" => "SLN23-10611 OK BNGT-0.xlsx", "file_path" => "public/SLN23-10611/hitungbahan", ],
            [ "id" => "6", "instruction_id" => "248", "keterangan_id" => "152", "file_name" => "SLN23-10621 OK GABUNGAN-0.xlsx", "file_path" => "public/SLN23-10621/hitungbahan", ],
            [ "id" => "8", "instruction_id" => "285", "keterangan_id" => "159", "file_name" => "20230614-SLN23-10636-B-arsip-2-0.xlsx", "file_path" => "public/SLN23-10636-B/hitungbahan", ],
            [ "id" => "9", "instruction_id" => "303", "keterangan_id" => "173", "file_name" => "SLN23-10643 OK BNGTTT-0.xlsx", "file_path" => "public/SLN23-10643/hitungbahan", ],
            [ "id" => "10", "instruction_id" => "301", "keterangan_id" => "186", "file_name" => "SLN23-10642 OK-0.xlsx", "file_path" => "public/SLN23-10642/hitungbahan", ],
            [ "id" => "11", "instruction_id" => "313", "keterangan_id" => "199", "file_name" => "SLN23-10646 B DAN GABUNGAN OK-0.xlsx", "file_path" => "public/SLN23-10646-B/hitungbahan", ],
            [ "id" => "12", "instruction_id" => "426", "keterangan_id" => "244", "file_name" => "SLN-23-10675 DAN GABUNGAN OK-0.xlsx", "file_path" => "public/SLN23-10675/hitungbahan", ],
            [ "id" => "13", "instruction_id" => "459", "keterangan_id" => "278", "file_name" => "SLN23-10690 OK-0.xlsx", "file_path" => "public/SLN23-10690/hitungbahan", ],
            [ "id" => "14", "instruction_id" => "572", "keterangan_id" => "318", "file_name" => "SLN23-10549B GABUNGAN OK-0.xlsx", "file_path" => "public/SLN23-10549-B/hitungbahan", ],
            [ "id" => "15", "instruction_id" => "704", "keterangan_id" => "340", "file_name" => "SLN-23-10754 OK-0.xlsx", "file_path" => "public/SLN23-10754/hitungbahan", ],
            [ "id" => "16", "instruction_id" => "697", "keterangan_id" => "345", "file_name" => "SLN-23-10728C DANGABUNGAN OK-0.xlsx", "file_path" => "public/SLN23-10728-C/hitungbahan", ],
            [ "id" => "17", "instruction_id" => "605", "keterangan_id" => "349", "file_name" => "SLN-23-10726 DAN GABUNGAN OK-0.xlsx", "file_path" => "public/SLN23-10726/hitungbahan", ],
            [ "id" => "18", "instruction_id" => "824", "keterangan_id" => "393", "file_name" => "SLN-23-10794A DAN GABUNGAN-0.xlsx", "file_path" => "public/SLN23-10794-A/hitungbahan", ],
            [ "id" => "19", "instruction_id" => "601", "keterangan_id" => "420", "file_name" => "SLN-23-10723 DAN GABUNGAN OK-0.xlsx", "file_path" => "public/SLN23-10723/hitungbahan", ],
            [ "id" => "20", "instruction_id" => "964", "keterangan_id" => "458", "file_name" => "LABEL UPC STICKER - OCBS2400 OK.-0.xlsx", "file_path" => "public/SLN23-10862-A/hitungbahan", ],
            [ "id" => "21", "instruction_id" => "964", "keterangan_id" => "458", "file_name" => "LABEL UPC STICKER - OCHS2401 OKE...-0.xlsx", "file_path" => "public/SLN23-10862-A/hitungbahan", ],
            [ "id" => "22", "instruction_id" => "964", "keterangan_id" => "458", "file_name" => "LABEL UPC STICKER - OCHS3005 OK..-0.xlsx", "file_path" => "public/SLN23-10862-A/hitungbahan", ],
            [ "id" => "23", "instruction_id" => "964", "keterangan_id" => "458", "file_name" => "LABEL UPC STICKER - OPHB0004 OK-0.xlsx", "file_path" => "public/SLN23-10862-A/hitungbahan", ],
            [ "id" => "24", "instruction_id" => "965", "keterangan_id" => "460", "file_name" => "SLN-23-10862B OK-0.xlsx", "file_path" => "public/SLN23-10862-B/hitungbahan", ],
            [ "id" => "25", "instruction_id" => "982", "keterangan_id" => "474", "file_name" => "SLN-23-10869 DAN GABUNGAN OK-0.xlsx", "file_path" => "public/SLN23-10869/hitungbahan", ],
            [ "id" => "26", "instruction_id" => "957", "keterangan_id" => "491", "file_name" => "SLN23-10858 DAN GABUNGAN OK-0.xlsx", "file_path" => "public/SLN23-10858/hitungbahan", ],
            [ "id" => "27", "instruction_id" => "897", "keterangan_id" => "494", "file_name" => "SLN-23-10830B OK-0.xlsx", "file_path" => "public/SLN23-10830-B/hitungbahan", ],
            [ "id" => "28", "instruction_id" => "1130", "keterangan_id" => "530", "file_name" => "SLN23-10907 DAN GABUNGAN OK-0.xlsx", "file_path" => "public/SLN23-10907/hitungbahan", ],
            [ "id" => "29", "instruction_id" => "1151", "keterangan_id" => "538", "file_name" => "23-10271A OK-0.xlsx", "file_path" => "public/23-10271-A/hitungbahan", ],
            [ "id" => "30", "instruction_id" => "1152", "keterangan_id" => "541", "file_name" => "23-10271B OK BNGT..-0.xlsx", "file_path" => "public/23-10271-B/hitungbahan", ],
            [ "id" => "31", "instruction_id" => "1153", "keterangan_id" => "559", "file_name" => "SLN23-10916 OK BNGT-0.xlsx", "file_path" => "public/SLN23-10916/hitungbahan", ],
            [ "id" => "32", "instruction_id" => "1289", "keterangan_id" => "583", "file_name" => "SLN-23-10952A DAN GABUNGAN OK-0.xlsx", "file_path" => "public/SLN23-10952-A/hitungbahan", ],
            [ "id" => "33", "instruction_id" => "1154", "keterangan_id" => "585", "file_name" => "SLN-23-10917 DAN GABUNGAN-0.xlsx", "file_path" => "public/SLN23-10917/hitungbahan", ],
            [ "id" => "34", "instruction_id" => "1323", "keterangan_id" => "592", "file_name" => "23-10285 OK-0.xlsx", "file_path" => "public/23-10285/hitungbahan", ],
            [ "id" => "35", "instruction_id" => "1481", "keterangan_id" => "655", "file_name" => "SLN23-10992 OK-0.xlsx", "file_path" => "public/SLN23-10992/hitungbahan", ],
            [ "id" => "36", "instruction_id" => "1394", "keterangan_id" => "661", "file_name" => "SLN23-10965A DAN GABUNGAN OK-0.xlsx", "file_path" => "public/SLN23-10965-A/hitungbahan", ],
            [ "id" => "37", "instruction_id" => "1441", "keterangan_id" => "665", "file_name" => "23-10305(STK) DAN GABUNGAN OK-0.xlsx", "file_path" => "public/23-10305(STK)/hitungbahan", ],


        ];

        foreach ($data as $rincianfile) {
            FileRincian::create($rincianfile);
        }
    }
}
