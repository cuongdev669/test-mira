<?php

namespace App\Providers;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
