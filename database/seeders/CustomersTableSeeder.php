<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ "id" => "1", "name" => "LEE COOPER", "taxes" => "nonpajak", ],
[ "id" => "2", "name" => "TOKO PLASTIK ADIT", "taxes" => "nonpajak", ],
[ "id" => "3", "name" => "WARUNG NASI BEBEK SINJAYA", "taxes" => "nonpajak", ],
[ "id" => "4", "name" => "PT. FOREVER GARMINDO", "taxes" => "pajak", ],
[ "id" => "5", "name" => "CV. HARAPAN BARU", "taxes" => "pajak", ],
[ "id" => "6", "name" => "PT. KAHATEX - GARMENT Div", "taxes" => "nonpajak", ],
[ "id" => "7", "name" => "PT. KAHATEX - Sock Div", "taxes" => "pajak", ],
[ "id" => "8", "name" => "PT. LEADING GARMENT INDUSTRIES", "taxes" => "pajak", ],
[ "id" => "9", "name" => "PT. MICRO GARMENT", "taxes" => "pajak", ],
[ "id" => "10", "name" => "TOKO PLASTIK LIMPAH JAYA INDAH", "taxes" => "nonpajak", ],
[ "id" => "11", "name" => "PT. MSJ-DW", "taxes" => "pajak", ],
[ "id" => "12", "name" => "PT. MSJ-SOCK", "taxes" => "pajak", ],
[ "id" => "13", "name" => "PT. TRIMAS SARANA GARMENT INDUSTRY", "taxes" => "pajak", ],
[ "id" => "14", "name" => "PT. PERUSAHAAN INDUSTRI CERES", "taxes" => "nonpajak", ],
[ "id" => "15", "name" => "PT. LANGGENG SENTOSA GARMINDO", "taxes" => "nonpajak", ],
[ "id" => "16", "name" => "AYAM GEPREK D\'FINE", "taxes" => "nonpajak", ],
[ "id" => "17", "name" => "PT. GOLDEN FLOWER", "taxes" => "pajak", ],
[ "id" => "18", "name" => "BAKMI KOSWARA", "taxes" => "nonpajak", ],
[ "id" => "19", "name" => "PT. TEODORE PAN GARMINDO", "taxes" => "pajak", ],
[ "id" => "20", "name" => "PT. TASINDO TASSA INDUSTRIES", "taxes" => "pajak", ],
[ "id" => "21", "name" => "PT. ADIRA SEMESTA INDUSTRY", "taxes" => "nonpajak", ],
[ "id" => "22", "name" => "PT. MSJ SWEATER", "taxes" => "pajak", ],
[ "id" => "23", "name" => "PT. SINAR LEGIT ABADI (MARTABAK LEGIT GROUP)", "taxes" => "nonpajak", ],
[ "id" => "24", "name" => "PT. OPELON GARMENT INDONESIA", "taxes" => "pajak", ],
[ "id" => "25", "name" => "PT. TASINDO MANDIRI INDONESIA", "taxes" => "pajak", ],
[ "id" => "26", "name" => "ABACUS", "taxes" => "nonpajak", ],
[ "id" => "27", "name" => "PT. BINTANG MULIA PRIMA", "taxes" => "nonpajak", ],
[ "id" => "28", "name" => "TOKO PLASTIK HIJRAH", "taxes" => "nonpajak", ],
[ "id" => "29", "name" => "PT. MONDAVE INTERNATIONAL", "taxes" => "nonpajak", ],
[ "id" => "30", "name" => "PT. POLYFILATEX", "taxes" => "pajak", ],
[ "id" => "31", "name" => "PT. KRIDA ALAM LESTARI", "taxes" => "pajak", ],
[ "id" => "32", "name" => "PT. EMJI JAYA LESTARI", "taxes" => "nonpajak", ],
[ "id" => "33", "name" => "KHARISMA MITRA SELARAS (KMS)", "taxes" => "nonpajak", ],
[ "id" => "34", "name" => "LIZZIE", "taxes" => "nonpajak", ],
[ "id" => "35", "name" => "RUMAH MAKAN GUMILANG", "taxes" => "nonpajak", ],
[ "id" => "36", "name" => "CAPITAL 8", "taxes" => "nonpajak", ],
[ "id" => "37", "name" => "PT. HINI DAIKI INDONESIA", "taxes" => "pajak", ],
[ "id" => "38", "name" => "PT. MULTI GARMENJAYA", "taxes" => "pajak", ],
[ "id" => "39", "name" => "CV. MARCELINDO", "taxes" => "nonpajak", ],
[ "id" => "40", "name" => "PT. SEANTERO GUMILANG LESTARI", "taxes" => "pajak", ],
[ "id" => "41", "name" => "Makloon Cetak", "taxes" => "nonpajak", ],
[ "id" => "42", "name" => "HINDRA JAYA", "taxes" => "nonpajak", ],
[ "id" => "43", "name" => "PT. STICKO", "taxes" => "nonpajak", ],
[ "id" => "44", "name" => "CV. PENTA", "taxes" => "nonpajak", ],
[ "id" => "45", "name" => "CV. GAYA JAYA", "taxes" => "nonpajak", ],
[ "id" => "46", "name" => "PT. GREAT STAR GLOBALINDO", "taxes" => "pajak", ],
[ "id" => "47", "name" => "PT. MAREL SUKSES PRATAMA ", "taxes" => "pajak", ],
[ "id" => "48", "name" => "Ramesindong", "taxes" => "nonpajak", ],
[ "id" => "49", "name" => "PT. FOTEXCO BUSANA INTERNATIONAL ", "taxes" => "pajak", ],
[ "id" => "50", "name" => "PT. SEJIN GLOBAL INDONESIA ", "taxes" => "nonpajak", ],
[ "id" => "51", "name" => "IBU IKA (OWNER MIRAE)", "taxes" => "nonpajak", ],
[ "id" => "52", "name" => "FUJIFILM INDONESIA PT", "taxes" => "nonpajak", ],
[ "id" => "53", "name" => "BLESS FASHION", "taxes" => "nonpajak", ],
[ "id" => "54", "name" => "KODAI PLASTIK", "taxes" => "nonpajak", ],
[ "id" => "55", "name" => "PT. MULTI GARMENTAMA", "taxes" => "pajak", ],
[ "id" => "56", "name" => "PT. MITRA GLOBAL UTAMA ", "taxes" => "pajak", ],
[ "id" => "57", "name" => "CV. SUHO GARMINDO", "taxes" => "pajak", ],
[ "id" => "58", "name" => "PT. KAHATEX MAJALAYA", "taxes" => "pajak", ],
[ "id" => "59", "name" => "PT. BIGTHA TRYPHENA GARMENT", "taxes" => "pajak", ],
[ "id" => "60", "name" => "PT. SHAFIRA APPAREL INDONESIA", "taxes" => "nonpajak", ],
[ "id" => "61", "name" => "PT. EKSONINDO MULTI PRODUCT INDUSTRY", "taxes" => "pajak", ],
[ "id" => "62", "name" => "SAUNG LEGIT", "taxes" => "nonpajak", ],
[ "id" => "63", "name" => "CV. WANGSA BUSANA", "taxes" => "pajak", ],
[ "id" => "64", "name" => "PT. RAIZINDO BERKAT ABADI", "taxes" => "nonpajak", ],
[ "id" => "65", "name" => "PT. TRISULA GARMINDO", "taxes" => "nonpajak", ],
[ "id" => "66", "name" => "BEHOLDER CLOTHING", "taxes" => "nonpajak", ],
[ "id" => "67", "name" => "SANDANG MAKMUR SEJATI TRITAMA PT", "taxes" => "nonpajak", ],
[ "id" => "68", "name" => "FASHION PASTA", "taxes" => "nonpajak", ],
[ "id" => "69", "name" => "TRONINDO ANUGRAH JAYA, PT.", "taxes" => "pajak", ],
[ "id" => "70", "name" => "CIPTAGRIA MUTIARA BUSANA PT.", "taxes" => "nonpajak", ],
[ "id" => "71", "name" => "GREAT THIOFILUS PT.", "taxes" => "nonpajak", ],
[ "id" => "72", "name" => "BUSANA CEMERLANG PT", "taxes" => "nonpajak", ],
[ "id" => "73", "name" => "WON BUTTON PT.", "taxes" => "nonpajak", ],
[ "id" => "74", "name" => "TRIBINA USAHA MANDIRI CV.", "taxes" => "nonpajak", ],
[ "id" => "75", "name" => "UNIVERSAL KHARISMA GARMENT PT.", "taxes" => "pajak", ],
[ "id" => "76", "name" => "RUMAH MAKAN MIRASA", "taxes" => "nonpajak", ],
[ "id" => "77", "name" => "ARTHA RETAILINDO PERKASA PT.", "taxes" => "nonpajak", ],
[ "id" => "78", "name" => "PICARINJAYA ABADI PT", "taxes" => "pajak", ],
[ "id" => "79", "name" => "SH GARMENT PT", "taxes" => "nonpajak", ],
[ "id" => "80", "name" => "SEMARANG GARMENT PT.", "taxes" => "pajak", ],
[ "id" => "81", "name" => "DADA INDONESIA PT.", "taxes" => "nonpajak", ],
[ "id" => "82", "name" => "SAI GARMENTS INDUSTRIES", "taxes" => "pajak", ],
[ "id" => "83", "name" => "SULLY ABADI JAYA PT.", "taxes" => "nonpajak", ],
[ "id" => "84", "name" => "PT. TASTEX", "taxes" => "nonpajak", ],
[ "id" => "85", "name" => "DELAMI GARMENT INDUSTRIES PT", "taxes" => "nonpajak", ],
[ "id" => "86", "name" => "MODE GLOBAL UTAMA", "taxes" => "nonpajak", ],
[ "id" => "87", "name" => "PT. AMBASADOR", "taxes" => "pajak", ],
[ "id" => "88", "name" => "KAYBEE JAKARTA PT", "taxes" => "nonpajak", ],
[ "id" => "89", "name" => "PT. NIRWANA ALABARE GARMENT", "taxes" => "pajak", ],
[ "id" => "90", "name" => "PT. HOLLIT INTERNATIONAL", "taxes" => "pajak", ],
[ "id" => "91", "name" => "AYAM GORENG SUHARTI", "taxes" => "nonpajak", ],
[ "id" => "92", "name" => "WINTAI GARMENT PT.", "taxes" => "pajak", ],
[ "id" => "93", "name" => "PT. KAHATEX RANCAEKEK", "taxes" => "pajak", ],
[ "id" => "94", "name" => "RUMAH MAKAN PONYO", "taxes" => "nonpajak", ],
[ "id" => "95", "name" => "ANUGERAH MITRA MULIA PT.", "taxes" => "pajak", ],
[ "id" => "96", "name" => "VINAASTEE INTERNATIONAL PT", "taxes" => "pajak", ],
[ "id" => "97", "name" => "Rumah Makan Sunda SUKAHATI Cinunuk", "taxes" => "nonpajak", ],
[ "id" => "98", "name" => "TOKO PLASTIK TERANG", "taxes" => "nonpajak", ],
[ "id" => "99", "name" => "SUKSES MAJU SEJAHTERA CV.", "taxes" => "nonpajak", ],
[ "id" => "100", "name" => "TOKO PLASTIK DARMAN LARIS", "taxes" => "nonpajak", ],
[ "id" => "101", "name" => "DAN LIRIS PT.", "taxes" => "pajak", ],
[ "id" => "102", "name" => "SURYA MULTI LAKSANA PT", "taxes" => "nonpajak", ],
[ "id" => "103", "name" => "PT. BATEEQ RETAILINDO UTAMA", "taxes" => "pajak", ],
[ "id" => "104", "name" => "LIZA CRISTINA PT", "taxes" => "nonpajak", ],
[ "id" => "105", "name" => "KREASI CIPTA DWIMANUNGGAL PT.", "taxes" => "pajak", ],
[ "id" => "106", "name" => "PT. TABOR ANDALAN RETAILINDO", "taxes" => "pajak", ],
[ "id" => "107", "name" => "SARI WARNA ASLI TEXTILE INDUSTRY PT.", "taxes" => "pajak", ],
[ "id" => "108", "name" => "TRISCO TAILORED APPAREL MANUFACTURING PT", "taxes" => "pajak", ],
[ "id" => "109", "name" => "DATER GARMENT INDUSTRI PT.", "taxes" => "pajak", ],
[ "id" => "110", "name" => "SHAFIRA LARAS PERSADA PT.", "taxes" => "nonpajak", ],
[ "id" => "111", "name" => "SECRET MODE LINE PT.", "taxes" => "nonpajak", ],
[ "id" => "112", "name" => "RANTI MOSLEM GALLERY", "taxes" => "nonpajak", ],
[ "id" => "113", "name" => "GLOBALINDO INTIMATES PT.", "taxes" => "pajak", ],
[ "id" => "114", "name" => "MAJU JAYA UTAMA PT.", "taxes" => "nonpajak", ],
[ "id" => "115", "name" => "REGENCY SOURCING INDONESIA, PT", "taxes" => "pajak", ],
[ "id" => "116", "name" => "PT. ADITYA MANDIRI SEJAHTERA", "taxes" => "pajak", ],
[ "id" => "117", "name" => "STAR CAMTEX PT", "taxes" => "nonpajak", ],
[ "id" => "118", "name" => "INSKA PT.", "taxes" => "nonpajak", ],
[ "id" => "119", "name" => "MELINDO BUSANA INDAH PT", "taxes" => "pajak", ],
[ "id" => "120", "name" => "SANSAN SAUDARATEX JAYA PT", "taxes" => "pajak", ],
[ "id" => "121", "name" => "BIENSI FESYENINDO CV.", "taxes" => "nonpajak", ],
[ "id" => "122", "name" => "ANTUSA MITRA ABADI PT", "taxes" => "pajak", ],
[ "id" => "123", "name" => "INDAH JAYA TEXTILE INDUSTRY PT.", "taxes" => "pajak", ],
[ "id" => "124", "name" => "IL JIN SUN GARMENT PT", "taxes" => "nonpajak", ],
[ "id" => "125", "name" => "VISIONLAND SEMARANG PT.", "taxes" => "pajak", ],
[ "id" => "126", "name" => "JIALE INDONESIA GARMENT PT.", "taxes" => "nonpajak", ],
[ "id" => "127", "name" => "MAJU JAYA LESTARI PT.", "taxes" => "nonpajak", ],
[ "id" => "128", "name" => "SELANCAR MULTI BUSANA UTAMA PT", "taxes" => "pajak", ],
[ "id" => "129", "name" => "CIPTA BUSANA MANDIRI PT.", "taxes" => "pajak", ],
[ "id" => "130", "name" => "VISIONLAND GLOBAL APPAREL PT.", "taxes" => "pajak", ],
[ "id" => "131", "name" => "RAJEANS INDONESIA GLOBAL PT.", "taxes" => "pajak", ],
[ "id" => "132", "name" => "BATIK ARJUNA CEMERLANG PT.", "taxes" => "nonpajak", ],
[ "id" => "133", "name" => "EDDY GARMENT", "taxes" => "nonpajak", ],
[ "id" => "134", "name" => "MORICH INDO FASHION PT.", "taxes" => "pajak", ],
[ "id" => "135", "name" => "SURIA GEMILANG ABADI PT", "taxes" => "nonpajak", ],
[ "id" => "136", "name" => "RESPIRO", "taxes" => "nonpajak", ],
[ "id" => "137", "name" => "CROWN HEADWEAR & KNITTING MILL PT.", "taxes" => "nonpajak", ],
[ "id" => "138", "name" => "SANTOSA HOSPITAL", "taxes" => "nonpajak", ],
[ "id" => "139", "name" => "KENKA", "taxes" => "nonpajak", ],
[ "id" => "140", "name" => "RYANINDO SENTOSALESTARI PT.", "taxes" => "pajak", ],
[ "id" => "141", "name" => "BINTANG JAYA", "taxes" => "nonpajak", ],
[ "id" => "142", "name" => "SINGA MAS GARMENT CV.", "taxes" => "pajak", ],
[ "id" => "143", "name" => "PT. DWI PUTRA SAKTI", "taxes" => "pajak", ],
[ "id" => "144", "name" => "PIPAMAS PRIMASEJATI PT.", "taxes" => "nonpajak", ],
[ "id" => "145", "name" => "MULTI ANUGERAH DAYA GARMINDO PT.", "taxes" => "pajak", ],
[ "id" => "146", "name" => "PT. MON FORT DEO INDONESIA", "taxes" => "pajak", ],
[ "id" => "147", "name" => "GISTEX GARMEN INDONESIA PT.", "taxes" => "pajak", ],
[ "id" => "148", "name" => "POP STAR PT.", "taxes" => "pajak", ],
[ "id" => "149", "name" => "DUTA PRATAMA MANDIRI PT.", "taxes" => "pajak", ],
[ "id" => "150", "name" => "TYFOUNTEX INDONESIA PT.", "taxes" => "pajak", ],
[ "id" => "151", "name" => "DWI SUKSES MANDIRI CV.", "taxes" => "pajak", ],
[ "id" => "152", "name" => "BERKAT JAYA PT.", "taxes" => "nonpajak", ],
[ "id" => "153", "name" => "KUSUMA MULIA KENCANA PT.", "taxes" => "pajak", ],
[ "id" => "154", "name" => "MENARA INTI NUSANTARA CV.", "taxes" => "nonpajak", ],
[ "id" => "155", "name" => "KREASINDO GARMENTAMA ABADI PT.", "taxes" => "pajak", ],
[ "id" => "156", "name" => "BINTANG ASIA CEMERLANG", "taxes" => "nonpajak", ],
[ "id" => "157", "name" => "MENARA INTI NUSANTARA CV.", "taxes" => "pajak", ],
[ "id" => "158", "name" => "SAHABAT UNGGUL INTERNATIONAL PT.", "taxes" => "pajak", ],
[ "id" => "159", "name" => "ARGO MANUNGGAL TRIASTA PT.", "taxes" => "pajak", ],
[ "id" => "160", "name" => "THETA BERKAT ANUGRAH PT.", "taxes" => "pajak", ],
[ "id" => "161", "name" => "HARRELL PT.", "taxes" => "nonpajak", ],
[ "id" => "162", "name" => "AGUNG JAYA PRATHI MANGALA PT.", "taxes" => "pajak", ],
[ "id" => "163", "name" => "K-ME ANUGRAH JAYA CV.", "taxes" => "pajak", ],
[ "id" => "164", "name" => "ANUGRAH KARYA BERDIKARI CV.", "taxes" => "nonpajak", ],
[ "id" => "165", "name" => "INDO MAKMUR MANDIRI CV.", "taxes" => "pajak", ],
[ "id" => "166", "name" => "NOORE", "taxes" => "pajak", ],
[ "id" => "167", "name" => "HOLI KARYA SAKTI PT.", "taxes" => "pajak", ],
[ "id" => "168", "name" => "BASAMA SOGA PT", "taxes" => "nonpajak", ],
[ "id" => "169", "name" => "TRIGOLDENSTAR WISESA PT.", "taxes" => "pajak", ],
[ "id" => "170", "name" => "KUK DONG INTERNATIONAL PT.", "taxes" => "nonpajak", ],
[ "id" => "171", "name" => "MANDJHA", "taxes" => "nonpajak", ],
[ "id" => "172", "name" => "SIGAP JAYA SAMPOERNA PT", "taxes" => "pajak", ],
[ "id" => "173", "name" => "TEXWELL KARUNIA MAKMUR PT.", "taxes" => "pajak", ],
[ "id" => "174", "name" => "LIFEWORK NUSANTARA PT.", "taxes" => "pajak", ],
[ "id" => "175", "name" => "SINAR LENTERA ABADI CV.", "taxes" => "pajak", ],
[ "id" => "176", "name" => "NICK\'S COLLECTION", "taxes" => "nonpajak", ],
[ "id" => "177", "name" => "DAYA BUSANA GEMILANG CV.", "taxes" => "pajak", ],
[ "id" => "178", "name" => "DWIPRIMA MULTI GARMEN PT.", "taxes" => "pajak", ],
[ "id" => "179", "name" => "ARKA FOOTWEAR INDONESIA PT.", "taxes" => "pajak", ],
[ "id" => "180", "name" => "SERASI GAYA BUSANA PT.", "taxes" => "pajak", ],
[ "id" => "181", "name" => "ISSU MEDIKA VETERINDO PT.", "taxes" => "pajak", ],
[ "id" => "182", "name" => "BAGOES TJIPTA KARYA PT.", "taxes" => "pajak", ],
[ "id" => "183", "name" => "PATUHA OUTDOOR EQUIPMENT", "taxes" => "nonpajak", ],
[ "id" => "184", "name" => "NYWAN GARMINDO CV.", "taxes" => "nonpajak", ],
[ "id" => "185", "name" => "ANEKA PRODUKSI NUSAJAYA, PT", "taxes" => "nonpajak", ],
[ "id" => "186", "name" => "GRAND TEXTILE INDUSTRY, PT", "taxes" => "nonpajak", ],
[ "id" => "187", "name" => "TEKAD MANDIRI CITRA PT.", "taxes" => "nonpajak", ],
[ "id" => "188", "name" => "GRACE PRIMO PT.", "taxes" => "pajak", ],
[ "id" => "189", "name" => "ABC Label", "taxes" => "nonpajak", ],
[ "id" => "190", "name" => "CV. CAHAYA BERKAT BERSAMA", "taxes" => "pajak", ],
[ "id" => "191", "name" => "PT. MERCINDO GLOBAL MANUFAKTUR", "taxes" => "pajak", ],
[ "id" => "192", "name" => "UTAMA JAYA GARMENT CV.", "taxes" => "pajak", ],
[ "id" => "193", "name" => "PRIMA DWITAMA ANUGRAH, PT", "taxes" => "pajak", ],
[ "id" => "194", "name" => "BERSAMA ZATTA JAYA, PT", "taxes" => "pajak", ],
[ "id" => "195", "name" => "RICH AND NOBLE TRADING, PT", "taxes" => "nonpajak", ],
[ "id" => "196", "name" => "TEGAR PRIMANUSANTARA, PT", "taxes" => "pajak", ],
[ "id" => "197", "name" => "INTIDRAGON SURYATAMA, PT", "taxes" => "nonpajak", ],
[ "id" => "198", "name" => "INTIDRAGON SURYATAMA", "taxes" => "pajak", ],
[ "id" => "199", "name" => "AS PRODUCTION", "taxes" => "nonpajak", ],
[ "id" => "200", "name" => "UNCLE STORAGE", "taxes" => "nonpajak", ],
[ "id" => "201", "name" => "BERKAT TRITUNGGAL BERSAMA, PT.", "taxes" => "pajak", ],
[ "id" => "202", "name" => "OLIVER GARETH", "taxes" => "nonpajak", ],
[ "id" => "203", "name" => "MATARAM TUNGGAL GARMENT, PT.", "taxes" => "pajak", ],
[ "id" => "204", "name" => "MITRA DINAMIKA SEJATI, PT.", "taxes" => "nonpajak", ],
[ "id" => "205", "name" => "EFRATA RETAILINDO, PT.", "taxes" => "pajak", ],
[ "id" => "206", "name" => "KURNIA ANDALAN SAKTI, PT", "taxes" => "pajak", ],
[ "id" => "207", "name" => "TRISENTA INTERIOR MANUFACTURING, PT.", "taxes" => "pajak", ],
[ "id" => "208", "name" => "KHARISMA LESTARI JAYA, PT.", "taxes" => "pajak", ],
[ "id" => "209", "name" => "HEMDEN CORP CV.", "taxes" => "pajak", ],
[ "id" => "210", "name" => "MUKTI MAKMUR SEJATI, CV.", "taxes" => "pajak", ],
[ "id" => "211", "name" => "MADANI SANDANG PRIMA, PT", "taxes" => "pajak", ],
[ "id" => "212", "name" => "SETIAP HARI DIPAKAI, PT.", "taxes" => "nonpajak", ],
[ "id" => "213", "name" => "BARU, PD.", "taxes" => "nonpajak", ],
[ "id" => "214", "name" => "ALISHA FANCY SHOP", "taxes" => "nonpajak", ],
[ "id" => "215", "name" => "SETIADI", "taxes" => "nonpajak", ],
[ "id" => "216", "name" => "APPARELINDO PRIMA SENTOSA, PT.", "taxes" => "pajak", ],
[ "id" => "217", "name" => "NARWASTU PRATAMA, CV.", "taxes" => "pajak", ],
[ "id" => "218", "name" => "BINTANG MANDIRI HANAFINDO, PT.", "taxes" => "pajak", ],
[ "id" => "219", "name" => "TAJIMA PUTERA GARMINDO, PT.", "taxes" => "pajak", ],
[ "id" => "220", "name" => "SRI REJEKI ISMAN, PT.", "taxes" => "pajak", ],
[ "id" => "221", "name" => "VADCO PROSPER MEGA, PT.", "taxes" => "pajak", ],
[ "id" => "222", "name" => "VETTU MODA", "taxes" => "pajak", ],
[ "id" => "223", "name" => "ARIN COLLECTION", "taxes" => "nonpajak", ],
[ "id" => "224", "name" => "ANUGRAH SUKSES SEJAHTERA, PT.", "taxes" => "pajak", ],
[ "id" => "225", "name" => "PANCA KARYA MAKMUR, CV.", "taxes" => "nonpajak", ],
[ "id" => "226", "name" => "SKELLY INDONESIA", "taxes" => "nonpajak", ],
[ "id" => "227", "name" => "KOMITRANDO-EMPORIO, PT.", "taxes" => "pajak", ],
[ "id" => "228", "name" => "SIGMA LABSINDO, CV.", "taxes" => "pajak", ],
[ "id" => "229", "name" => "JAYA ASRI GARMINDO, PT.", "taxes" => "pajak", ],
[ "id" => "230", "name" => "JANSSEN GARMINDO, CV.", "taxes" => "pajak", ],
[ "id" => "231", "name" => "FIT PEDIA", "taxes" => "nonpajak", ],
[ "id" => "232", "name" => "NUSATAMA SEJAHTERA, PT.", "taxes" => "pajak", ],
[ "id" => "233", "name" => "PUTERA PRATAMA PERSADA, PT.", "taxes" => "nonpajak", ],
[ "id" => "234", "name" => "BLESSINDO BERSAMA, PT.", "taxes" => "pajak", ],
[ "id" => "235", "name" => "AYANA INDAH MAKMUR, PT", "taxes" => "pajak", ],
[ "id" => "236", "name" => "TEXCRAFT SOURCING INDONESIA, PT.", "taxes" => "pajak", ],
[ "id" => "237", "name" => "TEXWELL MANUFACTURING CENTRE, PT.", "taxes" => "pajak", ],
[ "id" => "238", "name" => "PAN BROTHER TBK, PT. (PAN8)", "taxes" => "nonpajak", ],
[ "id" => "239", "name" => "PADL GARMENT, CV.", "taxes" => "pajak", ],
[ "id" => "240", "name" => "CIPTA BERSAMA, PT.", "taxes" => "pajak", ],
[ "id" => "241", "name" => "AZURA COLLECTION", "taxes" => "nonpajak", ],
[ "id" => "242", "name" => "EKA MULYA PERKASA, PT.", "taxes" => "pajak", ],
[ "id" => "243", "name" => "BERKAH INDO GARMENT, PT. (UNGARAN)", "taxes" => "pajak", ],
[ "id" => "244", "name" => "LA SONYA", "taxes" => "nonpajak", ],
[ "id" => "245", "name" => "UWU JUMP INDONESIA, PT.", "taxes" => "pajak", ],
[ "id" => "246", "name" => "RAW TYPE", "taxes" => "nonpajak", ],
[ "id" => "247", "name" => "SURYA SUKSES PERKASA, PT.", "taxes" => "pajak", ],
[ "id" => "248", "name" => "ANUGRAH PERDANA INDONESIA, PT.", "taxes" => "nonpajak", ],
[ "id" => "249", "name" => "TAKUMI, CV.", "taxes" => "nonpajak", ],
[ "id" => "250", "name" => "SYAHEERA GEMILANG INDONESIA, PT.", "taxes" => "pajak", ],
[ "id" => "251", "name" => "C APPAREL", "taxes" => "nonpajak", ],
[ "id" => "252", "name" => "IBU IMA", "taxes" => "nonpajak", ],
[ "id" => "253", "name" => "ANUGRAH LESTARI ABADI", "taxes" => "nonpajak", ],
[ "id" => "254", "name" => "ABADI GARMINDO, PT.", "taxes" => "pajak", ],
[ "id" => "255", "name" => "PERDANA FIRSTA GARMENT, PT.", "taxes" => "nonpajak", ],
[ "id" => "256", "name" => "PT. STAR ALLIANCE INTIMATES", "taxes" => "pajak", ],
[ "id" => "257", "name" => "BERKAT LANGGENG SUKSES, PT.", "taxes" => "pajak", ],
[ "id" => "258", "name" => "SATU SEMBILAN DELAPAN INTERNASIONAL, PT.", "taxes" => "pajak", ],
[ "id" => "259", "name" => "TOKO PLASTIK CUTE", "taxes" => "nonpajak", ],
[ "id" => "260", "name" => "DEWI SAMUDRA KUSUMA, PT.", "taxes" => "pajak", ],
[ "id" => "261", "name" => "ARINDO GARMENTAMA, PT.", "taxes" => "pajak", ],
[ "id" => "262", "name" => "SUMBER MITRA GASUTRI, PT.", "taxes" => "pajak", ],
[ "id" => "263", "name" => "KREASI ANUGERAH INDONESIA, PT.", "taxes" => "pajak", ],
[ "id" => "264", "name" => "JAYA PRATAMA, PT.", "taxes" => "nonpajak", ],
[ "id" => "265", "name" => "BINTANG KEJORA SEJAHTERA, PT", "taxes" => "nonpajak", ],
[ "id" => "266", "name" => "SUMBER SELARAS ABADI, PT.", "taxes" => "pajak", ],
[ "id" => "267", "name" => "GEMA BERKAT UTAMA, PT.", "taxes" => "pajak", ],
[ "id" => "268", "name" => "MITRA PERKASA, CV.", "taxes" => "pajak", ],
[ "id" => "269", "name" => "MEKAR MAKMUR ABADI, PT.", "taxes" => "pajak", ],
[ "id" => "270", "name" => "PAN BROTHER TBK, PT. (PAN9)", "taxes" => "pajak", ],
[ "id" => "271", "name" => "TRININDO INTERSURYA, PT.", "taxes" => "pajak", ],
[ "id" => "272", "name" => "SIXTY", "taxes" => "nonpajak", ],
[ "id" => "273", "name" => "BETAWI BAGUS, CV", "taxes" => "nonpajak", ],
[ "id" => "274", "name" => "G-COLLECTION, CV.", "taxes" => "pajak", ],
[ "id" => "275", "name" => "MAKLUN", "taxes" => "nonpajak", ],
[ "id" => "276", "name" => "INTI SUKSES GARMINDO, PT.", "taxes" => "pajak", ],
[ "id" => "277", "name" => "SALE STOCK INDONESIA, PT.", "taxes" => "pajak", ],
[ "id" => "278", "name" => "SHENIA FASHION", "taxes" => "nonpajak", ],
[ "id" => "279", "name" => "HARINDOTAMA MANDIRI, PT.", "taxes" => "pajak", ],
[ "id" => "280", "name" => "CLARISSA PERDANA JAYA, CV.", "taxes" => "pajak", ],
[ "id" => "281", "name" => "BINTANG MANDIRI HANAFINDO PT", "taxes" => "pajak", ],
[ "id" => "282", "name" => "WESTAPUSAKA KUSUMA, PT.", "taxes" => "pajak", ],
[ "id" => "283", "name" => "BUSANA REMAJA AGRACIPTA PT.", "taxes" => "pajak", ],
[ "id" => "284", "name" => "BUSANA REMAJA AGRACIPTA PT.", "taxes" => "pajak", ],
[ "id" => "285", "name" => "HOP LUN INDONESIA, PT.", "taxes" => "pajak", ],
[ "id" => "286", "name" => "CARTINI LINGERIE INDONESIA, PT.", "taxes" => "pajak", ],
[ "id" => "287", "name" => "EIGERINDO MULTIPRODUK INDUSTRI, PT.", "taxes" => "pajak", ],
[ "id" => "288", "name" => "PT. FAST MANUFACTURING", "taxes" => "pajak", ],
[ "id" => "289", "name" => "DAENONG GLOBAL, PT.", "taxes" => "pajak", ],
[ "id" => "290", "name" => "GLORY STAR WISESA, PT.", "taxes" => "pajak", ],
[ "id" => "291", "name" => "KOKEN INDONESIA, PT.", "taxes" => "nonpajak", ],
[ "id" => "292", "name" => "AYAM GEPREK PA ILMAN", "taxes" => "nonpajak", ],
[ "id" => "293", "name" => "KUK DONG CORPORATION", "taxes" => "nonpajak", ],
[ "id" => "294", "name" => "ABACUS", "taxes" => "nonpajak", ],
[ "id" => "295", "name" => "Wardrobe & Storie", "taxes" => "nonpajak", ],
[ "id" => "296", "name" => "MAB, PT.", "taxes" => "nonpajak", ],
[ "id" => "297", "name" => "GREENTEX INDONESIA UTAMA II, PT", "taxes" => "pajak", ],
[ "id" => "298", "name" => "MIRAE ASIA PASIFIK, PT.", "taxes" => "pajak", ],
[ "id" => "299", "name" => "KOMITRANDO-EMPORIO, PT.", "taxes" => "pajak", ],
[ "id" => "300", "name" => "PT. MARVEL SPORTS INTERNATIONAL", "taxes" => "pajak", ],
[ "id" => "301", "name" => "PT. BADJATEX", "taxes" => "pajak", ],
[ "id" => "302", "name" => "CATUR PERDANA LESTARI, PT.", "taxes" => "pajak", ],
[ "id" => "303", "name" => "PHILLIP WORKS", "taxes" => "nonpajak", ],
[ "id" => "304", "name" => "ESKA JAYA SENTOSA, CV.", "taxes" => "pajak", ],
[ "id" => "305", "name" => "HASA, PT.", "taxes" => "pajak", ],
[ "id" => "306", "name" => "MASTERINDO JAYA ABADI, PT.", "taxes" => "pajak", ],
[ "id" => "307", "name" => "CIPTA PRATAMA, CV.", "taxes" => "pajak", ],
[ "id" => "308", "name" => "MULIA CEMERLANG ABADI MULTI INDUSTRY, PT.", "taxes" => "pajak", ],
[ "id" => "309", "name" => "BERKAT SEJAHTERA GARMENT, CV.", "taxes" => "pajak", ],
[ "id" => "310", "name" => "GAR SOL INDO, CV.", "taxes" => "nonpajak", ],
[ "id" => "311", "name" => "BERSAMA DAUKY MULYA, PT.", "taxes" => "pajak", ],
[ "id" => "312", "name" => "CIPTA SANDANG JAYA, CV.", "taxes" => "nonpajak", ],
[ "id" => "313", "name" => "IVAN CIPTA MUKTI PERKASA PT", "taxes" => "nonpajak", ],
[ "id" => "314", "name" => "BERYL ABDIEL BERSAUDARA, PT.", "taxes" => "pajak", ],
[ "id" => "315", "name" => "IVAN BERDIKARI LARAS CITA, PT.", "taxes" => "nonpajak", ],
[ "id" => "316", "name" => "BRA PRO LIMITED", "taxes" => "pajak", ],
[ "id" => "317", "name" => "PROSPECTA GARMINDO, PT.", "taxes" => "pajak", ],
[ "id" => "318", "name" => "PKM Marketing Ventures, PT.", "taxes" => "nonpajak", ],
[ "id" => "319", "name" => "SIEMASS MULTITECH, CV.", "taxes" => "pajak", ],
[ "id" => "320", "name" => "WIRASANDI, CV.", "taxes" => "nonpajak", ],
[ "id" => "321", "name" => "BEST GARMENT, PT.", "taxes" => "nonpajak", ],
[ "id" => "322", "name" => "SOLO KAWISTARA GARMINDO, PT.", "taxes" => "pajak", ],
[ "id" => "323", "name" => "MAJU LESTARI, CV.", "taxes" => "pajak", ],
[ "id" => "324", "name" => "DEHASANA PRIMA INDONESIA, PT.", "taxes" => "pajak", ],
[ "id" => "325", "name" => "CV. MITRA PRATAMA INDUSTRI", "taxes" => "pajak", ],
[ "id" => "326", "name" => "ANGGE ANGGE ANGGANA ADHI, PT.", "taxes" => "pajak", ],
[ "id" => "327", "name" => "ANUGRAH GUNA ABADI, PT.", "taxes" => "pajak", ],
[ "id" => "328", "name" => "RDK SYARI & BAG", "taxes" => "nonpajak", ],
[ "id" => "329", "name" => "SENTRAKREASI BUSANAUTAMA, PT.", "taxes" => "pajak", ],
[ "id" => "330", "name" => "FAJARINDO EKA MRIYAH JAYA, PT.", "taxes" => "nonpajak", ],
[ "id" => "331", "name" => "ERATEX DJAJA TBK., PT.", "taxes" => "pajak", ],
[ "id" => "332", "name" => "ERATEX DJAJA TBK., PT. (Factory)", "taxes" => "pajak", ],
[ "id" => "333", "name" => "IGP INTERNASIONAL, PT.", "taxes" => "pajak", ],
[ "id" => "334", "name" => "COLOUR SYMPHONY INDONESIA, PT.", "taxes" => "pajak", ],
[ "id" => "335", "name" => "DAENONG CORPORATION", "taxes" => "pajak", ],
[ "id" => "336", "name" => "SAMWON BUSANA INDONESIA, PT.", "taxes" => "pajak", ],
[ "id" => "337", "name" => "MITRA DIGITAL KARYA MANFAAT, PT.", "taxes" => "pajak", ],
[ "id" => "338", "name" => "MLY JEANS, CV", "taxes" => "pajak", ],
[ "id" => "339", "name" => "MINNIE PRODUCTION, CV.", "taxes" => "pajak", ],
[ "id" => "340", "name" => "DAPUR KAOS INDONESIA, PT.", "taxes" => "pajak", ],
[ "id" => "341", "name" => "ANUGRAH BERDIKARI, CV.", "taxes" => "nonpajak", ],
[ "id" => "342", "name" => "PHILYXINDO, CV.", "taxes" => "pajak", ],
[ "id" => "343", "name" => "ASHTA ASITI, CV.", "taxes" => "pajak", ],
[ "id" => "344", "name" => "SINSIN WASHING AND GARMENT", "taxes" => "nonpajak", ],
[ "id" => "345", "name" => "UNILAM S.A.", "taxes" => "nonpajak", ],
[ "id" => "346", "name" => "ANYCLO Inc, PT.", "taxes" => "nonpajak", ],
[ "id" => "347", "name" => "WARTIWAN", "taxes" => "nonpajak", ],
[ "id" => "348", "name" => "MITRA CAHAYA DEWAPUTRA, PT.", "taxes" => "pajak", ],
[ "id" => "349", "name" => "ARIYAN MAYTON", "taxes" => "nonpajak", ],
[ "id" => "350", "name" => "AMRA APPAREL INDUSTRIES, PT.", "taxes" => "pajak", ],
[ "id" => "351", "name" => "DREAMWEAR, PT.", "taxes" => "pajak", ],
[ "id" => "352", "name" => "ANUGRAH JAYA RETAILINDO, PT.", "taxes" => "pajak", ],
[ "id" => "353", "name" => "DAESE GARMIN, PT.", "taxes" => "pajak", ],
[ "id" => "354", "name" => "Bapak Agus", "taxes" => "nonpajak", ],
[ "id" => "355", "name" => "LYDIA SOLA GRACIA, PT.", "taxes" => "pajak", ],
[ "id" => "356", "name" => "KONSEP SATU ATELIER, PT.", "taxes" => "pajak", ],
[ "id" => "357", "name" => "ALENDORS GLOBAL PRODUCTION, PT.", "taxes" => "pajak", ],
[ "id" => "358", "name" => "R. M. BASALERO", "taxes" => "nonpajak", ],
[ "id" => "359", "name" => "INDO LESTARIANI, CV.", "taxes" => "pajak", ],
[ "id" => "360", "name" => "RUMAH PRINTING COVINA", "taxes" => "nonpajak", ],
[ "id" => "361", "name" => "UNGGUL MAKMUR SEJAHTERA, PT.", "taxes" => "pajak", ],
[ "id" => "362", "name" => "SENTRA SANDANG MULYA, CV.", "taxes" => "pajak", ],
[ "id" => "363", "name" => "Bapak Lung Lung", "taxes" => "nonpajak", ],
[ "id" => "364", "name" => "ANT4 STORE", "taxes" => "nonpajak", ],
[ "id" => "365", "name" => "KOKIKA DENIM KREATIF, PT.", "taxes" => "pajak", ],
[ "id" => "366", "name" => "VANLEE ABADI NIAGA, PT", "taxes" => "pajak", ],
[ "id" => "367", "name" => "MOD INDO, PT.", "taxes" => "pajak", ],
[ "id" => "368", "name" => "MERIDIAN OFFSET, CV.", "taxes" => "nonpajak", ],
[ "id" => "369", "name" => "PT. ADITYA MANDIRI GARMINDO", "taxes" => "pajak", ],
[ "id" => "370", "name" => "ADI SATRIA ABADI, PT.", "taxes" => "pajak", ],
[ "id" => "371", "name" => "ILHAM AMS", "taxes" => "nonpajak", ],
[ "id" => "372", "name" => "WAWAN", "taxes" => "nonpajak", ],
[ "id" => "373", "name" => "MENTARI ESA CIPTA, PT.", "taxes" => "pajak", ],
[ "id" => "374", "name" => "SUHO GARMINDO CV.", "taxes" => "pajak", ],
[ "id" => "375", "name" => "ADITYA MANDIRI GARMINDO, PT. (PML)", "taxes" => "pajak", ],
[ "id" => "376", "name" => "GLOBAL BAKERY", "taxes" => "nonpajak", ],
[ "id" => "377", "name" => "FAVORI CORP SEDAYA, PT.", "taxes" => "pajak", ],
[ "id" => "378", "name" => "IBU IDA", "taxes" => "nonpajak", ],
[ "id" => "379", "name" => "ZHENAWESOME KREASI NUSANTARA, PT.", "taxes" => "nonpajak", ],
[ "id" => "380", "name" => "IBU RIANA", "taxes" => "nonpajak", ],
[ "id" => "381", "name" => "MAJU JAYA", "taxes" => "nonpajak", ],
[ "id" => "382", "name" => "TOKO PLASTIK 9/9", "taxes" => "nonpajak", ],
[ "id" => "383", "name" => "MEGATAMA KREASI INDONESIA, PT.", "taxes" => "pajak", ],
[ "id" => "384", "name" => "Martabak Gina (Pak Maman)", "taxes" => "nonpajak", ],
[ "id" => "385", "name" => "KRISNA SARI BAKERY", "taxes" => "nonpajak", ],
[ "id" => "386", "name" => "AYAM GEPREK BANG DOR", "taxes" => "nonpajak", ],
[ "id" => "387", "name" => "SOLAN", "taxes" => "nonpajak", ],
[ "id" => "388", "name" => "BANDUNG MAKUTA", "taxes" => "nonpajak", ],
[ "id" => "389", "name" => "PANTJATUNGGAL KNITTING MILL, PT", "taxes" => "pajak", ],
[ "id" => "390", "name" => "ALTIMA MANDIRI, PT.", "taxes" => "nonpajak", ],
[ "id" => "391", "name" => "DAPUR LEMBAR DAUN", "taxes" => "nonpajak", ],
[ "id" => "392", "name" => "Bapak Iman", "taxes" => "nonpajak", ],
[ "id" => "393", "name" => "Bapak M. Rozzaq", "taxes" => "nonpajak", ],
[ "id" => "394", "name" => "PAN RAMA VISTA GARMENT INDUSTRIES, PT.", "taxes" => "pajak", ],
[ "id" => "395", "name" => "CV. Harapan Sukses Bersama", "taxes" => "nonpajak", ],
[ "id" => "396", "name" => "HD PLASTIK", "taxes" => "nonpajak", ],
[ "id" => "397", "name" => "DAPUR GG", "taxes" => "nonpajak", ],
[ "id" => "398", "name" => "TOKO PLASTIK PUTRA MANDIRI", "taxes" => "nonpajak", ],
[ "id" => "399", "name" => "TOKO PLASTIK DENIS", "taxes" => "nonpajak", ],
[ "id" => "400", "name" => "SEBLAK PAPA DINO", "taxes" => "nonpajak", ],
[ "id" => "401", "name" => "ATTALYKA PACKAGING", "taxes" => "nonpajak", ],
[ "id" => "402", "name" => "DOBELI INDONESIA, PT.", "taxes" => "nonpajak", ],
[ "id" => "403", "name" => "TOKO PLASTIK AZMI", "taxes" => "nonpajak", ],
[ "id" => "404", "name" => "TOKO PLASTIK BENO", "taxes" => "nonpajak", ],
[ "id" => "405", "name" => "TOKO PLASTIK MAJENG BAROKAH", "taxes" => "nonpajak", ],
[ "id" => "533", "name" => "WARUNG MAKAN MAEM CHICBOX", "taxes" => "nonpajak", ],
[ "id" => "534", "name" => "PT. MAHKOTA TRI ANGJAYA", "taxes" => "nonpajak", ],
[ "id" => "535", "name" => "NOVITA", "taxes" => "nonpajak", ],
[ "id" => "536", "name" => "MOCHI VICTORY", "taxes" => "nonpajak", ],
[ "id" => "537", "name" => "PT. ASMARA KARYA ABADI", "taxes" => "nonpajak", ],
[ "id" => "538", "name" => "LEONIST LINEN", "taxes" => "nonpajak", ],
[ "id" => "539", "name" => "TOKO PLASTIK BAROKAH", "taxes" => "nonpajak", ],
[ "id" => "540", "name" => "ETHICA", "taxes" => "nonpajak", ],
[ "id" => "541", "name" => "PT. BUANA SAMUDERA LESTARI", "taxes" => "nonpajak", ],
[ "id" => "542", "name" => "PT. KAHATEX - Sock Div", "taxes" => "nonpajak", ],
[ "id" => "543", "name" => "PT. NEO LEVEL UP", "taxes" => "nonpajak", ],
[ "id" => "544", "name" => "PT. MIDAS INDONESIA", "taxes" => "nonpajak", ],
[ "id" => "545", "name" => "Warung Nasi Khas Sunda Asli Laksana", "taxes" => "nonpajak", ],
[ "id" => "546", "name" => "MIESOL", "taxes" => "nonpajak", ],
[ "id" => "547", "name" => "Momis Bakery", "taxes" => "nonpajak", ],
[ "id" => "548", "name" => "PT. AMBASSADOR GARMINDO", "taxes" => "pajak", ],
[ "id" => "549", "name" => "Bu Linda", "taxes" => "nonpajak", ],
[ "id" => "550", "name" => "DONAT MADU SUSU MISSU", "taxes" => "nonpajak", ],
[ "id" => "551", "name" => "AYAM BAKAR & GEPREK SEMRAWUT", "taxes" => "nonpajak", ],
[ "id" => "552", "name" => "NASI TELOR FAVORIT", "taxes" => "nonpajak", ],
[ "id" => "553", "name" => "TAHU SUSU", "taxes" => "nonpajak", ],
[ "id" => "554", "name" => "PT. MODERO INTEGRA ASIA", "taxes" => "nonpajak", ],
[ "id" => "555", "name" => "PT. SINAR LEGIT ABADI", "taxes" => "nonpajak", ],
[ "id" => "556", "name" => "MARTABAK", "taxes" => "nonpajak", ],
[ "id" => "557", "name" => "KHOE PEK GOAN", "taxes" => "nonpajak", ],
[ "id" => "558", "name" => "IBU LIA", "taxes" => "nonpajak", ],
[ "id" => "559", "name" => "TOKO KUE LIZA", "taxes" => "nonpajak", ],
[ "id" => "560", "name" => "AYAM GORENG TULANG LUNAK JEMPOL", "taxes" => "nonpajak", ],
[ "id" => "561", "name" => "PT. DEKATAMA CENTRA", "taxes" => "pajak", ],
[ "id" => "562", "name" => "PEMPEK ANUGRAH", "taxes" => "nonpajak", ],
[ "id" => "563", "name" => "TOKO PLASTIK BERKAH", "taxes" => "nonpajak", ],
[ "id" => "564", "name" => "PT. SINERGI GANTENG UTAMA (Baso Aci Ganteng)", "taxes" => "nonpajak", ],
        ];

        foreach ($data as $customer) {
            Customer::create($customer);
        }
    }
}
