<?php

namespace App\Providers;

use App\Repository\CurrencyRepository;
use App\Repository\EloquentCurrencyRepository;
use Illuminate\Support\ServiceProvider;

class CurrencyRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CurrencyRepository::class, EloquentCurrencyRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
