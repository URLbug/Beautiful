<?php

namespace App\Modules\Master\Routes;

class Route extends \Illuminate\Support\Facades\Route
{
    static function index(): void
    {
        self::namespace('App\Modules\Master\Controllers')
            ->group(fn() => self::routers())
            ->name('master.routes');
    }

    private static function routers(): void
    {
        Route::get('/', function(){
            return 'test';
        })->name('master.home');
    }
}
