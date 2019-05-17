<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;

class EventRepositoryTest extends TestCase
{
    use DatabaseTransactions;
    
    private $eventRepository;
    
    private $events;
    
    private $urlRecommend = 'v1/me/event/recommend';
    
    private $urlEventDetail = 'v1/event/1';
    
    private $user;
    
    private $type;
    /**
     * Mocked version of the primary repo.
     */
    protected $mock;
    
    protected $faker;
                  
    private $urlParticipation = 'v1/me/event/participation';
    
    private $urlSearch = 'v1/event/search';
    private $urlCreate = 'v1/event';
    
    protected function setUp() {
        parent::setUp();
        $this->eventRepository = App::make('App\Repositories\EventRepository');
        $this->faker = Faker\Factory::create();
        $this->mock =  $this->mock('App\Repositories\EventRepository');
    }

    public function mock($class)
    {
        $mock = Mockery::mock($class);
        $this->app->instance($class, $mock);
        return $mock;
    }
    /**
     * Test join event false
     */
    public function testJoinEventModelNotFoundException()
    {
        $user = factory(\App\Models\User::class)->create();
        $this->be($user, 'api');
        $this->setExpectedException('Illuminate\Database\Eloquent\ModelNotFoundException');
        $result = $this->eventRepository->join(0);
        $this->mock->shouldReceive('join')->andReturn($result);
    } 
    
      /**
     * Test leave event InvalidArgumentException
     */
    public function testLeaveEventInvalidArgumentException()
    {
        $user = factory(\App\Models\User::class)->create();
        $event =  factory(\App\Models\Event::class)->create();
        $this->be($user, 'api');
        $this->setExpectedException('InvalidArgumentException');
        $result = $this->eventRepository->leave($event->id);
        $this->mock->shouldReceive('leave')->andReturn($result);
      
    }
    /**
     * Test leave event ModelNotFoundException
     */
    public function testLeaveEventModelNotFoundException()
    {
        $user = factory(\App\Models\User::class)->create();
        $this->be($user, 'api');
        $this->setExpectedException('Illuminate\Database\Eloquent\ModelNotFoundException');
        $result = $this->eventRepository->leave(0);
        $this->mock->shouldReceive('leave')->andReturn($result);
    }
    
     /**
     * Test Favourite event InvalidArgumentException
     */
    public function testFavouriteEventInvalidArgumentException()
    {
        $user = factory(\App\Models\User::class)->create();
        $event =  factory(\App\Models\Event::class)->create();
        $this->be($user, 'api');
        $event->favouriteUsers()->attach($user->id);
        $this->setExpectedException('InvalidArgumentException');
        $result = $this->eventRepository->addFavourite($event->id, $user);
        $this->mock->shouldReceive('addFavourite')->andReturn($result);
      
    }
    /**
     * Favourite event ModelNotFoundException
     */
    public function testFavouriteEventModelNotFoundException()
    {
        $user = factory(\App\Models\User::class)->create();
        $this->be($user, 'api');
        $this->setExpectedException('Illuminate\Database\Eloquent\ModelNotFoundException');
        $result = $this->eventRepository->addFavourite(0, $user);
        $this->mock->shouldReceive('addFavourite')->andReturn($result);
    } 
    
    /**
     * Test remove favourite event InvalidArgumentException
     */
    public function testRemoveFavouriteEventInvalidArgumentException()
    {
        $user = factory(\App\Models\User::class)->create();
        $event =  factory(\App\Models\Event::class)->create();
        $this->be($user, 'api');
        $this->setExpectedException('InvalidArgumentException');
        $result = $this->eventRepository->removeFavourite($event->id, $user->id);
        $this->mock->shouldReceive('removeFavourite')->andReturn($result);
      
    }
    /**
     * Test remove favourite event ModelNotFoundException
     */
    public function testRemoveFavouriteEventModelNotFoundException()
    {
        $user = factory(\App\Models\User::class)->create();
        $this->be($user, 'api');
        $this->setExpectedException('Illuminate\Database\Eloquent\ModelNotFoundException');
        $result = $this->eventRepository->removeFavourite(0, $user->id);
        $this->mock->shouldReceive('removeFavourite')->andReturn($result);
    } 
    
}
