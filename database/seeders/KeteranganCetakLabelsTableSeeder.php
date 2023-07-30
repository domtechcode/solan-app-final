<?php

namespace Database\Seeders;

use App\Models\FormCetakLabel;
use App\Models\KeteranganLabel;
use Illuminate\Database\Seeder;

class KeteranganCetakLabelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ "id" => "9", "instruction_id" => "72", "keterangan_id" => "710", "alat_bahan" => "Cylinder", "jenis_ukuran" => "52", "jumlah" => "2", "ketersediaan" => "ada", "catatan_label" => "ukuran cylinder 13", ],
[ "id" => "10", "instruction_id" => "72", "keterangan_id" => "710", "alat_bahan" => "Pita", "jenis_ukuran" => "Tapeta Putih 3.5cm", "jumlah" => "6", "ketersediaan" => "ada", "catatan_label" => "stock ada 13", ],
[ "id" => "11", "instruction_id" => "72", "keterangan_id" => "710", "alat_bahan" => "Tinta", "jenis_ukuran" => "Hitam", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "12", "instruction_id" => "72", "keterangan_id" => "710", "alat_bahan" => "Plate", "jenis_ukuran" => "0", "jumlah" => "3", "ketersediaan" => "tidak", "catatan_label" => null, ],
[ "id" => "13", "instruction_id" => "173", "keterangan_id" => "711", "alat_bahan" => "Cylinder", "jenis_ukuran" => "71", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "14", "instruction_id" => "173", "keterangan_id" => "711", "alat_bahan" => "Pita", "jenis_ukuran" => "3.2", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => "pemesanan estimasi 3 hari di DBS", ],
[ "id" => "15", "instruction_id" => "173", "keterangan_id" => "711", "alat_bahan" => "Tinta", "jenis_ukuran" => "hitam", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "16", "instruction_id" => "173", "keterangan_id" => "711", "alat_bahan" => "Plate", "jenis_ukuran" => "1", "jumlah" => null, "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "17", "instruction_id" => "255", "keterangan_id" => "712", "alat_bahan" => "Cylinder", "jenis_ukuran" => "71", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "18", "instruction_id" => "255", "keterangan_id" => "712", "alat_bahan" => "Pita", "jenis_ukuran" => "satin putih double face", "jumlah" => "2", "ketersediaan" => "tidak", "catatan_label" => "estimasi bahan 16/6/23", ],
[ "id" => "19", "instruction_id" => "255", "keterangan_id" => "712", "alat_bahan" => "Tinta", "jenis_ukuran" => "hitam", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "20", "instruction_id" => "255", "keterangan_id" => "712", "alat_bahan" => "Plate", "jenis_ukuran" => "baru", "jumlah" => null, "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "21", "instruction_id" => "276", "keterangan_id" => "713", "alat_bahan" => "Cylinder", "jenis_ukuran" => "52", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "22", "instruction_id" => "276", "keterangan_id" => "713", "alat_bahan" => "Pita", "jenis_ukuran" => "tafeta putih 3.5cm", "jumlah" => "4 roll", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "23", "instruction_id" => "276", "keterangan_id" => "713", "alat_bahan" => "Tinta", "jenis_ukuran" => "hitam", "jumlah" => null, "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "24", "instruction_id" => "276", "keterangan_id" => "713", "alat_bahan" => "Plate", "jenis_ukuran" => null, "jumlah" => null, "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "25", "instruction_id" => "381", "keterangan_id" => "714", "alat_bahan" => "Cylinder", "jenis_ukuran" => "80", "jumlah" => "2", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "26", "instruction_id" => "381", "keterangan_id" => "714", "alat_bahan" => "Pita", "jenis_ukuran" => "tafeta putih 3cm", "jumlah" => "1 roll", "ketersediaan" => "tidak", "catatan_label" => "estimasi bahan 22/06/2023", ],
[ "id" => "27", "instruction_id" => "381", "keterangan_id" => "714", "alat_bahan" => "Tinta", "jenis_ukuran" => "hitam", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "28", "instruction_id" => "381", "keterangan_id" => "714", "alat_bahan" => "Plate", "jenis_ukuran" => null, "jumlah" => null, "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "29", "instruction_id" => "305", "keterangan_id" => "715", "alat_bahan" => "Cylinder", "jenis_ukuran" => "44", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "30", "instruction_id" => "305", "keterangan_id" => "715", "alat_bahan" => "Pita", "jenis_ukuran" => "satin putih 1.2 cm", "jumlah" => "19 roll", "ketersediaan" => "tidak", "catatan_label" => "Indomas 22/06/2023", ],
[ "id" => "31", "instruction_id" => "305", "keterangan_id" => "715", "alat_bahan" => "Tinta", "jenis_ukuran" => "hitam", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "32", "instruction_id" => "305", "keterangan_id" => "715", "alat_bahan" => "Plate", "jenis_ukuran" => null, "jumlah" => null, "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "33", "instruction_id" => "392", "keterangan_id" => "716", "alat_bahan" => "Cylinder", "jenis_ukuran" => "80", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "34", "instruction_id" => "392", "keterangan_id" => "716", "alat_bahan" => "Pita", "jenis_ukuran" => "tafeta putih 2.5cm", "jumlah" => "1/2 roll", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "35", "instruction_id" => "392", "keterangan_id" => "716", "alat_bahan" => "Tinta", "jenis_ukuran" => "hitam", "jumlah" => null, "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "36", "instruction_id" => "392", "keterangan_id" => "716", "alat_bahan" => "Plate", "jenis_ukuran" => null, "jumlah" => null, "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "37", "instruction_id" => "391", "keterangan_id" => "717", "alat_bahan" => "Cylinder", "jenis_ukuran" => "71", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "38", "instruction_id" => "391", "keterangan_id" => "717", "alat_bahan" => "Pita", "jenis_ukuran" => "satin putih 3.8 cm", "jumlah" => "1/2 roll", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "39", "instruction_id" => "391", "keterangan_id" => "717", "alat_bahan" => "Tinta", "jenis_ukuran" => "hitam", "jumlah" => null, "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "40", "instruction_id" => "391", "keterangan_id" => "717", "alat_bahan" => "Plate", "jenis_ukuran" => null, "jumlah" => null, "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "41", "instruction_id" => "415", "keterangan_id" => "718", "alat_bahan" => "Cylinder", "jenis_ukuran" => "56", "jumlah" => "4", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "42", "instruction_id" => "415", "keterangan_id" => "718", "alat_bahan" => "Pita", "jenis_ukuran" => "TAFETA PUTIH UK 1.9 cm", "jumlah" => "4 ROLL", "ketersediaan" => "tidak", "catatan_label" => "Pt Indomas estimasi 23/06/2023", ],
[ "id" => "43", "instruction_id" => "415", "keterangan_id" => "718", "alat_bahan" => "Tinta", "jenis_ukuran" => "hitam", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "44", "instruction_id" => "415", "keterangan_id" => "718", "alat_bahan" => "Plate", "jenis_ukuran" => null, "jumlah" => null, "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "45", "instruction_id" => "434", "keterangan_id" => "719", "alat_bahan" => "Cylinder", "jenis_ukuran" => "71", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "46", "instruction_id" => "434", "keterangan_id" => "719", "alat_bahan" => "Pita", "jenis_ukuran" => "TAFETA PUTIH 1 CM", "jumlah" => "1/2 ROLL", "ketersediaan" => "tidak", "catatan_label" => null, ],
[ "id" => "47", "instruction_id" => "434", "keterangan_id" => "719", "alat_bahan" => "Tinta", "jenis_ukuran" => "HITAM", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "48", "instruction_id" => "434", "keterangan_id" => "719", "alat_bahan" => "Plate", "jenis_ukuran" => null, "jumlah" => null, "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "49", "instruction_id" => "435", "keterangan_id" => "720", "alat_bahan" => "Cylinder", "jenis_ukuran" => "64", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "50", "instruction_id" => "435", "keterangan_id" => "720", "alat_bahan" => "Pita", "jenis_ukuran" => "TAFETA PUTIH 1 CM", "jumlah" => "1/2 ROLL", "ketersediaan" => "tidak", "catatan_label" => null, ],
[ "id" => "51", "instruction_id" => "435", "keterangan_id" => "720", "alat_bahan" => "Tinta", "jenis_ukuran" => "HITAM", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "52", "instruction_id" => "435", "keterangan_id" => "720", "alat_bahan" => "Plate", "jenis_ukuran" => null, "jumlah" => null, "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "53", "instruction_id" => "436", "keterangan_id" => "721", "alat_bahan" => "Cylinder", "jenis_ukuran" => "64", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "54", "instruction_id" => "436", "keterangan_id" => "721", "alat_bahan" => "Pita", "jenis_ukuran" => "TAFETA PUTIH 1 CM", "jumlah" => "1/2 ROLL", "ketersediaan" => "tidak", "catatan_label" => null, ],
[ "id" => "55", "instruction_id" => "436", "keterangan_id" => "721", "alat_bahan" => "Tinta", "jenis_ukuran" => "HITAM", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "56", "instruction_id" => "436", "keterangan_id" => "721", "alat_bahan" => "Plate", "jenis_ukuran" => null, "jumlah" => null, "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "57", "instruction_id" => "607", "keterangan_id" => "722", "alat_bahan" => "Cylinder", "jenis_ukuran" => "71", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "58", "instruction_id" => "607", "keterangan_id" => "722", "alat_bahan" => "Pita", "jenis_ukuran" => "satin putih 3.8cm", "jumlah" => "1/2 roll", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "59", "instruction_id" => "607", "keterangan_id" => "722", "alat_bahan" => "Tinta", "jenis_ukuran" => "hitam", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "60", "instruction_id" => "607", "keterangan_id" => "722", "alat_bahan" => "Plate", "jenis_ukuran" => null, "jumlah" => null, "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "65", "instruction_id" => "831", "keterangan_id" => "723", "alat_bahan" => "Cylinder", "jenis_ukuran" => "64", "jumlah" => "3", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "66", "instruction_id" => "831", "keterangan_id" => "723", "alat_bahan" => "Pita", "jenis_ukuran" => "KATUN KREM 2.5 CM", "jumlah" => "78 ROLL", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "67", "instruction_id" => "831", "keterangan_id" => "723", "alat_bahan" => "Tinta", "jenis_ukuran" => "COKLAT", "jumlah" => "-", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "68", "instruction_id" => "831", "keterangan_id" => "723", "alat_bahan" => "Plate", "jenis_ukuran" => "-", "jumlah" => "-", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "69", "instruction_id" => "829", "keterangan_id" => "724", "alat_bahan" => "Cylinder", "jenis_ukuran" => "64", "jumlah" => "3", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "70", "instruction_id" => "829", "keterangan_id" => "724", "alat_bahan" => "Pita", "jenis_ukuran" => "PITA KATUN KREM 2.5 CM", "jumlah" => "78 ROLL", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "71", "instruction_id" => "829", "keterangan_id" => "724", "alat_bahan" => "Tinta", "jenis_ukuran" => "COKLAT", "jumlah" => "-", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "72", "instruction_id" => "829", "keterangan_id" => "724", "alat_bahan" => "Plate", "jenis_ukuran" => "-", "jumlah" => "-", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "73", "instruction_id" => "988", "keterangan_id" => "725", "alat_bahan" => "Cylinder", "jenis_ukuran" => "44", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "74", "instruction_id" => "988", "keterangan_id" => "725", "alat_bahan" => "Pita", "jenis_ukuran" => "SATIN PUTIH 2.5 CM", "jumlah" => "1/2 roll", "ketersediaan" => "tidak", "catatan_label" => "INDOMAS", ],
[ "id" => "75", "instruction_id" => "988", "keterangan_id" => "725", "alat_bahan" => "Tinta", "jenis_ukuran" => "HITAM", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "76", "instruction_id" => "988", "keterangan_id" => "725", "alat_bahan" => "Plate", "jenis_ukuran" => null, "jumlah" => null, "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "77", "instruction_id" => "992", "keterangan_id" => "726", "alat_bahan" => "Cylinder", "jenis_ukuran" => "64", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "78", "instruction_id" => "992", "keterangan_id" => "726", "alat_bahan" => "Pita", "jenis_ukuran" => "SATIN PUTIH 3 CM", "jumlah" => "1/2 ROLL", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "79", "instruction_id" => "992", "keterangan_id" => "726", "alat_bahan" => "Tinta", "jenis_ukuran" => "HITAM", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "80", "instruction_id" => "992", "keterangan_id" => "726", "alat_bahan" => "Plate", "jenis_ukuran" => null, "jumlah" => null, "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "81", "instruction_id" => "1430", "keterangan_id" => "727", "alat_bahan" => "Cylinder", "jenis_ukuran" => "44", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "82", "instruction_id" => "1430", "keterangan_id" => "727", "alat_bahan" => "Pita", "jenis_ukuran" => "satin putih 1.2cm", "jumlah" => "1/2 roll", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "83", "instruction_id" => "1430", "keterangan_id" => "727", "alat_bahan" => "Tinta", "jenis_ukuran" => "hitam", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "84", "instruction_id" => "1430", "keterangan_id" => "727", "alat_bahan" => "Plate", "jenis_ukuran" => null, "jumlah" => null, "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "85", "instruction_id" => "1474", "keterangan_id" => "728", "alat_bahan" => "Cylinder", "jenis_ukuran" => "56", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "86", "instruction_id" => "1474", "keterangan_id" => "728", "alat_bahan" => "Pita", "jenis_ukuran" => "SATIN PUTIH DOUBLE FACE 2 CM", "jumlah" => "1/2 ROLL", "ketersediaan" => "tidak", "catatan_label" => null, ],
[ "id" => "87", "instruction_id" => "1474", "keterangan_id" => "728", "alat_bahan" => "Tinta", "jenis_ukuran" => "MERAH", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "88", "instruction_id" => "1474", "keterangan_id" => "728", "alat_bahan" => "Plate", "jenis_ukuran" => "0", "jumlah" => "0", "ketersediaan" => "ada", "catatan_label" => null, ],
[ "id" => "89", "instruction_id" => "1568", "keterangan_id" => "729", "alat_bahan" => "Cylinder", "jenis_ukuran" => "52", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => "0", ],
[ "id" => "90", "instruction_id" => "1568", "keterangan_id" => "729", "alat_bahan" => "Pita", "jenis_ukuran" => "SATIN PUTIH 1.9 CM", "jumlah" => "3 ROLL", "ketersediaan" => "tidak", "catatan_label" => "INDOMAS", ],
[ "id" => "91", "instruction_id" => "1568", "keterangan_id" => "729", "alat_bahan" => "Tinta", "jenis_ukuran" => "HITAM", "jumlah" => "0", "ketersediaan" => "ada", "catatan_label" => "0", ],
[ "id" => "92", "instruction_id" => "1568", "keterangan_id" => "729", "alat_bahan" => "Plate", "jenis_ukuran" => "0", "jumlah" => "0", "ketersediaan" => "ada", "catatan_label" => "0", ],
[ "id" => "93", "instruction_id" => "1569", "keterangan_id" => "730", "alat_bahan" => "Cylinder", "jenis_ukuran" => "52", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => "0", ],
[ "id" => "94", "instruction_id" => "1569", "keterangan_id" => "730", "alat_bahan" => "Pita", "jenis_ukuran" => "SATIN PUTIH 1.9 CM", "jumlah" => "1 ROLL", "ketersediaan" => "tidak", "catatan_label" => "INDOMAS", ],
[ "id" => "95", "instruction_id" => "1569", "keterangan_id" => "730", "alat_bahan" => "Tinta", "jenis_ukuran" => "HITAM", "jumlah" => "1", "ketersediaan" => "ada", "catatan_label" => "0", ],
[ "id" => "96", "instruction_id" => "1569", "keterangan_id" => "730", "alat_bahan" => "Plate", "jenis_ukuran" => "0", "jumlah" => "0", "ketersediaan" => "ada", "catatan_label" => "0", ],


            
                    ];
            
                    foreach ($data as $keteranganCetakLabel) {
                        KeteranganLabel::create($keteranganCetakLabel);
                    }
    }
}
