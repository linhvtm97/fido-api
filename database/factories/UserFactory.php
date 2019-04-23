<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Doctor;
use Illuminate\Support\Carbon;
use App\Patient;
use App\Employee;
use App\User;
use App\Admin;

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
    return [
        'name' => $faker->name,
        'status' => 'offline',
        'doctor_no' => 'BS'. $faker->numberBetween(1000, 9999),
        'avatar' => $faker->text,
        'birthday' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'gender' => 'Male',
        'id_number' => $faker->numberBetween(10000000, 99999999),
        'id_number_place' => $faker->address,
        'id_number_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'passport_no' => $faker->numberBetween(100000000, 99999999),
        'passport_place' => $faker->address,
        'passport_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'phone_no_1' => $faker->numberBetween(11111111,999999),
        'phone_no_2' => $faker->numberBetween(11111111,999999),
        'fk_address_id' => $faker->numberBetween(0,20),
        'fk_employee_id' => $faker->numberBetween(0,20),
        'hospital_name' => 'BV' .$faker->text($max =100),
        'specialist' => $faker->text($max=100),
        'email' =>$faker->email,
    ];
});

$factory->define(Patient::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'status' => 'offline',
        'avatar' => $faker->text,
        'birthday' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'gender' => 'Male',
        'id_number' => $faker->numberBetween(10000000, 99999999),
        'id_number_place' => $faker->address,
        'id_number_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'phone_no_1' => $faker->numberBetween(11111111,999999),
        'phone_no_2' => $faker->numberBetween(11111111,999999),
        'fk_address_id' => $faker->numberBetween(0,20),
        'email' =>$faker->email,
    ];
});


$factory->define(Employee::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'status' => 'offline',
        'created_by_user' => $faker->numberBetween(1,50),
        'employee_no' => 'NV'. $faker->numberBetween(1000, 9999),
        'avatar' => $faker->text,
        'birthday' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'gender' => 'Male',
        'id_number' => $faker->numberBetween(10000000, 99999999),
        'id_number_place' => $faker->address,
        'id_number_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'passport_no' => $faker->numberBetween(100000000, 99999999),
        'passport_place' => $faker->address,
        'passport_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'phone_no_1' => $faker->numberBetween(11111111,999999),
        'phone_no_2' => $faker->numberBetween(11111111,999999),
        'fk_address_id' => $faker->numberBetween(0,20),
        'start_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'tax_number' => 'DN:'.$faker->text($max=100),
        'email' =>$faker->email,
        'active_check' => 1,
    ];
});
$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'user_status' => 'actived',
        'email' =>$faker->email,
        'password' => bcrypt('linhtinh123'),
        'verified' => 1,
        'usable_id'=>$faker->unique()->numberBetween(1,50),
        'usable_type'=>'App\Admin',
    ];
});

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => '',
        'phone_number' =>$faker->phoneNumber,
        'email' => $faker->email,
    ];
});