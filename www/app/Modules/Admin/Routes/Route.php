<?php

namespace App\Modules\Admin\Routes;

use App\Modules\Admin\Middleware\PremisonalRole;

class Route extends \Illuminate\Support\Facades\Route
{
    static function index(): void
    {
        self::namespace('App\Modules\\Admin\\Controllers')
            ->middleware(['auth', PremisonalRole::class])
            ->prefix('admin')
            ->group(fn() => self::routers())
            ->name('admin.routes');
    }

    private static function routers(): void
    {
        self::get('/', function(){
            return view('admin.index');
        });

        self::get('/users', function(){
            return view('admin.index');
        });

        self::get('/roles', function(){
            return view('admin.index');
        });

        self::get('/post', function(){
            return view('admin.index');
        });

        self::get('/comments', function(){
            return view('admin.index');
        });
    }
}
