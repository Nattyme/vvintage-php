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
use Vvintage\Services\Shared\PaginationService;
use Vvintage\Services\Brand\BrandService;

use Vvintage\DTO\Product\ProductFilterDTO;
use Vvintage\DTO\Product\ProductOutputDTO;

require_once ROOT . "./libs/functions.php";

class ProductService extends BaseService
{
    protected ProductRepository $repository;
    protected ProductTranslationRepository $translationRepo;
    protected CategoryService $categoryService;
    protected BrandService $brandService;
    protected ProductImageService $productImageService;
    protected PaginationService $paginationService;

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
        $this->paginationService = new PaginationService();
    }

    
    private function createProductDTOFromArray(array $row): ProductOutputDTO
    {
        $productId = (int) $row['id'];
        $translations = $this->translationRepo->loadTranslations($productId);
        $categoryOutputDTO = $this->categoryService->createCategoryOutputDTO((int) $row['category_id']);
        $brandOutputDTO = $this->brandService->createBrandOutputDTO((int) $row['brand_id']);

        // $brandDTO = $this->brandService->createBrandDTOFromArray($row);
        $imagesDTO = $this->productImageService->createImageDTO($row);

        $images = $this->productImageService->getImageViewData($imagesDTO);
        
        // $datetime = isset($row['datetime']) ? new \DateTime($row['datetime']) : null;

        $dto = new ProductOutputDTO([
          'id' => $row['id'],
          'category_id' => $row['category_id'],
          'category_title' => $categoryOutputDTO->title,
          'categoryDTO' => $categoryOutputDTO,
          'brand_id' => $row['brand_id'],
          'brand_title' => $brandOutputDTO->title,
          'brandDTO' => $brandOutputDTO,
          'slug' => $row['slug'],
          'title' => $translations[$this->locale]['title'],
          'description' => $translations[$this->locale]['description'],
          'price' => $row['price'],
          'url' => $row['url'],
          'sku' => $row['sku'],
          'stock' => $row['stock'],
          'datetime' => $row['datetime'],

          'status' => $row['status'],
          'edit_time' => $row['edit_time'],
          'images' => $images,
          'translations' => $translations
        ]);
 
        return $dto;
     
    }

    public function getStatusList(): array {
      return $this->status;
    }


    public function getProductById(int $id): ?ProductOutputDTO
    {
        $rows = $this->repository->getProductById($id);

        return $rows ? $this->createProductDTOFromArray($rows) : null;
    }

    public function getProductsByIds(array $ids): array
    {
        if (empty($ids)) return [];

        // Изменяем ассоциативный массив - берем только значения
        $ids = array_keys($ids);

        // Получаем все продукты за один запрос
        $rows = $this->repository->getProductsByIds($ids);

        if (empty($rows)) return [];

        // Преобразуем в DTO
        return array_map([$this, 'createProductDTOFromArray'], $rows);
    }


    public function getActiveProducts(): array 
    {
      $rows =  $this->repository->getProductsByParam('status = ?', ['active']);
      
      // Применяем fetchProductWithJoins к каждому объекту OODBBean
      return array_map([$this, 'createProductDTOFromArray'], $rows);
    }

    public function getArchivedProducts(): array 
    {
      $rows = $this->repository->getProductsByParam('status = ?', ['archived']);
      // Применяем fetchProductWithJoins к каждому объекту OODBBean
      return array_map([$this, 'createProductDTOFromArray'], $rows);
    }

    public function getHiddenProducts(): array 
    {
      $rows =  $this->repository->getProductsByParam('status = ?', ['hidden']);
      return array_map([$this, 'createProductDTOFromArray'], $rows);
    }

    //    $result['number_of_pages'] = $number_of_pages;
    // $result['page_number'] = $page_number;
    // $result['sql_page_limit'] =  $sql_page_limit;
    public function getAll($pagination = []): array
    {
        $rows = $this->repository->getAllProducts(['limit' => $pagination['sql_page_limit'] ?? '']);

        if(empty($rows)) return [];

        return array_map([$this, 'createProductDTOFromArray'], $rows);
    }

    public function getLastProducts(int $count): ?array
    {
      $rows = $this->repository->getLastProducts($count);

      return $rows ? array_map([$this, 'createProductDTOFromArray'], $rows) : null;
    }

    public function countProducts(): int
    {
        return $this->repository->getAllProductsCount();
    }



    public function getProductImages(ProductOutputDTO $product): array
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

    public function getFilteredProducts(ProductFilterDTO $filters): array 
    {
     
      $categories = !empty($filters->categories) ? $filters->categories : null;
    
      if( $categories && count( $categories) === 1) {
        $id = (int) $categories[0];
        $category = $this->categoryService->getCategoryById($id) ?? null;
        $parent_id = $category->getParentId() ?? null;
    
        if(!$parent_id) {
          $subCategories = $this->categoryService->getSubCategoriesArray($id);
          
          // Получаем только id из массива подкатегорий
          $subCategoryIds = array_column($subCategories, 'id');

          // Теперь можно подставить эти id в фильтр
          if (!empty($subCategoryIds)) {
              $filters->categories = $subCategoryIds;
          }
        }
      
      }

      if ($filters instanceof ProductFilterDTO) {
          $filters = [
              'categories' => $filters->categories,
              'brands'     => $filters->brands,
              'priceMin'   => $filters->priceMin,
              'priceMax'   => $filters->priceMax,
              'sort'       => $filters->sort
          ];
      }

      $products = $this->repository->getProducts($filters);
      $totalItems = count($products);

      $filters = $this->addPaginationToFilter($filters, $totalItems);
 

      // Теперь получаем только продукты для этой страницы
      $productsPage = $this->repository->getProducts($filters);
      $products = array_map([$this, 'createProductDTOFromArray'], $productsPage);

      return ['products' => $products, 'total' => $totalItems, 'filters' => $filters];

      // $rows = $this->repository->getProducts($filters);
  
      // return array_map([$this, 'createProductDTOFromArray'], $products);
    }

    public function addPaginationToFilter($filters, $totalItems)
    {
      $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
      $pagination = $this->paginationService->paginate( totalItems: $totalItems, currentPage: $currentPage, perPage: 10);

      // Добавляем пагинацию в фильтры
      $filters['pagination']['page_number'] = $pagination['current_page'];
      $filters['pagination']['perPage'] = $pagination['perPage'];
      $filters['pagination']['number_of_pages'] = $pagination['number_of_pages'];
  
      // $filters['perPage'] = $pagination['perPage'];
      // $filters['number_of_pages'] = $pagination['number_of_pages'];
      return $filters;
    }



    protected function uniteProductData(array $data) 
    {
      $products = $this->repository->uniteProductRawData($data);
    }

    public function getFlatImages(array $images) 
    {
      return $this->productImageService->getFlatImages($images);
    }

    

}
