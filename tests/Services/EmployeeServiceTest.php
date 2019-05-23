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

    public function testServiceIndexSuccess()
    {
        $employees = factory(\App\Models\Employee::class, 10)->create();
        $this->employeeRepository->shouldReceive('all')->andReturn($employees);
        $results = $this->employeeService->all();
        $this->assertEquals($employees->count(), $results->count());
    }

    public function testServiceListEmployeesIsEmpty()
    {
        $employees = array();
        $this->employeeRepository->shouldReceive('all')->andReturn($employees);
        $results = $this->employeeService->all();
        $this->assertEquals(0, $results->count());
    }

    public function testServiceCreateEmployeeSuccess()
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
        $employee = factory(\App\Models\Employee::class)->make($data);
        $this->employeeRepository->shouldReceive('create')->with($data)->andReturn(true);
        $results = $this->employeeService->create($data);
        $this->assertTrue($results);
    }
    public function testServiceCreateEmployeeFailWithNullRequired()
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
        $this->employeeRepository->shouldReceive('create')->with($data)->andThrow(new \Exception, 422)->andReturn(false);        
        $results = $this->employeeService->create($data);
    }

    public function testServiceUpdateEmployeeSuccess()
    {
        $data = [
            'name' =>  $this->faker->name,
        ];
        $employee = factory(\App\Models\Employee::class)->create();
        $employee->name = $data['name'];
        $employee->save();
        $this->employeeRepository->shouldReceive('update')->with($data, $employee->id)->andReturn(true);
        $results = $this->employeeService->update($data, $employee->id);
        $this->assertTrue($results);
    }
    public function testServiceDeleteEmployeeSuccess()
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
        $this->employeeRepository->shouldReceive('delete')->with($employee->id)->andReturn(true);
        $results = $this->employeeService->delete($employee->id);
        $this->assertTrue($results);
    }
}
