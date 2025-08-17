<?php

namespace App\Interfaces\Repository;

use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface extends RepositoryInterface
{
    public static function getByEmail(string $email): ?Model;
    public static function getByUsername(string $username): ?Model;
    public static function getByPassword(string $password): ?Model;
}
