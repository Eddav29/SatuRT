<?php

namespace App\Providers;

use App\Services\Implementation\BusinessServiceImplementation;
use App\Services\Implementation\NewsServiceImplementation;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        'business_service' => BusinessServiceImplementation::class,
        'news_service' => NewsServiceImplementation::class
    ];

    public function provides(): array
    {
        return [
            'business_service',
            'news_service'
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
