<?php

namespace App\Modules\Profile\Repository;

use App\Interfaces\Repository\CommentRepositoryInterface;
use App\Modules\Profile\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CommentRepository implements CommentRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public static function save(array $data): bool
    {
        if(
            !isset($data['user_id']) ||
            !isset($data['post_id']) ||
            !isset($data['description'])
        ) {
            throw new \InvalidArgumentException('Required (user_id, post_id, description) parameters is missing');
        }

        if(!filter_var($data['user_id'], FILTER_VALIDATE_INT) || !filter_var($data['post_id'], FILTER_VALIDATE_INT)) {
            throw new \InvalidArgumentException('Required (user_id, post_id) is must be integer');
        }

        $comment = new Comment;

        foreach($data as $key => $value) {
            $comment->{$key} = $value;
        }

        return $comment->save();
    }

    /**
     * @inheritDoc
     */
    public static function remove(array $data): bool
    {
        if(!$data['id']) {
            throw new \InvalidArgumentException('Required (id) parameter is missing');
        }

        if(!is_int($data['id'])) {
            throw new \InvalidArgumentException('Required (id) parameter is must be integer');
        }

        return Comment::query()->find($data['id'])->delete();
    }

    /**
     * @inheritDoc
     */
    public static function update(array $data): int
    {
       return 0;
    }

    /**
     * @inheritDoc
     */
    public static function getAll(): Collection
    {
        return Comment::all();
    }

    /**
     * @inheritDoc
     */
    public static function getById(int $id): Model|false
    {
        return Comment::query()->find($id);
    }

    /**
     * @inheritDoc
     */
    public static function getBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): Collection
    {
        return Collection::make([]);
    }
}
