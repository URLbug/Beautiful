<?php

namespace App\Modules\Profile\Repository;

use App\Interfaces\Repository\FollowerRepositoryInterface;
use App\Modules\Profile\Models\Follower;
use Illuminate\Database\Eloquent\Model;

final class FollowerRepository implements FollowerRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public static function save(array $data): bool
    {
        if(!isset($data['following_id']) || !isset($data['follower_id'])) {
            throw new \InvalidArgumentException("Required fields (following_id, follower_id) are missing");
        }

        if(!is_int($data['following_id']) || !is_int($data['follower_id'])) {
            throw new \InvalidArgumentException("follower_id and|or following_id must be integer");
        }

        $follower = new Follower;

        $follower->follower_id = $data['following_id'];
        $follower->following_id = $data['follower_id'];

        return $follower->save();
    }

    /**
     * @inheritDoc
     */
    public static function remove(array $data): bool
    {
        $follower = Follower::query();

        if(isset($data['id'])) {
            if(!is_int($data['id'])) {
                throw new \InvalidArgumentException("Id must be integer");
            }

            return $follower->find($data['id'])
                ->delete();
        }

        if(!isset($data['following_id']) || !isset($data['follower_id'])) {
            throw new \InvalidArgumentException("Required fields (following_id, follower_id) are missing");
        }

        if(!is_int($data['following_id']) || !is_int($data['follower_id'])) {
            throw new \InvalidArgumentException("follower_id and|or following_id must be integer");
        }

        return $follower->where('following_id', $data['following_id'])
            ->where('follower_id', $data['follower_id'])
            ->delete();
    }

    /**
     * @inheritDoc
     */
    public static function update(array $data): int
    {
        if (!isset($data['following_id']) || !isset($data['follower_id'])) {
            throw new \InvalidArgumentException('Required fields (following_id, follower_id) are missing');
        }

        $followingId = filter_var($data['following_id'], FILTER_VALIDATE_INT);
        $followerId = filter_var($data['follower_id'], FILTER_VALIDATE_INT);

        if ($followingId === false || $followerId === false) {
            throw new \InvalidArgumentException('following_id and follower_id must be integers');
        }

        $query = Follower::query();

        if (isset($data['id'])) {
            $id = filter_var($data['id'], FILTER_VALIDATE_INT);
            if ($id === false) {
                throw new \InvalidArgumentException('id must be an integer');
            }

            $query = $query->where('id', $id);
        }

        $updateData = [
            'following_id' => $followingId,
            'follower_id' => $followerId,
        ];

        return $query->update($updateData);
    }

    /**
     * @inheritDoc
     */
    public static function getAll(): \Illuminate\Support\Collection
    {
        return Follower::all();
    }

    /**
     * @inheritDoc
     */
    public static function getById(int $id): Follower|false
    {
        return Follower::query()->find($id);
    }

    /**
     * @inheritDoc
     */
    public static function getBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): \Illuminate\Support\Collection
    {
        if(!isset($data['following_id']) || !isset($data['follower_id'])) {
            throw new \InvalidArgumentException("Required fields (following_id, follower_id) are missing");
        }

        if(!is_int($data['following_id']) || !is_int($data['follower_id'])) {
            throw new \InvalidArgumentException("follower_id and|or following_id must be integer");
        }

        $follower = Follower::query();

        if($criteria['following_id']) {
            $follower = $follower->where('following_id', $criteria['following_id']);
        }

        if($criteria['follower_id']) {
            $follower = $follower->where('follower_id', $criteria['follower_id']);
        }

        if($orderBy !== null) {
            $fillableAttributes = (new Follower)->getFillable();

            foreach($orderBy as $field => $direction) {
                if (in_array($field, $fillableAttributes)) {
                    $follower->orderBy($field, strtolower($direction) === 'desc' ? 'desc' : 'asc');
                }
            }
        }

        if($limit !== null) {
            $follower->take($limit);
        }

        if ($offset !== null) {
            $follower->skip($offset);
        }

        return $follower->get();
    }

    public static function getByFollowers(int $follower_id): \Illuminate\Support\Collection
    {
        return Follower::query()
            ->where('following_id', $follower_id)
            ->get(['follower_id',]);
    }

    public static function getByFollowing(int $following_id): \Illuminate\Support\Collection
    {
        return Follower::query()
            ->where('follower_id', $following_id)
            ->get(['following_id',]);
    }

    public static function getFirst(int|false $follower_id, int|false $following_id): ?Follower
    {
        if(!$follower_id && !$following_id) {
            throw new \InvalidArgumentException('Required field follower_id or follower_id');
        }

        $follower = Follower::query();
        if($follower_id) {
            $follower = $follower->where('follower_id', $follower_id);
        }

        if($following_id) {
            $follower = $follower->where('following_id', $following_id);
        }

        return $follower->first();
    }
}
