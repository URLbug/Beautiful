<?php

namespace App\Modules\Search\Routes;

class Route extends \Illuminate\Support\Facades\Route
{
    static function index(): void
    {
        self::namespace('App\Modules\\Search\\Controllers')
            ->middleware('auth')
            ->group(fn() => self::routers())
            ->name('search.routes');
    }

    private static function routers(): void
    {
        self::post('/search', 'SearchController@index')
            ->name('search.home');
    }
}
