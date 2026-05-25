<?php

namespace App\Interfaces;

interface CatalogRepositoryInterface extends BaseInterface
{
    public function search(
        ?string $search = null,
        ?string $category = null,
        ?int $limit = null,
        int $offset = 0
    ): array;

    public function getByCategory(
        string $category,
        ?int $limit = null,
        int $offset = 0
    ): array;

    public function getRandom(): array;
}