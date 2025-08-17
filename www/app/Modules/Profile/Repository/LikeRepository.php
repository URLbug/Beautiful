<?php

namespace App\Modules\Profile\Repository;

use App\Interfaces\Repository\LikeRepositoryInterface;
use App\Modules\Profile\Models\Like;
use Illuminate\Support\Collection;

final class LikeRepository implements LikeRepositoryInterface
{

    public static function save(array $data): bool
    {
        if(!isset($data['user_id']) || !isset($data['post_id'])) {
            throw new \InvalidArgumentException('Required (user_id, post_id) parameter missing');
        }

        if(!is_int($data['user_id']) || !is_int($data['post_id'])) {
            throw new \InvalidArgumentException('Required (user_id, post_id) must be an integer');
        }

        $like = new Like;

        $like->post_id = $data['post_id'];
        $like->user_id = $data['user_id'];

        return $like->save();
    }

    public static function remove(array $data): bool
    {
        if(!isset($data['id'])) {
            throw new \InvalidArgumentException('Required (id) parameter missing');
        }

        if(!is_int($data['id'])) {
            throw new \InvalidArgumentException('Required (id) must be an integer');
        }

        return Like::query()->find($data['id'])->delete();
    }

    public static function update(array $data): int
    {
        return 0;
    }

    public static function getAll(): Collection
    {
        return Like::all();
    }

    public static function getById(int $id): Like|false
    {
        return Like::query()->find($id);
    }

    public static function getBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): Collection
    {
       return Collection::make([]);
    }

    static function getLikesByPost(int $postId, int $userId): ?Like
    {
        return Like::query()
            ->where('post_id', $postId)
            ->where('user_id', $userId)
            ->first();
    }
}
