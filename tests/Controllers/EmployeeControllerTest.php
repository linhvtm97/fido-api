<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use App\Services\Eloquent\EmployeeService;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\Constraint\Exception;

class EmployeeControllerTest extends TestCase
{
    use DatabaseTransactions;
    private $employeeService;

    private $urlApi = '/api/v1/employees/';

    protected $faker;

    private $mock;

    public function setUp(): void
    {
        parent::setUp();
        $this->mock = App::make(EmployeeService::class);
        $this->employeeService = $this->mock(EmployeeService::class);
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

    public function testControllerIndexSuccess()
    {
        $employees = factory(\App\Models\Employee::class, 10)->make();
        $this->employeeService->shouldReceive('all')->andReturn($employees);
        $response = $this->call('GET', $this->urlApi);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testControllerListEmployeesIsEmpty()
    {
        $employees = array();
        $this->employeeService->shouldReceive('all')->andReturn($employees);
        $response = $this->call('GET', $this->urlApi);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testControllerCreateEmployeeSuccess()
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
        $this->employeeService->shouldReceive('create')->once()->with($data)->andReturn(201);
        $response = $this->call('POST', $this->urlApi, $data);
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }
    public function testControllerCreateEmployeeFailWithNullRequired()
    {
        $data = [
            'name' =>  $this->faker->name,
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
        $this->employeeService->shouldReceive('create')->once()->with($data)->andThrow(new \Exception(), 422);
        $response = $this->call('POST', $this->urlApi, $data);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    public function testControllerUpdateEmployeeSuccess()
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
        $employee = factory(\App\Models\Employee::class)->create();
        $this->employeeService->shouldReceive('update')->once()->with($data, $employee->id)->andReturn(200);
        $response = $this->call('PUT', $this->urlApi . $employee->id, $data);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
    public function testControllerDeleteEmployeeSuccess()
    {
        $employee = factory(\App\Models\Employee::class)->create();
        $this->employeeService->shouldReceive('delete')->once()->andReturn(200);
        $response = $this->call('DELETE', $this->urlApi . $employee->id);
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }
    public function testControllerDeleteEmployeeFailWithIDNotFound()
    {
        $this->employeeService->shouldReceive('delete')->once()->andThrow(new \Exception(), 404);
        $response = $this->call('DELETE', $this->urlApi . 56);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
