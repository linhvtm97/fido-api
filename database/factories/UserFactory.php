<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Doctor;
use Illuminate\Support\Carbon;
use App\Patient;
use App\Employee;
use App\User;
use App\Admin;
use App\Certificate;
use App\Rating;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Doctor::class, function (Faker $faker) {
    static $doctor_number = 1;
    return [
        'name' => $faker->name,
        'status' => 'offline',
        'doctor_no' => 'BS' .$doctor_number++,
        'avatar' => 'https://i.imgur.com/CISRbZi.jpg',
        'birthday' => $faker->date($format = 'Y-m-d', $max = '1996'),
        'gender' => 'Male',
        'id_number' => $faker->numberBetween(10000000, 99999999),
        'id_number_place' => $faker->address,
        'id_number_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'passport_no' => $faker->numberBetween(100000000, 99999999),
        'passport_place' => $faker->address,
        'passport_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'phone_number' => $faker->numberBetween(11111111,999999),
        'address_id' => $faker->numberBetween(1,50),
        'fk_employee_id' => $faker->numberBetween(1,20),
        'hospital_name' => 'BV Trung Ương Huế ',
        'specialist_id' => $faker->numberBetween(2,20),
        'email' =>$faker->email,
        'sub_specialist_id' => $faker->numberBetween(2,20),
        'actived' => 1,
        'rating' => 3.2,
        'description'=> $faker->text(200),
        'experience' => $faker->text(200),
    ];
});

$factory->define(Patient::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'status' => 'offline',
        'avatar' => 'https://i.imgur.com/UqgVwRl.jpg',
        'birthday' => $faker->date($format = 'Y-m-d', $max = '1990'),
        'gender' => 'Male',
        'id_number' => $faker->numberBetween(10000000, 99999999),
        'id_number_place' => $faker->address,
        'id_number_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'phone_number' => $faker->numberBetween(11111111, 999999),
        'address_id' => $faker->numberBetween(1, 20),
        'email' => $faker->email,
    ];
});


$factory->define(Employee::class, function (Faker $faker) {
    static $employee_number = 1;
    return [
        'name' => $faker->name,
        'status' => 'offline',
        'created_by_user' => $faker->numberBetween(1, 20),
        'employee_no' => 'NV' . $employee_number++,
        'avatar' => 'https://i.imgur.com/On6cerN.jpg',
        'birthday' => $faker->date($format = 'Y-m-d', $max = '1996'),
        'gender' => 'Male',
        'id_number' => $faker->numberBetween(10000000, 99999999),
        'id_number_place' => $faker->address,
        'id_number_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'passport_no' => $faker->numberBetween(100000000, 99999999),
        'passport_place' => $faker->address,
        'passport_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'phone_number' => $faker->numberBetween(11111111, 999999),
        'fk_address_id' => $faker->numberBetween(1, 20),
        'start_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'tax_number' => 'DN:' . $faker->text($max = 100),
        'email' => $faker->email,
        'active_check' => 1,
    ];
});
$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'user_status' => 'actived',
        'email' => $faker->email,
        'password' => bcrypt('linhtinh123'),
        'usable_id' => $faker->unique()->numberBetween(1, 20),
        'usable_type' => 'App\Employee',
    ];
});

$factory->define(Certificate::class, function (Faker $faker) {
    return [
        'name' => 'Giấy chứng nhận tốt nghiệp Đại học Y Hà Nội',
        'image' => 'https://imgur.com/088eeVL',
        'description' => $faker->text(),
        'doctor_id' => $faker->unique()->numberBetween(1, 20),
    ];
});

$factory->define(Rating::class, function (Faker $faker) {
    return [
        'star' => $faker->randomFloat(null,0,5),
        'review' => 'He is nice and handsome',
        'patient_id' => $faker->numberBetween(1, 20),
        'doctor_id' => $faker->numberBetween(1, 20),
        'patient_name' => $faker->name,
        'patient_avatar' => 'https://i.imgur.com/UqgVwRl.jpg',
        'like' => 1,
    ];
});