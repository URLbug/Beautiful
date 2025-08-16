<?php

namespace App\Modules\Auth\Routes;

use App\Modules\Auth\Controllers\RegistrationController;

class Route extends \Illuminate\Support\Facades\Route
{
    static function index(): void
    {
        self::namespace('App\Modules\\Auth\\Controllers')
            ->group(fn() => self::routers())
            ->name('auth.routes');
    }

    private static function routers(): void
    {
        // NOTE: name route is login because middleware auth
        // "Laravel 11" send errors if router with name login not found
        self::match(
            ['get', 'post'],
            '/login',
            'LoginController@index'
        )->name('login');

        self::middleware('auth')
            ->get('/logout', function() {
                auth()->logout();

                return redirect()->route('master.home');
            })
            ->name('auth.logout');

        self::match(
            ['get', 'post',],
            '/registration',
            function() {
                if(auth()->check()) {
                    return redirect()
                        ->route('master.home')
                        ->with('success', 'You are already logged in.');
                }

                return (new RegistrationController)->index(request());
            },
        )->name('auth.registration');
    }
}
