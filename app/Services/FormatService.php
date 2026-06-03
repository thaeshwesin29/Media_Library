<?php

namespace App\Services;

use App\Core\Database;
use App\Repositories\FormatRepository;
use App\Interfaces\FormatRepositoryInterface;
use App\Domain\Format\FormatQuery;
use App\Domain\Format\FormatPolicy;

class FormatService
{
    private FormatRepositoryInterface $repo;
    private FormatPolicy $policy;

    public function __construct(?FormatRepositoryInterface $repo = null)
    {
        $this->repo = $repo ?? new FormatRepository(
            Database::getConnection()
        );

        $this->policy = new FormatPolicy();
    }

    /**
     * 🎯 Use Case: Get Categories
     */
    public function getCategories(): array
    {
        return $this->repo->getCategoryDropDown();
    }

    /**
     * 🎯 Use Case: Get Formats
     */
    public function getFormats(?string $category): array
    {
        $query = new FormatQuery(
            $this->policy->normalizeCategory($category)
        );

        return $this->repo->getFormatDropDown(
            $query->category()
        );
    }

    /**
     * 🎯 Use Case: Get Genres
     */
    public function getGenres(?string $category): array
    {
        $query = new FormatQuery(
            $this->policy->normalizeCategory($category)
        );

        return $this->repo->getGenresDropDown(
            $query->category()
        );
    }
}