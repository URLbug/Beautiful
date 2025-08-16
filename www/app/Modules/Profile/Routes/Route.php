<?php

namespace App\Modules\Profile\Routes;

class Route extends \Illuminate\Support\Facades\Route
{
    static function index(): void
    {
        self::namespace('App\Modules\\Profile\\Controllers')
            ->middleware('auth')
            ->group(fn() => self::routers())
            ->name('profile.routes');
    }

    private static function routers(): void
    {
        self::match(
            ['get', 'patch', 'post'],
            '/profile/{username}',
            'ProfileController@index'
        )->name('profile.home');

        self::match(
            ['get', 'post'],
            '/posts/{id?}',
            'PostController@index'
        )->name('profile.posts')
        ->defaults('id', 0);

        self::post('/comment/{id?}', 'CommentController@index')
        ->name('profile.comment')
        ->defaults('id', 0);

        self::post('/search', 'SearchController@index')
        ->name('profile.search');
    }
}
