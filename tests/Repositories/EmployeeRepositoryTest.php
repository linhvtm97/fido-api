<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Support\Carbon;
use App\Repositories\Eloquent\EmployeeRepository;

class EmployeeRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected $faker;
    protected $employeeRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->employeeRepository = App::make(EmployeeRepository::class);
        $this->faker = Faker\Factory::create();
    }

    public function testRepositoryIndexSuccess()
    {
        $employees = factory(\App\Models\Employee::class, 10)->create();
        $results = $this->employeeRepository->all();
        $this->assertEquals($employees->count(), $results->count());
    }

    public function testRepositoryListEmployeesIsEmpty()
    {
        $results = $this->employeeRepository->all();
        $this->assertEquals(0, $results->count());
    }

    public function testRepositoryCreateEmployeeSuccess()
    {
        $data = [
            'name' =>  $this->faker->name,
            'id_number' =>  $this->faker->randomDigit,
            'email' => 'andriel@gmail.com',
            'id_number' => 123456432,
            'birthday' => Carbon::now(),
            'gender' => 'male',
            'id_number_place' => "Công an Thành Phố Đà Nẵng",
            'id_number_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'passport_no' => $this->faker->numberBetween(100000000, 99999999),
            'passport_place' => "Công an Thành Phố Đà Nẵng",
            'passport_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'phone_number' => $this->faker->numberBetween(0111111111, 999999999),
            'address_id' => $this->faker->numberBetween(1, 20),
            'address_details' => 'Đường Nguyễn Tất Thành, Hoà Khánh Bắc, Liên Chiểu',
            'start_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'tax_number' => 'DN:' . $this->faker->text($max = 100),
            'active_check' => 1,
        ];
        $results = $this->employeeRepository->create($data);
        $this->assertTrue($results);
    }
    public function testRepositoryCreateEmployeeFailWithNullRequired()
    {
        $data = [
            'name' =>  $this->faker->name,
            'birthday' => Carbon::now(),
            'gender' => 'male',
            'id_number_place' => "Công an Thành Phố Đà Nẵng",
            'id_number_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'passport_no' => $this->faker->numberBetween(100000000, 99999999),
            'passport_place' => "Công an Thành Phố Đà Nẵng",
            'passport_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'phone_number' => $this->faker->numberBetween(0111111111, 999999999),
            'address_id' => $this->faker->numberBetween(1, 20),
            'address_details' => 'Đường Nguyễn Tất Thành, Hoà Khánh Bắc, Liên Chiểu',
            'start_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'tax_number' => 'DN:' . $this->faker->text($max = 100),
            'active_check' => 1,
        ];

        $this->expectException("Exception");
        $this->expectExceptionCode(422);
        $results = $this->employeeRepository->create($data);
    }

    public function testRepositoryUpdateEmployeeSuccess()
    {
        $data = [
            'name' =>  $this->faker->name,
        ];
        $employee = factory(\App\Models\Employee::class)->create();
        $employee->name = $data['name'];
        $employee->save();
        $results = $this->employeeRepository->update($data, $employee->id);
        $this->assertTrue($results);
    }
    public function testRepositoryDeleteEmployeeSuccess()
    {
        $employee = factory(\App\Models\Employee::class)->create();
        $user = factory(App\User::class)->create([
            'name' => $this->faker->name,
            'user_status' => 'actived',
            'email' => $this->faker->email,
            'password' => bcrypt('linhtinh123'),
            'usable_id' => $employee->id,
            'usable_type' => 'App\Employee',
        ]);
        $results = $this->employeeRepository->delete($employee->id);
        $this->assertTrue($results);
    }
}
