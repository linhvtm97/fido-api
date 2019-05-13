<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Faker\Factory as Faker;
use Carbon\Carbon;
use App\Employee;

class EmployeeControllerTest extends TestCase
{

    /**
     * Test index function success
     */
    public function testIndexSuccessWithHasData()
    {
        Artisan::call('db:seed --class=EmployeeSeeder');
        $employeeControler = new EmployeeController();
        $response = $employeeControler->index();
        $this->assertEquals(200, $response->getStatusCode());
        $data = (array) $response->getData();
        $this->assertArrayHasKey('data', $data);
        //check orderby
        $items = $data['data'];
        for($i = 0; $i < count($items) - 1; $i++) {
            $item = $items[$i];
            $nextItem = $items[$i+1];
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
        $request = Request::create('/employees', 'POST',$data);
        $employeeControler = new EmployeeController();
        $response = $employeeControler->store($request);
        $this->assertEquals(201, $response->getStatusCode());
        //check in database
        $employee = Employee::where('email', $data['email'])->first();
        $this->assertNotNull($employee);
        $this->assertEquals($data['name'], $employee->name);
    }
}
