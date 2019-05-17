<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;

class UserRepositoryTest extends TestCase
{
    use DatabaseTransactions;
    
    private $userRepository;
    
    private $androidDeviceToken = 'c0cqXb-Ftm8:APA91bFzRnj4QYi_hJvMuCDTgRGHEr3LcRlh5POSptu9PuTO5WfYbdrKdJlhi0XciLvUKp3gJf3gWBks_zHJSl5fAONMXIsXcTEgS0coNvsWnNR2eJI8E9LUyP5YYF6teNMqKI2psuPs';
    
    private $iosDeviceToken = 'bd6bfc4a16dd460577ecbcfc1050af68597792e1b01377b2e92ba5b5747e3668';
    
    private $testPassword = 123456;
    /**
     * Mocked version of the primary repo.
     */
    protected $mock;
    
    protected $faker;
                  
    protected function setUp() {
        parent::setUp();
        $this->userRepository = App::make('App\Repositories\UserRepository');
        $this->faker = Faker\Factory::create();
        $this->mock =  $this->mock('App\Repositories\UserRepository');
    }

    public function mock($class)
    {
        $mock = Mockery::mock($class);
        $this->app->instance($class, $mock);
        return $mock;
    }
     /**
     * login by Email has InvalidArgumentException exception
     */
    public function testLoginByEmailInvalidArgumentException()
    {
        $user = factory(\App\Models\User::class)->create();
        $credential = [
            'device_token' => $this->androidDeviceToken,
            'device_type' => 2,
            'email' => $user->email,
            'password' => $user->password.'wrong'
        ];
        $request = Request::instance();
        $request->merge($credential);
        $this->setExpectedException('InvalidArgumentException');
        $result = $this->userRepository->getByCredential($request);
        $this->mock->shouldReceive('getByCredential')->andReturn($result);
      
    }
    /**
     * login by Email has Exception
     */
    public function testLoginByEmailException()
    {
        $user = factory(\App\Models\User::class)->create(['password' => Hash::make($this->testPassword)]);
        $credential = [
            'device_token' => $this->androidDeviceToken,
            'device_type' => 3,
            'email' => $user->email,
            'password' => $this->testPassword
        ];
        $request = Request::instance();
        $request->merge($credential);
        $this->setExpectedException('Exception');
        $result = $this->userRepository->getByCredential($request);
        $this->mock->shouldReceive('getByCredential')->andReturn($result);
    } 
}
