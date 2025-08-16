<?php

namespace App\Modules\Search;

use App\Interfaces\ModuleInterface;
use App\Modules\Search\Routes\Route;

class Search implements ModuleInterface
{
    private $name = 'Search';
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