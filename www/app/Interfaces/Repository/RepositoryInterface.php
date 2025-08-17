<?php

namespace App\Interfaces\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    /**
     * Save entity in database
     *
     * @param array $data
     * @return bool
     */
    public static function save(array $data): bool;

    /**
     * Remove entity in database
     *
     * @param array $data
     * @return bool
     */
    public static function remove(array $data): bool;

    /**
     * Update entity in database
     *
     * @param array $model
     * @return int
     */
    public static function update(array $data): int;

    /**
     * Get all entity from database
     *
     * @return Collection
     */
    public static function getAll(): Collection;

    /**
     * Get by id entity from database
     *
     * @param int $id
     * @return Model|false
     */
    public static function getById(int $id): Model|false;

    /**
     * Get by criteria. For example by name, age and|or other params
     *
     * @param array $criteria
     * @param array|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return Collection
     */
    public static function getBy(
        array $criteria,
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null): Collection;
}
