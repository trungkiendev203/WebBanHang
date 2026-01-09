<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;


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
    public function boot()
{
    View::composer('*', function ($view) {
        $eventHeader = DB::table('tb_event')
            ->where('status', 1)
            ->where('position', 'header')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderByDesc('id_event')
            ->first();

        $view->with('eventHeader', $eventHeader);
    });
}

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
}
