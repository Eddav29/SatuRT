<?php

namespace App\Providers;

use App\Services\Implementation\NewsServiceImplementation;
use App\Services\NewsService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class NewsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        NewsService::class => NewsServiceImplementation::class,
    ];

    public function provides(): array
    {
        return [NewsService::class];
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
