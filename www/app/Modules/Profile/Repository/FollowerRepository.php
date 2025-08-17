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
        if(!$data['following_id'] || !$data['follower_id']) {
            return false;
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
        if(!$data['following_id'] || !$data['follower_id']) {
            return false;
        }

        return Follower::query()
            ->where('following_id', $data['following_id'])
            ->where('follower_id', $data['follower_id'])
            ->delete();
    }

    /**
     * @inheritDoc
     */
    public static function update(array $data): int
    {
        if(!$data['following_id'] || !$data['follower_id']) {
            return false;
        }

        return Follower::query()
            ->where('following_id', $data['following_id'])
            ->where('follower_id', $data['follower_id'])
            ->update([
                'following_id' => $data['following_id'],
                'follower_id' => $data['follower_id'],
            ]);
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
    public static function getById(int $id): Model|false
    {
        return Follower::query()->find($id);
    }

    /**
     * @inheritDoc
     */
    public static function getBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): \Illuminate\Support\Collection
    {
        if(!$criteria['following_id'] && !$criteria['follower_id']) {
            throw new \LogicException('Not found follower_id or not follower_id');
        }

        $follower = Follower::query();

        if($criteria['following_id']) {
            $follower = $follower->where('following_id', $criteria['following_id']);
        }

        if($criteria['follower_id']) {
            $follower = $follower->where('follower_id', $criteria['follower_id']);
        }

        if($orderBy) {
            $follower = $follower->orderBy($orderBy[0], $orderBy[1]);
        }

        if($limit) {
            $follower = $follower->limit($limit);
        }

        if($limit && $offset) {
            $follower = $follower->offset($offset);
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

    public static function getFirst(int|false $follower_id, int|false $following_id): ?Model
    {
        if(!$follower_id && !$following_id) {
            throw new \LogicException('Not found follower_id or follower_id');
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
