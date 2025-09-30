<?php
declare(strict_types=1);

namespace Vvintage\Services\Shared;

use RedBeanPHP\R;

class PaginationService
{
    private int $defaultPerPage;

    public function __construct(int $defaultPerPage = 5)
    {
        $this->defaultPerPage = $defaultPerPage;
    }

    public function paginate(
        int $resultsPerPage,
        string $table,
        array $conditions = [],
        array $params = [],
        ?int $currentPage = null
    ): array {
        $resultsPerPage = $resultsPerPage > 0 ? $resultsPerPage : $this->defaultPerPage;

        $where = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';
        $numberOfResults = R::count($table, $where, $params);

        $numberOfPages = (int)ceil($numberOfResults / $resultsPerPage);

        $pageNumber = $currentPage ?? (isset($_GET['page']) ? (int)$_GET['page'] : 1);
        if ($pageNumber < 1) $pageNumber = 1;
        if ($pageNumber > $numberOfPages) $pageNumber = $numberOfPages > 0 ? $numberOfPages : 1;

        $offset = ($pageNumber - 1) * $resultsPerPage;

        // Возвращаем готовые данные для findAll
        return [
            'limit'           => $resultsPerPage,
            'offset'          => $offset,
            'number_of_pages' => $numberOfPages,
            'current_page'    => $pageNumber,
        ];
    }
}
