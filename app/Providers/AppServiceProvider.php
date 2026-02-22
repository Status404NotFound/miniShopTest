<?php

namespace App\Providers;

use App\Contracts\CartStorageInterface;
use App\Services\Cart\SessionCartStorage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CartStorageInterface::class, SessionCartStorage::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
