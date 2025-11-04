<?php

declare(strict_types=1);

namespace Vvintage\Services\Product;

/** Модель */
use Vvintage\Models\Product\Product;
use Vvintage\Repositories\Product\ProductRepository;
use Vvintage\Repositories\Product\ProductTranslationRepository;

/* Service */
use Vvintage\Services\Base\BaseService;
use Vvintage\Services\Product\ProductImageService;
use Vvintage\Services\Category\CategoryService;
use Vvintage\Services\Shared\PaginationService;
use Vvintage\Services\Brand\BrandService;
use Vvintage\Services\Locale\LocaleService;
use Vvintage\Services\Seo\SeoService;

/* DTO */
use Vvintage\DTO\Product\Filter\ProductFilterDTO;
// use Vvintage\DTO\Product\ProductOutputDTO;
use Vvintage\DTO\Product\Page\ProductPageDTO;
use Vvintage\DTO\Product\Page\ProductPageDTOFactory;

use Vvintage\DTO\Product\Card\ProductCardDTO;
use Vvintage\DTO\Product\Card\ProductCardDTOFactory;
use Vvintage\DTO\Product\Card\ImageForProductCardDTO;

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
        $this->repository = new ProductRepository();
        $this->translationRepo = new ProductTranslationRepository();
        $this->categoryService = new CategoryService();
        $this->brandService = new BrandService();
        $this->productImageService = new ProductImageService();
        $this->paginationService = new PaginationService();
        $this->localeService = new LocaleService();
    }

    
    private function createProductCardDTO(?Product $product, ?string $currentLang = null): ProductCardDTO
    {
        $productId = $product->getId();
        $translations = $this->translationRepo->loadTranslations($productId);
        $product->setTranslations($translations);
   
        // Создаем dto для категории и бренда продукта
        $categoryDTO = $this->categoryService->createCategoryProductDTO((int) $product->getCategoryId());
        $brandDTO = $this->brandService->createBrandProductDTO((int) $product->getBrandId());

        // Создаем dto изображения продукта и подготавливаем к отображению 
        $imageDto = $this->productImageService->getMainImageDTO($productId);
  
        $dtoFactory = new ProductCardDTOFactory($this->localeService);
        $dto = $dtoFactory->createFromProduct(
          product: $product,
          category: $categoryDTO,
          brand: $brandDTO,
          image:  $imageDto,
          currentLang: $this->currentLang
        );

        return $dto; 
    }

    private function createProductPageDTO(?Product $product, ?string $currentLang = null): ProductPageDTO
    {
        $productId = $product->getId();
        $translations = $this->translationRepo->loadTranslations($productId);
        $product->setTranslations($translations);
    
        // Создаем dto для категории и бренда продукта
        $categoryDTO = $this->categoryService->createCategoryProductDTO((int) $product->getCategoryId());
        $brandDTO = $this->brandService->createBrandProductDTO((int) $product->getBrandId());

        // Создаем dto изображения продукта и подготавливаем к отображению 
        $imageDto = $this->productImageService->getProductPageImagesDtos($productId);

        $dtoFactory = new ProductPageDTOFactory($this->localeService);
        $dto = $dtoFactory->createFromProduct(
          product: $product,
          category: $categoryDTO,
          brand: $brandDTO,
          images:  $imageDto,
          currentLang: $this->currentLang
        );

        return $dto; 
    }

    public function getProductCartDTO()
    {
      $products = $this->getProductsByIds();

      // Преобразуем в DTO
      return array_map([$this, 'createProductForListDTO'], $products);
    }

    public function getProductsForCatalog(ProductFilterDTO $filters, ?int $perPage = null)
    {
      // Получим отфильтрованные модели продуктов
      $productsData = $this->getFilteredProductsData($filters, $perPage);

      $models = $productsData['products'];
      $total = $productsData['total'];
      $filters = $productsData['filters'];

      // Формируем массив DTO
      $products = array_map([$this, 'createProductCardDTO'], $models);
     
      return ['products' => $products, 'total' => $total, 'filters' => $filters];
    }

   

    public function getProductPageData(int $id) : array
    {
      $product = $this->getProductModelById($id);
      $dto = $this->createProductPageDTO($product);
      
      return [
        'product' => $product ?? null,  
        'dto' => $dto ?? null
      ];
    }

    public function getProductModelById(int $id): ?Product
    {
      $productModel = $this->repository->getModelProductById($id);
      $categoryId = $productModel->getCategoryId();
      $brandId = $productModel->getBrandId();

      $productModel->setCategory( $this->categoryService->getCategoryById($categoryId) );
      $productModel->setBrand( $this->brandService->getBrandById($brandId) );
      $productId  = $productModel->getId();

      return $productModel;
    }

    public function getStatusList(): array {
      return $this->status;
    }


    public function getProductsByIds(array $ids): array
    {
        if (empty($ids)) return [];

        // Изменяем ассоциативный массив - берем только значения
        $ids = array_keys($ids);

        // Получаем все продукты за один запрос
        $products = $this->repository->getProductsByIds($ids);

        if (empty($products)) return [];

        foreach ($products as $product) {
          $translations = $this->translationRepo->loadTranslations($product->getId());
          $product->setTranslations($translations);
        }
        return $products;

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

    /**
     * Returns an array of products based on the given filter.
     * 
     * @param ProductFilterDTO $filters The filter to apply to the products.
     * @param int|null $perPage The number of products to return per page. If null, returns all products.
     * 
     * @return array An array containing the products, filters and total items.
     */
    public function getFilteredProductsData(ProductFilterDTO $filters, ?int $perPage = null): array 
    {
      // Переданы ли категории
      $categories = !empty($filters->categories) ? $filters->categories : null;
  
      // Если да - проверим, одна главная или несколько подкатегорий
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

      // Получаем массив продуктов по фильтру
      $products = $this->repository->getProductsModels(  $filters->toArray() );
 
      // Пагинация
      if( $perPage) {
        $totalItems = count($products);   // Считаем общее кол-во

        // Добавляем данные по пагинации в фильтр
        $filters = $this->addPaginationToFilter($filters, $totalItems, $perPage);

        // Теперь получаем только продукты для этой страницы
        $products = $this->repository->getProductsModels(  $filters->toArray() );
      }

      return [
        'products' => $products,
        'filters' => $filters,
        'total' => $totalItems
      ];
    }

    public function addPaginationToFilter(ProductFilterDTO $filters, int $totalItems, int $perPage)
    {
      $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
      $pagination = $this->paginationService->paginate( totalItems: $totalItems, currentPage: $currentPage, perPage: $perPage);
 
      // Добавляем пагинацию в фильтры
      $filters->pagination['page_number'] = $pagination['current_page'];
      $filters->pagination['perPage'] = $pagination['perPage'];
      $filters->pagination['number_of_pages'] = $pagination['number_of_pages'];
      $filters->pagination['offset'] = $pagination['offset'];

      return $filters;
    }

    // public function setImages(Product $productModel): void 
    // {
    //   $images = $this->productImageService->getProductImages( $productModel->getId());
    //   $productModel->setImages($images);
    // }

    public function getImagesDTO(array $images): array
    {
      return $this->productImageService->getImagesDTOs($images);
    }
   
  
    public function getAll($pagination = []): array
    {
        $rows = $this->repository->getAllProducts(['limit' => $pagination['sql_page_limit'] ?? '']);

        if(empty($rows)) return [];

        return array_map([$this, 'createProductDTOFromArray'], $rows);
    }

    public function getLastProducts(int $count): ?array
    {
      $products = $this->repository->getLastProducts($count);

      foreach( $products as $product) {
        $id = $product->getId();
        $translations = $this->translationRepo->loadTranslations($id);
        $product->setTranslations($translations);
      }

      return $products ? array_map([$this, 'createProductCardDTO'], $products) : null;
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


    protected function uniteProductData(array $data) 
    {
      $products = $this->repository->uniteProductRawData($data);
    }

    public function getFlatImages(array $images) 
    {
      return $this->productImageService->getFlatImages($images);
    }

    

}
