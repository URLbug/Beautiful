<?php

namespace App\Modules\Admin;

use App\Interfaces\ModuleInterface;
use App\Modules\Admin\Routes\Route;

class Admin implements ModuleInterface
{
    private $name = 'Admin';
    private $version = '0.0.1';

    public function enable(): bool
    {
        return true;
    }

    public function disable(): bool
    {
        return true;
    }

    public function registerRoutes(): ModuleInterface
    {
        Route::index();

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVersion(): string
    {
        return $this->version;
    }
}