<?php

namespace App\Interfaces;

interface ModuleInterface
{
    // NOTE: enable and disable module
    public function enable(): bool;
    public function disable(): bool;

    // NOTE: registers routes, events and etc.
    public function registerRoutes(): ModuleInterface;

    // NOTE: get name, version and other about module
    public function getName(): string;
    public function getVersion(): string;
}
