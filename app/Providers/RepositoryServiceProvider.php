<?php

namespace App\Providers;

use App\Repositories\ContactRepository;
use App\Repositories\Eloquent\EloquentContactRepository;
use App\Repositories\Eloquent\EloquentHotlineRepository;
use App\Repositories\Eloquent\EloquentLocationRepository;
use App\Repositories\Eloquent\EloquentPositionRepository;
use App\Repositories\Eloquent\EloquentRefreshTokenRepository;
use App\Repositories\Eloquent\EloquentRoleRepository;
use App\Repositories\Eloquent\EloquentUserInfoRepository;
use App\Repositories\Eloquent\EloquentUserRepository;
use App\Repositories\HotlineRepository;
use App\Repositories\LocationRepository;
use App\Repositories\PositionRepository;
use App\Repositories\RefreshTokenRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserInfoRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public $bindings = [
        RefreshTokenRepository::class => EloquentRefreshTokenRepository::class,
        RoleRepository::class => EloquentRoleRepository::class,
        UserRepository::class => EloquentUserRepository::class,
        UserInfoRepository::class => EloquentUserInfoRepository::class,
        PositionRepository::class => EloquentPositionRepository::class,
        HotlineRepository::class => EloquentHotlineRepository::class,
        ContactRepository::class => EloquentContactRepository::class,
        LocationRepository::class => EloquentLocationRepository::class,
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
