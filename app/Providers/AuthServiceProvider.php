<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\Favorite;
use App\Policies\BookingPolicy;
use App\Policies\FavoritePolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Booking::class => BookingPolicy::class,
        Favorite::class => FavoritePolicy::class,
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
