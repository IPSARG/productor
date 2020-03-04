<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        require_once app_path() . '/Helpers/CheckDispatch.php';
        require_once app_path() . '/Helpers/Breadcrumb.php';
        require_once app_path() . '/Helpers/IsCoefi.php';
    }
}
