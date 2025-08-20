<?php

namespace App\Modules\Master\Repository;

use App\Interfaces\Repository\RepositoryInterface;
use App\Modules\Master\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class RoleRepository implements RepositoryInterface
{

    /**
     * @inheritDoc
     */
    public static function save(array $data): bool
    {
        if(
            !isset($data['slug']) &&
            !isset($data['name']) &&
            !isset($data['permissions'])
        ) {
            throw new \InvalidArgumentException('Required (slug, name, permissions) parameter is missing');
        }

        $role = new Role;

        $role->name = $data['name'];
        $role->slug = $data['slug'];
        $role->permissions = $data['permissions'];

        return $role->save();
    }

    /**
     * @inheritDoc
     */
    public static function remove(array $data): bool
    {
        if(!isset($data['id'])) {
            throw new \InvalidArgumentException('Required (id) parameter is missing');
        }

        if(!is_int($data['id'])) {
            throw new \InvalidArgumentException('Required (id) parameter must be integer');
        }


        return Role::query()->where('id', $data['id'])->delete();
    }

    /**
     * @inheritDoc
     */
    public static function update(array $data): int
    {
        // TODO: Implement update() method.
    }

    /**
     * @inheritDoc
     */
    public static function getAll(): Collection
    {
        return Role::all();
    }

    /**
     * @inheritDoc
     */
    public static function getById(int $id): Role|false
    {
        return Role::query()->find($id);
    }

    /**
     * @inheritDoc
     */
    public static function getBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): Collection
    {
        return Collection::make([]);
    }
}
