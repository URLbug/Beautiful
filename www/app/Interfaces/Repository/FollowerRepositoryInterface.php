<?php

namespace App\Interfaces\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface FollowerRepositoryInterface extends RepositoryInterface
{
    public static function getByFollowers(int $follower_id): Collection;

    public static function getByFollowing(int $following_id): Collection;

    public static function getFirst(int|false $follower_id, int|false $following_id): ?Model;

}
