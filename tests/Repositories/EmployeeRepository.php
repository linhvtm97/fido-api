<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Support\Carbon;

class EmployeeServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $faker;


    /**
     * Test index function success
     */
    public function testIndexSuccessWithHasData()
    {
        Artisan::call('db:seed --class=EmployeeSeeder');
        $employeeControler = new EmployeeController();
        $response = $employeeControler->index();
        $this->assertEquals(200, $response->getStatusCode());
        $data = (array)$response->getData();
        $this->assertArrayHasKey('data', $data);
        //check orderby
        $items = $data['data'];
        for ($i = 0; $i < count($items) - 1; $i++) {
            $item = $items[$i];
            $nextItem = $items[$i + 1];
            $this->assertGreaterThan($item->id, $nextItem->id);
        }
    }

    /**
     * Test index function success
     */
    public function testIndexSuccessWithoutData()
    {
        $employeeControler = new EmployeeController();
        $response = $employeeControler->index();
        $this->assertEquals(204, $response->getStatusCode());
        $data = $response->getData();
        $this->assertEquals("No content", $data->message);
    }

    /**
     * Test store function success
     */
    public function testStoreSuccess()
    {
        $faker = Faker::create();
        $data = [
            'name' =>  $faker->name,
            'id_number' =>  $faker->randomDigit,
            'email' => $faker->email,
            'avatar' => $faker->imageUrl(),
            'birthday' => Carbon::now(),
            'gender' => 'male',
            'id_number_place' => "Công an Thành Phố Đà Nẵng",
            'id_number_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
            'passport_no' => $faker->numberBetween(100000000, 99999999),
            'passport_place' => "Công an Thành Phố Đà Nẵng",
            'passport_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
            'phone_number' => $faker->numberBetween(0111111111, 999999999),
            'address_id' => $faker->numberBetween(1, 20),
            'address_details' => 'Đường Nguyễn Tất Thành, Hoà Khánh Bắc, Liên Chiểu',
            'start_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
            'tax_number' => 'DN:' . $faker->text($max = 100),
            'active_check' => 1,
        ];
        $request = Request::create('/employees', 'POST', $data);
        $employeeControler = new EmployeeController();
        $response = $employeeControler->store($request);
        $this->assertEquals(201, $response->getStatusCode());
        //check in database
        $employee = Employee::where('email', $data['email'])->first();
        $this->assertNotNull($employee);
        $this->assertEquals($data['name'], $employee->name);
    }

    /**
     * Test store function fail with null required fields
     */
    public function testStoreFailWithNullRequired()
    {
        $faker = Faker::create();
        $data = [
            'id_number' =>  $faker->randomDigit,
            'avatar' => $faker->imageUrl(),
            'birthday' => Carbon::now(),
            'gender' => 'male',
            'id_number_place' => "Công an Thành Phố Đà Nẵng",
            'id_number_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
            'passport_no' => $faker->numberBetween(100000000, 99999999),
            'passport_place' => "Công an Thành Phố Đà Nẵng",
            'passport_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
            'phone_number' => $faker->numberBetween(0111111111, 999999999),
            'address_id' => $faker->numberBetween(1, 20),
            'address_details' => 'Đường Nguyễn Tất Thành, Hoà Khánh Bắc, Liên Chiểu',
            'start_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
            'tax_number' => 'DN:' . $faker->text($max = 100),
            'active_check' => 1,
        ];
        $request = Request::create('/employees', 'POST', $data);
        $employeeControler = new EmployeeController();
        $response = $employeeControler->store($request);
        $this->assertEquals(202, $response->getStatusCode());
    }
    /**
     * Test show function success
     */
    public function testShowSuccess()
    {
        $test = factory(Employee::class, 1)->create();
        $employeeControler = new EmployeeController();
        $response = $employeeControler->show($test->first()->id);
        $this->assertEquals(200, $response->getStatusCode());
    }
    /**
     * Test show function fail with ID not found
     */
    public function testShowFailWithIdNotFound()
    {
        $employeeControler = new EmployeeController();
        $response = $employeeControler->show(1111111);
        $this->assertEquals(404, $response->getStatusCode());
    }
    /**
     * Test delete function success
     */
    public function testDeleteSuccess()
    {
        $test = factory(Employee::class, 1)->create();
        $user = factory(User::class)->create([
            'usable_id' => $test->first()->id,
            'usable_type' => 'App\\Employee',
            'email' => $test->first()->email,
            'password' => 'linhtinh123',
            'name' => $test->first()->name,
        ]);
        $employeeControler = new EmployeeController();
        $response = $employeeControler->destroy($test->first()->id);
        $this->assertEquals(204, $response->getStatusCode());
    }
    /**
     * Test show function fail with ID not found
     */
    public function testDeleteFailWithIdNotFound()
    {
        $employeeControler = new EmployeeController();
        $response = $employeeControler->destroy(11111111);
        $this->assertEquals(404, $response->getStatusCode());
    }
}
