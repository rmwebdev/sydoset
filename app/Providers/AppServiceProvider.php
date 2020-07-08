<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use App\mst_menu;
use Schema;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        View::composer('*', function($view)
        {
            $menu = Session::get('menu');

            $view->with('menu', $menu);
        });

        config(['app.locale' => 'id']);
        \Carbon\Carbon::setLocale('id');

        
    }
}
