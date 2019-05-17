<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories\EmployeeServices;
use Symfony\Component\HttpFoundation\Response;

class EmployeeControllerTest extends TestCase
{
    use DatabaseTransactions;
    private $employeeService;
    private $employeeRepository;

    private $urlApi = '/employees';
    
    private $user;
    
    protected $faker;
    
    private $mock;
    
    protected function setUp() 
    {
        parent::setUp();  
        $this->mock = App::make('App\Repositories\Eloquent\EmployeeRepository');
        $this->employeeService = $this->mock('App\Repositories\Eloquent\EmployeeRepository');
        $this->mock = App::make('App\Repositories\Eloquent\EmployeeService');
        $this->employeeRepository = $this->mock('App\Services\Eloquent\EmployeeService');
        $this->faker = Faker\Factory::create();
        $this->initData();
    }
    
    public function mock($class)
    {
        $mock = Mockery::mock($class);
        $this->app->instance($class, $mock);
        return $mock;
    }

    protected function tearDown() 
    {
        Mockery::close();
        parent::tearDown();
    }
    
    public function initData()
    {
        $employees = factory(\App\Models\Employee::class, 10)->create();
        $this->user = factory(\App\User::class)->create();
        
    }
    
    public function testIndexSuccess()
    {
        $employees = factory(\App\Models\Employee::class, 10)->make();
        $this->employeeService->shouldReceive('all')->once()->andReturn($employees);
        $response = $this->call('GET', $this->urlApi);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->seeJsonStructure([
                 'Message',
                 'Data' => [
                 ]
             ]);       
    }
       
    public function testListEmployeesIsEmpty()
    {
        $employees = array();
        $this->employeeService->shouldReceive('all')->andReturn($employees);
        $response = $this->call('GET', $this->urlApi);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->seeJsonStructure([
                 'Message',
                 'Data' => [
                     
                 ]
             ]);
    }

    
}
