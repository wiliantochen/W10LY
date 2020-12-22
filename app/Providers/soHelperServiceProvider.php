<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class soHelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->loadHelpers();
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

    protected function loadHelpers() {
        foreach (glob(__DIR__.'/../soHelpers/*.php') as $filename) {
            require_once $filename;
        }
        /*
            Di Folder App
            Harus tambahain Folder soHelpers
            Jadi semua file yang ada di folder soHelpers akan selalu diload
        */
    }
        

}

    /**
     * ========================================================================================================
     * Note Buatan Sendiri
     * ========================================================================================================
     * php artisan make:provider WilEdiHelperServiceProvider
     * Kemudian Config\app.php
     * tambahin App\Providers\WilEdiHelperServiceProvider::class,
     * Kemudian harus jalanin php artisan config:cache --env:MySql
     * ========================================================================================================
     */

