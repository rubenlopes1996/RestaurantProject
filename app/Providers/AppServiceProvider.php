<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Resources\UserResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //UserResource::withoutWrapping();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
