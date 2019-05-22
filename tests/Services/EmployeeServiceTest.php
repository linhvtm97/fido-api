<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use App\Services\Eloquent\EmployeeService;
use Illuminate\Support\Carbon;
use App\Repositories\Eloquent\EmployeeRepository;

class EmployeeServiceTest extends TestCase
{
    use DatabaseTransactions;
    private $employeeRepository;

    private $employeeService;

    protected $faker;

    private $mock;

    public function setUp(): void
    {
        parent::setUp();
        $this->mock = App::make(EmployeeRepository::class);
        $this->employeeService = App::make(EmployeeService::class);
        // $this->employeeService = $this->mock(EmployeeService::class);
        $this->employeeRepository = $this->mock(EmployeeRepository::class);
        $this->faker = Faker\Factory::create();
        $this->initData();
    }

    public function mock($class)
    {
        $mock = \Mockery::mock($class);
        $this->app->instance($class, $mock);
        return $mock;
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function initData()
    {
        $employees = factory(\App\Models\Employee::class, 10)->create();
    }

    public function testIndexSuccess()
    {
        $employees = factory(\App\Models\Employee::class, 10)->make();
        $this->employeeRepository->shouldReceive('all')->andReturn($employees);
        $results = $this->employeeService->all();
        dd($results);
        // $this->assertEquals($employees, $results);
        // $this->assertCount($employees->count(), $results->count());
    }

    public function testListEmployeesIsEmpty()
    {
        $employees = array();
        $expected = $this->employeeRepository->shouldReceive('all')->andReturn($employees);
        $results = $this->employeeService->all();
        // $this->assertEquals($expected, $results);
    }

    public function testCreateEmployeeSuccess()
    {
        $data = [
            'name' =>  $this->faker->name,
            'id_number' =>  $this->faker->randomDigit,
            'email' => 'andriel@gmail.com',
            'avatar' => $this->faker->imageUrl(),
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
        $expected = $this->employeeRepository->shouldReceive('create')->once()->with($data)->andReturn(201);
        $results = $this->employeeService->create($data);
        // $this->assertEquals($expected, $results);
    }
    public function testCreateEmployeeFailWithNullRequired()
    {
        $data = [
            'name' =>  $this->faker->name,
            // 'id_number' =>  $this->faker->randomDigit,
            // 'email' => 'andriel@gmail.com',
            'avatar' => $this->faker->imageUrl(),
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
        $expected = $this->employeeRepository->shouldReceive('create')->once()->with($data)->andReturn(202);
        $results = $this->employeeService->create($data);
        // $this->assertEquals($expected, $results);
    }

    public function testUpdateEmployeeSuccess()
    {
        $data = [
            'name' =>  $this->faker->name,
            // 'id_number' =>  $this->faker->randomDigit,
            // 'email' => 'andriel@gmail.com',
            'avatar' => $this->faker->imageUrl(),
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
        $employee = factory(\App\Models\Employee::class)->create();
        $expected = $this->employeeRepository->shouldReceive('update')->once()->with($data, $employee->id)->andReturn(200);
        $results = $this->employeeService->update($data, $employee->id);
        // $this->assertEquals($expected, $results);
    }
    public function testDeleteEmployeeSuccess()
    {
        $employee = factory(\App\Models\Employee::class)->create();
        $expected = $this->employeeRepository->shouldReceive('delete')->once()->with($employee->id)->andReturn(200);
        $results = $this->employeeService->delete($employee->id);
        // $this->assertEquals($expected, $results);
    }
}
