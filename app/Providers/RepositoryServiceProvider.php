<?php

namespace App\Providers;

use App\Repositories\ContactRepository;
use App\Repositories\Eloquent\EloquentContactRepository;
use App\Repositories\Eloquent\EloquentHotlineRepository;
use App\Repositories\Eloquent\EloquentLocationRepository;
use App\Repositories\Eloquent\EloquentPositionRepository;
use App\Repositories\Eloquent\EloquentRefreshTokenRepository;
use App\Repositories\Eloquent\EloquentRequestRepository;
use App\Repositories\Eloquent\EloquentRequestTypeRepository;
use App\Repositories\Eloquent\EloquentRoleRepository;
use App\Repositories\Eloquent\EloquentUserInfoRepository;
use App\Repositories\Eloquent\EloquentUserRepository;
use App\Repositories\HotlineRepository;
use App\Repositories\LocationRepository;
use App\Repositories\PositionRepository;
use App\Repositories\RefreshTokenRepository;
use App\Repositories\RequestRepository;
use App\Repositories\RequestTypeRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserInfoRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public $bindings = [
        ContactRepository::class => EloquentContactRepository::class,
        HotlineRepository::class => EloquentHotlineRepository::class,
        LocationRepository::class => EloquentLocationRepository::class,
        PositionRepository::class => EloquentPositionRepository::class,
        RefreshTokenRepository::class => EloquentRefreshTokenRepository::class,
        RoleRepository::class => EloquentRoleRepository::class,
        RequestRepository::class => EloquentRequestRepository::class,
        RequestTypeRepository::class => EloquentRequestTypeRepository::class,
        UserInfoRepository::class => EloquentUserInfoRepository::class,
        UserRepository::class => EloquentUserRepository::class,
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
