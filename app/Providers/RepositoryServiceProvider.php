<?php

namespace App\Providers;

use App\Repositories\Eloquent\EloquentPositionRepository;
use App\Repositories\Eloquent\EloquentRefreshTokenRepository;
use App\Repositories\Eloquent\EloquentUserInfoRepository;
use App\Repositories\Eloquent\EloquentUserRepository;
use App\Repositories\PositionRepository;
use App\Repositories\RefreshTokenRepository;
use App\Repositories\UserInfoRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public $bindings = [
        RefreshTokenRepository::class => EloquentRefreshTokenRepository::class,
        UserRepository::class => EloquentUserRepository::class,
        UserInfoRepository::class => EloquentUserInfoRepository::class,
        PositionRepository::class => EloquentPositionRepository::class,
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
