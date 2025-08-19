<?php

namespace App\Modules\Master;

use App\Interfaces\ModuleInterface;
use App\Modules\Master\Routes\Route;

class Master implements ModuleInterface
{
    private $name = 'Master';
    private $version = '0.0.2';

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
