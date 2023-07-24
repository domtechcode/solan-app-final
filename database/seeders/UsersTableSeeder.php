<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["id"=>"1","name"=>"Admin","username"=>"admin","role"=>"Admin","jobdesk"=>"Admin","current"=>"adminsln"],
            ["id"=>"2","name"=>"Siti Fadhilah Nurul Hikmah","username"=>"nurul","role"=>"Follow Up","jobdesk"=>"Follow Up","current"=>"followupsln"],
            ["id"=>"3","name"=>"Siti Yuni Awaningsih","username"=>"yuni","role"=>"Purchase","jobdesk"=>"Purchase","current"=>"purchasingsln"],
            ["id"=>"4","name"=>"Siti Maliah","username"=>"lia","role"=>"Penjadwalan","jobdesk"=>"Penjadwalan","current"=>"jadwalsln"],
            ["id"=>"5","name"=>"Novy Parwati","username"=>"novy","role"=>"Hitung Bahan","jobdesk"=>"Hitung Bahan","current"=>"estimatorsln2"],
            ["id"=>"6","name"=>"Kharisma Cahyani","username"=>"risma","role"=>"Hitung Bahan","jobdesk"=>"Hitung Bahan","current"=>"estimatorsln1"],
            ["id"=>"7","name"=>"Karina Kusumawardhani Haryono","username"=>"karina","role"=>"Accounting","jobdesk"=>"Accounting","current"=>"akuntingsln"],
            ["id"=>"8","name"=>"Antonius Budhi Setyana","username"=>"anton","role"=>"RAB","jobdesk"=>"RAB","current"=>"rabsln"],
            ["id"=>"9","name"=>"Ilman Al Fariz","username"=>"ilman","role"=>"Stock","jobdesk"=>"Stock","current"=>"gudangsln"],
            ["id"=>"10","name"=>"Dedi Rohimat","username"=>"dedi","role"=>"Operator","jobdesk"=>"Setting","current"=>"settingsln1"],
            ["id"=>"11","name"=>"Asep Ridayandi","username"=>"asep","role"=>"Operator","jobdesk"=>"Setting","current"=>"settingsln2"],
            ["id"=>"12","name"=>"Risti Noviani","username"=>"risti","role"=>"Operator","jobdesk"=>"Checker","current"=>"checkersln1"],
            ["id"=>"13","name"=>"Dewi Riani","username"=>"dewi","role"=>"Operator","jobdesk"=>"Checker","current"=>"checkersln2"],
            ["id"=>"14","name"=>"Verdian Ramadhan","username"=>"verdianplat","role"=>"Operator","jobdesk"=>"Plate","current"=>"opplat1"],
            ["id"=>"15","name"=>"Adit Noviansyah","username"=>"adit","role"=>"Operator","jobdesk"=>"Plate","current"=>"opplat2"],
            ["id"=>"16","name"=>"Suradi","username"=>"kikuk","role"=>"Operator","jobdesk"=>"Potong Bahan","current"=>"oppotong1"],
            ["id"=>"17","name"=>"Kustiadi","username"=>"engkus","role"=>"Operator","jobdesk"=>"Potong Jadi","current"=>"oppotong2"],
            ["id"=>"18","name"=>"Muhammad Zaki Fuad","username"=>"zaki","role"=>"Operator","jobdesk"=>"Potong Jadi","current"=>"oppotong3"],
            ["id"=>"19","name"=>"Ervin Dwi","username"=>"kevin","role"=>"Operator","jobdesk"=>"Cetak","current"=>"opcetak1"],
            ["id"=>"20","name"=>"Fahri Andriansyah","username"=>"fahri","role"=>"Operator","jobdesk"=>"Cetak","current"=>"opcetak2"],
            ["id"=>"21","name"=>"Aris Sutrisno","username"=>"aris","role"=>"Operator","jobdesk"=>"Cetak","current"=>"opcetak3"],
            ["id"=>"22","name"=>"Supriatna","username"=>"deni","role"=>"Operator","jobdesk"=>"Cetak","current"=>"opcetak4"],
            ["id"=>"23","name"=>"Enang Suryana","username"=>"enang","role"=>"Operator","jobdesk"=>"Cetak","current"=>"opcetak5"],
            ["id"=>"24","name"=>"Dahul Amin","username"=>"amin","role"=>"Operator","jobdesk"=>"Cetak","current"=>"opcetak6"],
            ["id"=>"25","name"=>"Ahmad Wasito","username"=>"sito","role"=>"Operator","jobdesk"=>"Cetak","current"=>"opcetak7"],
            ["id"=>"26","name"=>"Sahirin","username"=>"sahirin","role"=>"Operator","jobdesk"=>"Pond","current"=>"oppond1"],
            ["id"=>"27","name"=>"Galuh Priyadi","username"=>"galuh","role"=>"Operator","jobdesk"=>"Pond","current"=>"oppond2"],
            ["id"=>"28","name"=>"Muhamad Asep","username"=>"aseppond","role"=>"Operator","jobdesk"=>"Pond","current"=>"oppond3"],
            ["id"=>"29","name"=>"Umar","username"=>"umar","role"=>"Operator","jobdesk"=>"Pond","current"=>"oppond4"],
            ["id"=>"30","name"=>"Daniel Gunawan","username"=>"daniel","role"=>"Operator","jobdesk"=>"Pond","current"=>"oppond5"],
            ["id"=>"31","name"=>"Galuh Priyadi","username"=>"galuhfoil","role"=>"Operator","jobdesk"=>"Foil","current"=>"opfoil"],
            ["id"=>"32","name"=>"Suparno","username"=>"suparno","role"=>"Operator","jobdesk"=>"Coating","current"=>"oplaminating"],
            ["id"=>"33","name"=>"Jihan Sakinatu Zahra","username"=>"jihan","role"=>"Operator","jobdesk"=>"Coating","current"=>"opvarnish2"],
            ["id"=>"34","name"=>"Tarsalim","username"=>"tarsalim","role"=>"Operator","jobdesk"=>"Coating","current"=>"opvarnish1"],
            ["id"=>"35","name"=>"Sahirin","username"=>"sahirinsablon","role"=>"Operator","jobdesk"=>"Sablon","current"=>"opsablon"],
            ["id"=>"36","name"=>"Grup Finishing","username"=>"finishing","role"=>"Operator","jobdesk"=>"Finishing","current"=>"grupfinishing"],
            ["id"=>"37","name"=>"Grup QC","username"=>"qc","role"=>"Operator","jobdesk"=>"Qc Packing","current"=>"groupqc"],
            ["id"=>"38","name"=>"Susi Suswati","username"=>"susi","role"=>"Operator","jobdesk"=>"Pengiriman","current"=>"pengiriman"],
            ["id"=>"39","name"=>"Abung Sartoi","username"=>"abung","role"=>"Operator","jobdesk"=>"Team Finishing","current"=>"finishing1"],
            ["id"=>"40","name"=>"Sopiah Amaliah","username"=>"sopiah","role"=>"Operator","jobdesk"=>"Team Finishing","current"=>"finishing3"],
            ["id"=>"41","name"=>"Tiara Amelia","username"=>"tiara","role"=>"Operator","jobdesk"=>"Team Finishing","current"=>"finishing6"],
            ["id"=>"42","name"=>"Sandi Kurniawan","username"=>"sandi","role"=>"Operator","jobdesk"=>"Team Qc Packing","current"=>"qcontrol2"],
            ["id"=>"43","name"=>"Indra Purnama","username"=>"indra","role"=>"Operator","jobdesk"=>"Team Qc Packing","current"=>"qcontrol3"],
            ["id"=>"44","name"=>"Astry Fauzy Astriani","username"=>"astry","role"=>"Operator","jobdesk"=>"Team Qc Packing","current"=>"qcontrol4"],
            ["id"=>"45","name"=>"Elis Listiani","username"=>"elis","role"=>"Operator","jobdesk"=>"Team Qc Packing","current"=>"qcontrol5"],
            ["id"=>"46","name"=>"Nita Syifa Uljanah","username"=>"nita","role"=>"Operator","jobdesk"=>"Team Qc Packing","current"=>"qcontrol6"],
            ["id"=>"47","name"=>"Rizal Rifqi Sihabudin","username"=>"rizal","role"=>"Operator","jobdesk"=>"Team Qc Packing","current"=>"finishing2"],
            ["id"=>"48","name"=>"Nur Fitri","username"=>"nurfitri","role"=>"Operator","jobdesk"=>"Team Finishing","current"=>"finishing5"],
            ["id"=>"49","name"=>"Ahmad Dani","username"=>"dani","role"=>"Operator","jobdesk"=>"Team Finishing","current"=>"finishing6"],
            ["id"=>"50","name"=>"Mila Halimatul Jannah","username"=>"mila","role"=>"Operator","jobdesk"=>"Maklun","current"=>"maklun1"],
            ["id"=>"51","name"=>"Cecep Supriadi","username"=>"ahmad","role"=>"Operator","jobdesk"=>"Team Qc Packing","current"=>"qcontrol1"],
            ["id"=>"52","name"=>"Yusup Septi Mutaqin","username"=>"yusup","role"=>"Operator","jobdesk"=>"Cetak Label","current"=>"label2"],
            ["id"=>"53","name"=>"Tarsalim","username"=>"salim","role"=>"Operator","jobdesk"=>"Cetak Label","current"=>"label1"],
            ["id"=>"54","name"=>"Riri Permata Sari","username"=>"riri","role"=>"Accounting","jobdesk"=>"Accounting","current"=>"akuntingsln2"],
            ["id"=>"55","name"=>"Verdian Ramadhan","username"=>"verdiansetting","role"=>"Operator","jobdesk"=>"Setting","current"=>"settingsln3"],
            ["id"=>"56","name"=>"TRIANSYAH","username"=>"TRI","role"=>"Operator","jobdesk"=>"Cetak","current"=>"opcetak8"],
            ["id"=>"57","name"=>"Saiman","username"=>"saiman","role"=>"Operator","jobdesk"=>"Blok Lem","current"=>"opbloklem"],
            ["id"=>"58","name"=>"Tati","username"=>"tati","role"=>"RAB","jobdesk"=>"RAB","current"=>"rabsln2"],
            ["id"=>"59","name"=>"Tony","username"=>"tony","role"=>"RAB","jobdesk"=>"RAB","current"=>"rabsln3"]
        ];
        foreach ($data as $user) {
            $user['password'] = bcrypt($user['current']);
            User::create($user);
        }
    }
}
