<?php

namespace App\Owners;

use Illuminate\Support\Facades\Storage;

class S3Storage
{
    static function putFile(string $path, mixed $content): bool
    {
        return Storage::disk('s3')->put($path, $content);
    }

    static function getFile(string $name): string
    {
        return str_replace(
            's3mock:9090', 
            'localhost:' . env('S3_DOCKER_PORT'), 
            Storage::cloud()->url($name)
        );
    }

    static function assertExists(string $name): void
    {
        $isFile = Storage::disk('s3')->exists($name);

        if(!$isFile)
        {
            throw new \Exception("File $name does not exist");
        }
    }

    static function deleteFile(string $name): bool
    {
        return Storage::disk('s3')->delete($name);
    }
} 