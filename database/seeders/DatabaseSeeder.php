<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\JobsTableSeeder;
use Database\Seeders\FilesTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\CatatansTableSeeder;
use Database\Seeders\MachinesTableSeeder;
use Database\Seeders\CustomersTableSeeder;
use Database\Seeders\WorkStepsTableSeeder;
use Database\Seeders\InstructionsTableSeeder;
use Database\Seeders\WorkStepListTableSeeder;

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
        $this->call(WorkStepListTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(JobsTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
        $this->call(MachinesTableSeeder::class);
        $this->call(WorkStepsTableSeeder::class);
        $this->call(CatatansTableSeeder::class);
        $this->call(FilesTableSeeder::class);
    }
}
