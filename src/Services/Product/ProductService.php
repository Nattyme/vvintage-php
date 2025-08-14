<?php

declare(strict_types=1);

namespace Vvintage\Services\Product;

/** Модель */
use Vvintage\Models\Product\Product;
use Vvintage\Repositories\Product\ProductRepository;
use Vvintage\Repositories\Category\CategoryRepository;
use Vvintage\Services\Product\ProductImageService;
// use Vvintage\Database\Database;

require_once ROOT . "./libs/functions.php";

class ProductService
{
    private string $currentLang;
    protected ProductRepository $repository;
    private CategoryRepository $categoryRepository;
    private ProductImageService $productImageService;

    private array $status = [
      'active'   => 'Активный',
      'hidden'   => 'Невидимый',
      'archived' => 'В архиве'
    ];

    public function __construct($currentLang)
    {
        $this->currentLang = $currentLang;
        $this->repository = new ProductRepository($this->currentLang);
        $this->categoryRepository = new CategoryRepository($this->currentLang);
        $this->productImageService = new ProductImageService();
    }

    public function getStatusList(): array {
      return $this->status;
    }


    public function getProductById(int $id): ?Product
    {
        return $this->repository->getProductById($id);
    }

    public function getActiveProducts(): array 
    {
      return $this->repository->getProductsByParam('status = ?', ['active']);
    }

    public function getArchivedProducts(): array 
    {
      return $this->repository->getProductsByParam('status = ?', ['archived']);
    }

    public function getHiddenProducts(): array 
    {
      return $this->repository->getProductsByParam('status = ?', ['hidden']);
    }


    //    $result['number_of_pages'] = $number_of_pages;
    // $result['page_number'] = $page_number;
    // $result['sql_page_limit'] =  $sql_page_limit;
    public function getAll($pagination): array
    {

        return $this->repository->getAllProducts(['limit' => $pagination['sql_page_limit']]);
    }

    public function getLastProducts(int $count): array
    {
      return $this->repository->getLastProducts($count);
    }

    public function countProducts(): int
    {
        return $this->repository->getAllProductsCount();
    }



    public function getProductImages(Product $product): array
    {
        return $this->productImageService->splitImages($product->getImages());
    }

    public function getProductImagesData(array $images): array
    {
        return $this->productImageService->getImageViewData($images);
    }

    public function countImages(array $images): int
    {
        return $this->productImageService->countAll($images);
    }

}
