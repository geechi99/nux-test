<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\LinkService;
use App\Services\Contracts\LinkServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LinkServiceInterface::class, LinkService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
