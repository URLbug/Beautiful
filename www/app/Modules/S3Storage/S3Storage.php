<?php

namespace App\Modules\S3Storage;

use App\Interfaces\ModuleInterface;
use App\Modules\S3Storage\Routes\Route;

class S3Storage implements ModuleInterface
{
    private $name = 'S3Storage';
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
