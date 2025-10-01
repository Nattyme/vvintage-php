<?php
declare(strict_types=1);

namespace Vvintage\DTO\Product;


class ProductFilterDTO {
    public array $categories = [];
    public array $brands = [];
    public ?int $priceMin = null;
    public ?int $priceMax = null;
    public ?string $sort = null;
    public int $page = 1;
    public int $perPage = 10;

    public function __construct(array $query) {
        $this->categories = $query['categories'] ?? [];
        $this->brands = $query['brands'] ?? [];
        $this->priceMin = isset($query['priceMin']) ? (int) $query['priceMin'] : null;
        $this->priceMax = isset($query['priceMax']) ? (int) $query['priceMax'] : null;
        $this->sort = $query['sort'] ?? null;
        $this->page = $query['page'] ?? 1;
        $this->perPage = $query['perPage'] ?? 10;
    }
}
