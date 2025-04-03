<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\TestServiceInterface;
use App\Services\TestService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TestServiceInterface::class, TestService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
