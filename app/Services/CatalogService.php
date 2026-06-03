<?php

namespace App\Services;

use App\Core\Database;
use App\Repositories\CatalogRepository;
use App\Interfaces\CatalogRepositoryInterface;
use App\Domain\Catalog\CatalogQuery;
use App\Domain\Catalog\Category;
use App\Domain\Catalog\SearchTerm;
use App\Domain\Catalog\CatalogPolicy;

class CatalogService extends BaseService
{
    private CatalogRepositoryInterface $repo;
    private CatalogPolicy $policy;

    public function __construct(?CatalogRepositoryInterface $repo = null)
    {
        $this->repo = $repo ?? new CatalogRepository(
            Database::getConnection()
        );

        // 🧠 DOMAIN POLICY INJECTED
        $this->policy = new CatalogPolicy();
    }

    public function getCatalogPage(array $params): array
    {
        // 🧠 DOMAIN INPUT OBJECT
        $query = new CatalogQuery(
            new Category($params['cat'] ?? null),
            new SearchTerm($params['s'] ?? null),
            (int)($params['page'] ?? 1)
        );

        $limit = 10;

        // 🧠 DOMAIN DECIDES EVERYTHING
        $mode = $this->policy->resolveMode($query);

        $page = $this->policy->normalizePage($query->page);
        $offset = $this->policy->calculateOffset($page, $limit);

        // COUNT (still repo, OK)
        $totalItems = $this->repo->count([
            'category' => $query->category->value(),
            'search'   => $query->search->value()
        ]);

        $pagination = $this->buildPagination($totalItems, $page);

        // LOAD DATA (service only delegates)
        $catalog = $this->loadByMode($mode, $query, $limit, $offset);

        return [
            'catalog' => $catalog,
            'section' => $query->category->value(),
            'search' => $query->search->value(),
            'currentPage' => $pagination['currentPage'],
            'totalPages' => $pagination['totalPages'],
            'pageTitle' => $query->category->value()
                ? ucfirst($query->category->value())
                : 'Full Catalog'
        ];
    }

    /**
     * 🧠 SERVICE ONLY EXECUTES — NO LOGIC
     */
    private function loadByMode(
        string $mode,
        CatalogQuery $query,
        int $limit,
        int $offset
    ): array {
        return match ($mode) {

            CatalogPolicy::MODE_SEARCH =>
                $this->repo->search(
                    $query->search->value(),
                    $query->category->value(),
                    $limit,
                    $offset
                ),

            CatalogPolicy::MODE_CATEGORY =>
                $this->repo->getByCategory(
                    $query->category->value(),
                    $limit,
                    $offset
                ),

            default =>
                $this->repo->getAll($limit, $offset),
        };
    }
    public function getHomePageData(): array
{
    return [
        'random' => $this->repo->getRandom(),
        'pageTitle' => 'Personal Media Library',
        'section' => 'catalog'
    ];
}
public function getById(int $id): ?array
{
    return $this->repo->getById($id);
}
}