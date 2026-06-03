<?php

namespace App\Domain\Catalog;

class CatalogQuery
{
    public function __construct(
        public Category $category,
        public SearchTerm $search,
        public int $page
    ) {}

    public function hasSearch(): bool
    {
        return $this->search->value() !== null;
    }

    public function hasCategory(): bool
    {
        return $this->category->value() !== null;
    }
}