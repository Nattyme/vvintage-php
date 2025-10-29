<?php
declare(strict_types=1);

namespace Vvintage\DTO\Product\Filter;


class ProductFilterDTO {
    public array $categories = [];
    public array $brands = [];
    public ?int $priceMin = null;
    public ?int $priceMax = null;
    public ?string $sort = null;
    public ?string $sortKey = null;
    public ?array $pagination = [];

    public function __construct(array $query) {
        $sortData = !empty($query['sort']) ? $query['sort'] : null;

        if(  $sortData === 'price_asc') {
          $sort = 'price ASC';
        }
       
        if(  $sortData === 'price_desc') {
          $sort = 'price DESC';
        }

        $this->categories = $query['categories'] ?? [];
        $this->brands = $query['brands'] ?? [];
        $this->priceMin = isset($query['priceMin']) ? (int) $query['priceMin'] : null;
        $this->priceMax = isset($query['priceMax']) ? (int) $query['priceMax'] : null;
        $this->sort = $sort ?? null;
        $this->sortKey = $sortData ?? null;
        $this->pagination = $query['pagination'] ?? [];
    }

    public function toArray(): array 
    {
      return [
          'categories' => $this->categories,
          'brands'     => $this->brands,
          'priceMin'   => $this->priceMin,
          'priceMax'   => $this->priceMax,
          'sort'       => $this->sort,
          'pagination' => $this->pagination
      ];
    }
}
