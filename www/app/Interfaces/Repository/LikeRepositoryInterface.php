<?php

namespace App\Interfaces\Repository;

use App\Interfaces\Repository\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface LikeRepositoryInterface extends RepositoryInterface
{
    static function getLikesByPost(int $postId, int $userId): ?Model;
}
