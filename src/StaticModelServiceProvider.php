<?php

namespace Exolnet\StaticModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class StaticModelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        Model::macro('')
    }
}
