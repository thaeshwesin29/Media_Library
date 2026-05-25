<?php

namespace App\Services;

use App\Core\Database;
use App\Repositories\CatalogRepository;
use App\Interfaces\CatalogRepositoryInterface;

class CatalogService extends BaseService
{
    private CatalogRepositoryInterface $repo;

    public function __construct(
        ?CatalogRepositoryInterface $repo = null
    ) {

        if ($repo === null) {

            $repo = new CatalogRepository(
                Database::getConnection()
            );
        }

        $this->repo = $repo;
    }

    public function getHomePageData(): array
    {
        return [
            'random' => $this->repo->getRandom(),
            'pageTitle' => 'Personal Media Library',
            'section' => 'catalog'
        ];
    }

    public function getCatalogPage(
        array $queryParams
    ): array {

        $section = $this->getCategory(
            $queryParams
        );

        $search = $this->getSearchTerm(
            $queryParams
        );

        $currentPage = $this->getCurrentPage(
            $queryParams
        );

        $totalItems = $this->repo->count([
            'category' => $section,
            'search' => $search
        ]);

        $pagination = $this->buildPagination(
            $totalItems,
            $currentPage
        );

        $catalog = $this->loadCatalogData(
            $section,
            $search,
            $pagination['limit'],
            $pagination['offset']
        );

        return [
            'catalog' => $catalog,
            'section' => $section,
            'search' => $search,
            'currentPage' => $pagination['currentPage'],
            'totalPages' => $pagination['totalPages'],
            'pageTitle' => $section
                ? ucfirst($section)
                : 'Full Catalog',

            'queryString' => $this->buildQueryString(
                $section,
                $search
            )
        ];
    }

    private function loadCatalogData(
        ?string $section,
        ?string $search,
        int $limit,
        int $offset
    ): array {

        if ($search !== null) {

            return $this->repo->search(
                $search,
                $section,
                $limit,
                $offset
            );
        }

        if ($section !== null) {

            return $this->repo->getByCategory(
                $section,
                $limit,
                $offset
            );
        }

        return $this->repo->getAll(
            $limit,
            $offset
        );
    }

    private function getCategory(
        array $params
    ): ?string {

        $category = $params['cat'] ?? null;

        $allowed = [
            'books',
            'movies',
            'music'
        ];

        return in_array(
            $category,
            $allowed,
            true
        )
            ? $category
            : null;
    }

    private function getSearchTerm(
        array $params
    ): ?string {

        $search = trim(
            $params['s'] ?? ''
        );

        return $search !== ''
            ? $search
            : null;
    }

    public function getById(
        int $id
    ): ?array {

        return $this->repo->getById($id);
    }
}