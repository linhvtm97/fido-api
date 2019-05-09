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
        $this->call(CertificateSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(RatingSeeder::class);
        $this->call(QuestionSeeder::class);
    }
}
