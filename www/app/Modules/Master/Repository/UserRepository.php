<?php

namespace App\Modules\Master\Repository;

use App\Interfaces\Repository\UserRepositoryInterface;
use App\Modules\Master\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use \InvalidArgumentException;

final class UserRepository implements UserRepositoryInterface
{
    public static function save(array $data): bool
    {
        if(
            !isset($data['password']) ||
            !isset($data['username']) ||
            !isset($data['email']) ||
            !isset($data['role_id'])
        ) {
            throw new InvalidArgumentException('Required (password, name, email, role_id) parameter is missing');
        }

        $user = new User;

        foreach($data as $key => $value) {
            $user->{$key} = $value;
        }

        return $user->save();
    }

    public static function remove(array $data): bool
    {
        $user = User::query();

        if(isset($data['id'])) {
            if(!is_int($data['id'])) {
                throw new InvalidArgumentException('Id parameter must be integer');
            }

            return $user->find($data['id'])->delete();
        }

        if(!isset($data['name']) || !isset($data['email'])) {
            throw new InvalidArgumentException('Required (name, email) parameter is missing');
        }

        return $user->where('name', $data['name'])
            ->where('email', $data['email'])
            ->delete();
    }

    public static function update(array $data): int
    {
        if(!isset($data['id'])) {
            throw new InvalidArgumentException('Required id parameter is missing');
        }

        if(!is_int($data['id'])) {
            throw new InvalidArgumentException('Id parameter must be integer');
        }

        $user = new User();
        $fillableAttributes = $user->getFillable();

        $updateData = [];
        foreach($data as $key => $value) {
            if(in_array($key, $fillableAttributes)) {
                $updateData[$key] = $value;
            }
        }

        if($updateData === []) {
            $attr = join(', ', $fillableAttributes);
            throw new InvalidArgumentException("Required ($attr) parameter is missing for update");
        }

        return $user::query()->find($data['id'])->update($updateData);
    }

    public static function getAll(): Collection
    {
        return User::all();
    }

    public static function getById(int $id): User|false
    {
        return User::query()->find($id)->first();
    }

    public static function getBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): Collection
    {
        $user = new User();
        $fillableAttributes = $user->getFillable();

        $query = $user::query();

        foreach ($criteria as $field => $value) {
            if (in_array($field, $fillableAttributes)) {
                if(is_array($value)) {
                    $query->whereIn($field, $value);
                } else {
                    $query->where($field, $value);
                }
            }
        }

        if ($orderBy !== null) {
            foreach($orderBy as $field => $direction) {
                if (in_array($field, $fillableAttributes)) {
                    $query->orderBy($field, strtolower($direction) === 'desc' ? 'desc' : 'asc');
                }
            }
        }

        if ($limit !== null) {
            $query->take($limit);
        }

        if ($offset !== null) {
            $query->skip($offset);
        }

        return $query->get();
    }

    public static function getByEmail(string $email): ?User
    {
        return User::query()->where('email', $email)->first();
    }

    public static function getByUsername(string $username): ?User
    {
        return User::query()
            ->where('username', $username)
            ->first();
    }

    public static function getByPassword(string $password): ?User
    {
        $password = Hash::make($password);

        return User::query()->where('password', $password)->first();
    }
}
