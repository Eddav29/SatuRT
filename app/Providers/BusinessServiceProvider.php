<?php

namespace App\Providers;

use App\Services\Implementation\BusinessServiceImplementation;
use App\Services\BusinessService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class BusinessServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        BusinessService::class => BusinessServiceImplementation::class
    ];

    public function provides(): array
    {
        return [
            BusinessService::class
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
