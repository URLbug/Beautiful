<?php

namespace App\Interfaces\Repository;

use Illuminate\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface extends RepositoryInterface
{
    public static function getPagination(
        ?array $orderBy = null,
        ?int $perPage = null,
        array $columns = ['*'],
        string $pageName = 'page',
        ?int $page = null,
        ?int $total = null
    ): LengthAwarePaginator;
}
