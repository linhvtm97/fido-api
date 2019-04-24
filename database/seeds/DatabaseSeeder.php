<?php

use Illuminate\Database\Seeder;
use App\Certificate;

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
<<<<<<< HEAD
        $this->call(Certificate::class);
=======
        $this->call(AdminSeeder::class);
>>>>>>> 7c129d16d4e779032e77e910b11360742f318536
    }
}
