<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\JobsTableSeeder;
use Database\Seeders\FilesTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\DriversTableSeeder;
use Database\Seeders\CatatansTableSeeder;
use Database\Seeders\FormRabsTableSeeder;
use Database\Seeders\MachinesTableSeeder;
use Database\Seeders\CustomersTableSeeder;
use Database\Seeders\WorkStepsTableSeeder;
use Database\Seeders\KeterangansTableSeeder;
use Database\Seeders\WarnaPlatesTableSeeder;
use Database\Seeders\FileRinciansTableSeeder;
use Database\Seeders\FileSettingsTableSeeder;
use Database\Seeders\InstructionsTableSeeder;
use Database\Seeders\LayoutBahansTableSeeder;
use Database\Seeders\WorkStepListTableSeeder;
use Database\Seeders\RincianPlatesTableSeeder;
use Database\Seeders\LayoutSettingsTableSeeder;
use Database\Seeders\FormKeterangansTableSeeder;
use Database\Seeders\KeteranganFoilsTableSeeder;
use Database\Seeders\KeteranganPlatesTableSeeder;
use Database\Seeders\KeteranganScreensTableSeeder;
use Database\Seeders\KeteranganPisauPondsTableSeeder;
use Database\Seeders\KeteranganCetakLabelsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(InstructionsTableSeeder::class);
        
        $this->call(CustomersTableSeeder::class);
        $this->call(DriversTableSeeder::class);
        $this->call(WorkStepListTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(JobsTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
        $this->call(MachinesTableSeeder::class);
        $this->call(WorkStepsTableSeeder::class);
        $this->call(CatatansTableSeeder::class);
        $this->call(FilesTableSeeder::class);
        
        $this->call(KeterangansTableSeeder::class);
        $this->call(KeteranganFoilsTableSeeder::class);
        $this->call(KeteranganCetakLabelsTableSeeder::class);
        $this->call(KeteranganPisauPondsTableSeeder::class);
        $this->call(KeteranganPlatesTableSeeder::class);
        $this->call(LayoutSettingsTableSeeder::class);
        $this->call(LayoutBahansTableSeeder::class);
        $this->call(KeteranganScreensTableSeeder::class);
        $this->call(RincianPlatesTableSeeder::class);
        $this->call(FileRinciansTableSeeder::class);
        $this->call(FileSettingsTableSeeder::class);
        $this->call(FormRabsTableSeeder::class);
        $this->call(WarnaPlatesTableSeeder::class);
    }
}
