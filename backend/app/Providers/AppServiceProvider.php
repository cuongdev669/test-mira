<?php

namespace App\Providers;

use App\Services\SerialPasoService;
use App\Services\SerialPasoServiceInterface;
use App\Services\StudentStatService;
use App\Services\StudentStatServiceInterface;
use App\Services\CityService;
use App\Services\CityServiceInterface;
use Illuminate\Support\ServiceProvider;
use App\Services\TestServiceInterface;
use App\Services\TestService;
use App\Services\AccountServiceInterface;
use App\Services\AccountService;
use App\Repositories\AccountRepositoryInterface;
use App\Repositories\AccountRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TestServiceInterface::class, TestService::class);
        $this->app->singleton(AccountServiceInterface::class, AccountService::class);
        $this->app->singleton(AccountRepositoryInterface::class, AccountRepository::class);
        $this->app->singleton(SerialPasoServiceInterface::class, SerialPasoService::class);
        $this->app->singleton(StudentStatServiceInterface::class, StudentStatService::class);
        $this->app->singleton(CityServiceInterface::class, CityService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
