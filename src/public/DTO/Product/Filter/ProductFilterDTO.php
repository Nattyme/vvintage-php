<?php
declare(strict_types=1);

namespace Vvintage\Public\DTO\Product\Filter;

// TODO: move out pagination from filter dto add readonly property
final class ProductFilterDTO {
    public array $categories;
    public array $brands;
    public ?int $priceMin;
    public ?int $priceMax;
    public ?string $sort;
    public ?string $sortKey;
    public ?array $pagination;
    public ?string $status;

    public function __construct(array $query) {
        $sortData = !empty($query['sort']) ? $query['sort'] : null;

        if( $sortData === 'price_asc') $sort = 'price ASC';
       
        if( $sortData === 'price_desc') $sort = 'price DESC';

        $this->categories = $query['categories'] ?? [];
        $this->brands = $query['brands'] ?? [];
        $this->priceMin = isset($query['priceMin']) ? (int) $query['priceMin'] : null;
        $this->priceMax = isset($query['priceMax']) ? (int) $query['priceMax'] : null;
        $this->sort = $sort ?? null;
        $this->sortKey = $sortData ?? null;
        $this->pagination = $query['pagination'] ?? [];
        $this->status = $query['status'] ?? null;
    }

    public function toArray(): array 
    {
      return [
          'categories' => $this->categories,
          'brands'     => $this->brands,
          'priceMin'   => $this->priceMin,
          'priceMax'   => $this->priceMax,
          'sort'       => $this->sort,
          'pagination' => $this->pagination,
          'status' => $this->status
      ];
    }
}
