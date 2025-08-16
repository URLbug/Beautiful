<?php

namespace App\Modules\Auth;

use App\Interfaces\ModuleInterface;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use App\Modules\Auth\Routes\Route;

class Auth implements ModuleInterface
{
    private $name = 'Auth';
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
