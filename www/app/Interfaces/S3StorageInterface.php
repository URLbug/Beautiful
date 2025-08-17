<?php

namespace App\Interfaces;

interface S3StorageInterface
{
    static function putFile(string $path, mixed $content): bool;
    static function getFile(string $path): string|bool;
    static function deleteFile(string $path): bool;
}
