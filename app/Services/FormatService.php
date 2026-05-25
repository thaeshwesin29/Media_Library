<?php

namespace  App\Services;
use App\Interfaces\FormatRepositoryInterface;
use App\Repositories\FormatRepository;

use App\Core\Database;

/**
 * Handles format-related business logic and manages
 * communication between controllers and repositories.
 */

class FormatService
{
    private FormatRepositoryInterface $repo;

    public function __construct(?FormatRepositoryInterface $repo = null)
    {
        // Create default repository if none is provided
        if ($repo === null) {
            $db = Database::getConnection();
            $repo = new FormatRepository($db);
        }

        $this->repo = $repo;
    }

   function category_drop_down()
{
    return $this->repo->getCategoryDropDown();
}

function format_array($category = null)
{
    return $this->repo->getFormatDropDown($category);
}

function genres_array($category = null)
{
    return $this->repo->getGenresDropDown($category);
}
}