<?php

$master = new \App\Modules\Master\Master;
$auth = new \App\Modules\Auth\Auth;
$profile = new \App\Modules\Profile\Profile;

$master->registerRoutes()
    ->enable();

$auth->registerRoutes()
    ->enable();

$profile->registerRoutes()
    ->enable();

//
//    Route::middleware('auth')
//    ->group(function() {
//        Route::match(
//            ['get', 'patch', 'post'],
//            '/profile/{username}',
//            'Profile\ProfileController@index'
//        )->name('profile');
//
//        Route::match(
//            ['get', 'post'],
//            '/posts/{id?}',
//            'Post\PostController@index'
//        )->name('posts')
//        ->defaults('id', 0);
//
//        Route::post('/comment/{id?}', 'Post\CommentController@index')
//        ->name('comment')
//        ->defaults('id', 0);
//
//        Route::post('/search', 'Search\SearchController@index')
//        ->name('search');
//
//        Route::get('/logout', 'Auth\LoginController@logout')
//        ->name('logout');
//    });
//});
//Auth::routes();
