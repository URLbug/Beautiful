<?php

namespace App\Modules\Profile\Repository;

use App\Interfaces\Repository\PostRepositoryInterface;
use App\Modules\Profile\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use \InvalidArgumentException;

final class PostRepository implements PostRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public static function save(array $data): bool
    {
        if(
            !isset($data['name']) ||
            !isset($data['file']) ||
            !isset($data['description']) ||
            !isset($data['user_id'])
        ) {
            throw new InvalidArgumentException('Required (name, file, description, user_id) parameter is missing');
        }

        $post = new Post;

        foreach($data as $key => $value) {
            $post->{$key} = $value;
        }

        return $post->save();
    }

    /**
     * @inheritDoc
     */
    public static function remove(array $data): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public static function update(array $data): int
    {
        $query = Post::query();

        if(!isset($data['id'])) {
            throw new InvalidArgumentException('Required (id) parameter is missing');
        }

        $id = filter_var($data['id'], FILTER_VALIDATE_INT);
        if ($id === false) {
            throw new \InvalidArgumentException('id must be an integer');
        }

        $query = $query->where('id', $id);

        $updateData = [];
        foreach($data as $key => $value) {
            $updateData[$key] = $value;
        }

        return $query->update($updateData);
    }

    /**
     * @inheritDoc
     */
    public static function getAll(): Collection
    {
        return Post::all();
    }

    /**
     * @inheritDoc
     */
    public static function getById(int $id): Post|false
    {
        return Post::query()->find($id);
    }

    /**
     * @inheritDoc
     */
    public static function getBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): Collection
    {
        return Collection::make([]);
    }

    public static function getPagination(
        ?array $orderBy = null,
        ?int $perPage = null,
        array $columns = ['*'],
        string $pageName = 'page',
        ?int $page = null,
        ?int $total = null
    ): LengthAwarePaginator {
        $query = Post::query();

        if($orderBy) {
            if(count($orderBy) < 1) {
                return $query->paginate($perPage, $columns, $pageName, $page);
            }

            $query = $query->orderBy($orderBy[0], strtolower($orderBy[1]) === 'desc' ? $orderBy[1] : 'asc');
        }

        return $query->paginate($perPage, $columns, $pageName, $page);
    }

    public static function search(array $data): LengthAwarePaginator
    {
        $query = Post::query();

        $post = new Post;
        $fillableAttribute = $post->getFillable();

        $itemQuery = 0;
        foreach($data as $key => $value) {
            if(in_array($key, $fillableAttribute)) {
                if($itemQuery > 0) {
                    $query = $query->orWhere($key, 'like', '%' . $value . '%');
                    continue;
                }

                $query = $query->where($key, 'like', '%' . $value . '%');
            }

            $itemQuery++;
        }

        return $query->paginate();
    }
}
