<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Setup enviroment function
     */
    function setUp():void
    {
        parent::setUp();
        Artisan::call('migrate:fresh');
    }

    public function tearDown():void
    {
        Cache::flush();
        \Mockery::close();
        parent::tearDown();
    }
}
