<?php

namespace App\Providers;

use App\Repositories\Eloquent\EloquentRefreshTokenRepository;
use App\Repositories\RefreshTokenRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public $bindings = [
        RefreshTokenRepository::class => EloquentRefreshTokenRepository::class
    ];

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
