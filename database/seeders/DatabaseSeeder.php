<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UsersTableSeeder;

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
        // $this->call(CustomersTableSeeder::class);
        // $this->call(WorkStepListTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        // $this->call(JobsTableSeeder::class);
        // $this->call(StatusesTableSeeder::class);
        // $this->call(MachinesTableSeeder::class);
    }
}
