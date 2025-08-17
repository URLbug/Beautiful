<?php

$master = new \App\Modules\Master\Master;
$auth = new \App\Modules\Auth\Auth;
$profile = new \App\Modules\Profile\Profile;
$search = new \App\Modules\Search\Search;

$master->registerRoutes()
    ->enable();

$auth->registerRoutes()
    ->enable();

$profile->registerRoutes()
    ->enable();

$search->registerRoutes()
    ->enable();
