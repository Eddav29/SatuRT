<?php

namespace App\Providers;

use App\Services\HomeService;
use App\Services\Implementation\HomeServiceImplementation;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class HomeServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        HomeService::class => HomeServiceImplementation::class
    ];
    public function provides(): array
    {
        return [
            HomeService::class
        ];
    }
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
