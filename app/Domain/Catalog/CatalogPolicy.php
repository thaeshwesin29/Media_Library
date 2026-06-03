<?php

namespace App\Domain\Catalog;

class CatalogPolicy
{
    public const MODE_SEARCH = 'search';
    public const MODE_CATEGORY = 'category';
    public const MODE_ALL = 'all';

    /**
     * 🎯 BUSINESS DECISION LIVES HERE (NOT IN SERVICE)
     */
    public function resolveMode(CatalogQuery $query): string
    {
        if ($query->hasSearch()) {
            return self::MODE_SEARCH;
        }

        if ($query->hasCategory()) {
            return self::MODE_CATEGORY;
        }

        return self::MODE_ALL;
    }

    /**
     * 🎯 BUSINESS RULE: pagination safety belongs to domain
     */
    public function normalizePage(int $page): int
    {
        return max(1, $page);
    }

    /**
     * 🎯 BUSINESS RULE: offset calculation belongs to domain
     */
    public function calculateOffset(int $page, int $limit): int
    {
        return ($this->normalizePage($page) - 1) * $limit;
    }
}