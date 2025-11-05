<?php
declare(strict_types=1);

namespace Vvintage\Public\Services\Shared;

class PaginationService
{
    private ?int $defaultPerPage = null;

    public function __construct(?int $defaultPerPage = null)
    {
        $this->defaultPerPage = $defaultPerPage;
    }

    public function paginate(int $totalItems, int $currentPage = 1, ?int $perPage = null): array
    {
        $perPage = $perPage && $perPage > 0 ? $perPage : $this->defaultPerPage;

        $numberOfPages = (int)ceil($totalItems / $perPage);

        if ($currentPage < 1) $currentPage = 1;
        if ($currentPage > $numberOfPages) $currentPage = $numberOfPages > 0 ? $numberOfPages : 1;


        $offset = ($currentPage - 1) * $perPage;

        return [
            'perPage'           => $perPage,
            'offset'          => $offset,
            'number_of_pages' => $numberOfPages,
            'current_page'    => $currentPage,
        ];
    }
}
