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
