<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\RepositoryInterface;
use App\Repositories\Eloquent\EmployeeRepository;
use App\Services\Eloquent\EmployeeService;
use App\Services\Interfaces\EmployeeServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            RepositoryInterface::class,
            EmployeeRepository::class
        );
        $this->app->bind(
            EmployeeServiceInterface::class,
            EmployeeService::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
