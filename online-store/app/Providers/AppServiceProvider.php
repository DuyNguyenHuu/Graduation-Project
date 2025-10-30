<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(){
        View::composer('layouts.header', function ($view) {
        $categories = DB::table('categories')
                        ->select('*')
                        ->get();
        $view->with('getCategory', $categories);
    });
    }
}