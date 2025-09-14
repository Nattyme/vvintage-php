<?php

declare(strict_types=1);

namespace Vvintage\Services\Product;

/** Модель */
use Vvintage\Models\Product\Product;
use Vvintage\Repositories\Product\ProductRepository;
use Vvintage\Repositories\Product\ProductTranslationRepository;

use Vvintage\Services\Base\BaseService;
use Vvintage\Services\Product\ProductImageService;
use Vvintage\Services\Category\CategoryService;
use Vvintage\Services\Brand\BrandService;

use Vvintage\DTO\Product\ProductFilterDTO;

require_once ROOT . "./libs/functions.php";

class ProductService extends BaseService
{
    protected ProductRepository $repository;
    protected ProductTranslationRepository $translationRepo;
    protected CategoryService $categoryService;
    protected BrandService $brandService;
    protected ProductImageService $productImageService;

    private array $status = [
      'active'   => 'Активный',
      'hidden'   => 'Невидимый',
      'archived' => 'В архиве'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->repository = new ProductRepository($this->locale);
        $this->translationRepo = new ProductTranslationRepository($this->locale);
        $this->categoryService = new CategoryService();
        $this->brandService = new BrandService();
        $this->productImageService = new ProductImageService();
    }

    public function getStatusList(): array {
      return $this->status;
    }


    public function getProductById(int $id): ?Product
    {
        $rows = $this->repository->getProductById($id);
        return $rows ? $this->createProductDTOFromArray($rows[0]) : null;
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
    public function getAll($pagination = []): array
    {
        return $this->repository->getAllProducts(['limit' => $pagination['sql_page_limit'] ?? '']);
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

    public function getFilteredProducts(ProductFilterDTO $filter): array 
    {
        return $this->repository->getFilteredProducts($filter);
    }

    protected function createProductDTOFromArray(array $row): ProductDTO
    {
        $productId = (int) $row['id'];
        $translations = $this->translationRepo->loadTranslations($productId);
        $categoryDTO = $this->categoryService->createCategoryOutputDTO($row);
        $brandDTO = $this->brandService->createBrandDTOFromArray($row);
        $imagesDTO = $this->productImageService->fetchImageDTOs($row);

        return new ProductDTO([
            'id' => $productId,
            'categoryDTO' => $categoryDTO,
            'brandDTO' => $brandDTO,
            'slug' => (string) $row['slug'],
            'title' => (string) $row['title'],
            'description' => (string) $row['description'],
            'price' => (string) $row['price'],
            'url' => (string) $row['url'],
            'status' => (string) $row['status'],
            'sku' => (string) $row['sku'],
            'stock' => (int) $row['stock'],
            'datetime' => (string) $row['datetime'],
            'edit_time' => (string) $row['edit_time'],
            'images_total' => count($imagesDTO),
            'translations' => $translations,
            'locale' => $this->locale ?? self::DEFAULT_LOCALE,
            'images' => $imagesDTO
        ]);
    }

}
