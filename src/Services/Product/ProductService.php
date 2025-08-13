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
    private array $languages;
    private string $currentLang;
    private ProductRepository $repository;
    private CategoryRepository $categoryRepository;
    private ProductImageService $productImageService;
    private array $status;

    public function __construct($languages, $currentLang)
    {
        $this->languages = $languages;
        $this->currentLang = $currentLang;
        $this->repository = new ProductRepository($this->currentLang);
        $this->categoryRepository = new CategoryRepository($this->currentLang);
        $this->productImageService = new ProductImageService();
        $this->status = ['active'=> 'Активный', 'hidden'=>'Невидимый', 'archived'=>'В архиве'];
    }

    public function getStatusList(): array {
      return $this->status;
    }


    public function getProductById(int $id): ?Product
    {
        return $this->repository->getProductById($id);
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



    private function splitVisibleHidden(array $images): array
    {
        return  $this->productImageService->splitVisibleHidden($images);
    }

    public function getProductsImages(array $products): array
    {
        $imagesByProductId = [];


        foreach ($products as $product) {
            $imagesMainAndOthers = $this->productImageService->splitImages($product->getImages());
            $imagesByProductId[$product->getId()] = $imagesMainAndOthers;
        }

        return  $imagesByProductId;
    }

    public function publishProduct(int $productId): bool
    {
        return $this->repository->updateStatus($productId, 'active');
    }

    public function hideProduct(int $productId): bool
    {
        return $this->repository->updateStatus($productId, 'hidden');
    }

    public function archiveProduct(int $productId, bool $keepAllImages = true): bool
    {
        $result = $this->repository->updateStatus($productId, 'archived');

        if ($result && !$keepAllImages) {
            $this->repository->deleteExtraImagesExceptMain($productId);
        }

        return $result;
    }

    public function createProductDraft(array $data): int
    {
        $data['status'] = 'hidden'; // или draft
        return $this->repository->create($data);
    }

}
