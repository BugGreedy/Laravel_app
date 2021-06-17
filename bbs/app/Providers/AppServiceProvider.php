<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // 下記を追記
        // \URL::forceScheme('https');
        // さらに追記
        \URL::forceScheme('http'); //https → httpにした
        // 後から捕捉
    }
}