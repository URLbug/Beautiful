<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::namespace('App\Http\Controllers')
->group(function() {
    Route::get('/', function(){
        return !auth()->check() 
        ? view('index') 
        : redirect()->route('profile', [
            'username' => auth()->user()->username,
        ]);
    })->name('home');

    Route::match(
        ['get', 'post'],
        '/login',
        'Auth\LoginController@index'
    )->name('login');

    Route::match(
        ['get', 'post',],
        '/regs',
        'Auth\RegsController@index',
    )->name('regs');

    Route::middleware('auth')
    ->group(function() {
        Route::match(
            ['get', 'patch', 'post'],
            '/profile/{username}', 
            'Profile\ProfileController@index'
        )->name('profile');
        
        Route::match(
            ['get', 'post'],
            '/posts/{id?}', 
            'Post\PostController@index'
        )->name('posts')
        ->defaults('id', 0);

        Route::post('/comment/{id?}', 'Post\CommentController@index')
        ->name('comment')
        ->defaults('id', 0);

        Route::post('/search', 'Search\SearchController@index')
        ->name('search');

        Route::get('/logout', 'Auth\LoginController@logout')
        ->name('logout');
    });
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
