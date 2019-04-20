<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DoctorSeeder::class);
        $this->call(PatientSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(UserSeeder::class);
    }
}
