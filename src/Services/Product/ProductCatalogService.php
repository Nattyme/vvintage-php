<?php

declare(strict_types=1);

namespace Vvintage\Services\Product;

use Vvintage\Repositories\Product\ProductRepository;
use Vvintage\Database\Database;

require_once ROOT . "./libs/functions.php";

final class ProductCatalogService
{
  private ProductRepository $repository;

  public function __construct(ProductRepository $repository) 
  {
    $this->repository = $repository;
  }

  public function getAll($pagination): array
  {
      
      $products = $this->repository->getAllProducts($pagination);
      return $products;
  }

}
