<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MyPdfServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //registramos la clase
         \App::bind('MyPdf');
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
