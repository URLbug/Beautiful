<?php

namespace App\Modules\S3Storage\Lib;

use App\Interfaces\S3StorageInterface;
use Illuminate\Support\Facades\Storage;

class S3Storage implements S3StorageInterface
{
    static function putFile(string $path, mixed $content): bool
    {
        return Storage::disk('s3')->put($path, $content);
    }

    static function getFile(string $name): string|bool
    {
        $endpoint = env('AWS_ENDPOINT');
        if($endpoint === '') {
            return false;
        }

        $arrayEndpoints = explode(':', $endpoint);
        if(count($arrayEndpoints) < 2) {
            return false;
        }

        $replaceString = $arrayEndpoints[0] . ':' . $arrayEndpoints[1];

        return str_replace(
            $replaceString,
            $arrayEndpoints[0] . ':'  . '//localhost',
            Storage::cloud()->url($name)
        );
    }

    static function deleteFile(string $name): bool
    {
        return Storage::disk('s3')->delete($name);
    }
}
