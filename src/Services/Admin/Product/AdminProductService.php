<?php 
declare(strict_types=1);

namespace Vvintage\Services\Admin\Product;

use Vvintage\Config\LanguageConfig;

/** Модель */
use Vvintage\Models\Product\Product;

use Vvintage\Services\Product\ProductService;
use Vvintage\Services\Brand\BrandService;
use Vvintage\Services\Category\CategoryService;
use Vvintage\Services\Admin\Product\AdminProductImageService;

/** DTO */
use Vvintage\DTO\Product\Filter\ProductFilterDTO;
use Vvintage\DTO\Admin\Product\EditProductDTOFactory;
use Vvintage\DTO\Admin\Product\ProductAdminListDTOFactory;
use Vvintage\DTO\Admin\Product\ProductAdminListDTO;
use Vvintage\DTO\Admin\Product\EditProductDTO;
use Vvintage\DTO\Admin\Product\ProductInputDTO;
use Vvintage\DTO\Admin\Product\ProductImageInputDTO;

use Vvintage\DTO\Product\Lang\ProductTranslationInputDTO;



final class AdminProductService extends ProductService
{
  private AdminProductImageService $imageService;
  private string $defaultLang;

  private array $actions = [
    'hide'     => 'Скрыть',
    'show'     => 'Показать',
    'archived' => 'В архив'
  ];

  

  public function __construct()
  {
    parent::__construct();
    $this->imageService = new AdminProductImageService();
    $this->defaultLang = LanguageConfig::DEFAULT_LANG;
  }


  /** CRUD */
  public function createProductDraft(array $data, array $images): int
  {
    
      $data['status'] = 'hidden'; // или draft
      $tmpFilesToCleanup = [];

      $this->repository->begin(); // начало транзакции

      try {
        $productDto = $this->createProductInputDto($data);
        $productId = $this->repository->saveProduct($productDto);

        if( !$productId) {
          throw new RuntimeException("Не удалось создать продукт");
          return null;
        }

     
        if (!empty($data['translations'])) {
            $translateDto = $this->createTranslateInputDto($data['translations'], $productId);
            $this->translationRepo->saveProductTranslation($translateDto);
        }
  
        // 3. Подготавливаем изображения (tmp + resize)
        $imagesTMP = $this->imageService->prepareImages($images);

        // Собираем tmp-файлы для возможного удаления при ошибке
        foreach ($imagesTMP as $img) {
            $tmpFilesToCleanup[] = $img['tmp_full'];
            $tmpFilesToCleanup[] = $img['tmp_small'];
        }

        // 4. Сохраняем новые изображения, если есть
        $imagesDto = $this->imageService->createProductImageInputDTO($productId, $imagesTMP);

        if (!empty($imagesDto)) {
            $this->imageService->updateImages($imagesDto);
        }

        // 6. Подтверждаем транзакцию
        $this->repository->commit();

        // 7. Переносим файлы в финальную папку (только после успешного commit)
        if (!empty($imagesTMP)) {
            $finalPaths = $this->imageService->finalizeImages($imagesTMP);
            $this->imageService->cleanup($imagesTMP);
        }

        return $productId;

      }
      catch (\Throwable $error) 
      {
        $this->repository->rollback();
        throw $error;
      }
     
  }

  public function updateProduct(int $id, array $data, array $existingImages, array $processedImages): bool 
  {
      $tmpFilesToCleanup = [];

      $this->repository->begin(); // начало транзакции

      try {
          // 1. Обновляем продукт
          $productDto = $this->createProductInputDto($data);
          $this->repository->updateProductData($id, $productDto->toArray());
          // $this->repository->updateProductData($id, $productDto);

          // 2. Обновляем перевод продукта
          if (!empty($data['translations'])) {
              $translateDto = $this->createTranslateInputDto($data['translations'], $id);
              $this->translationRepo->saveProductTranslation($translateDto);
          }

          // 3. Подготавливаем изображения (tmp + resize)
          $imagesTMP = $this->imageService->prepareImages($processedImages);

          // Собираем tmp-файлы для возможного удаления при ошибке
          foreach ($imagesTMP as $img) {
              $tmpFilesToCleanup[] = $img['tmp_full'];
              $tmpFilesToCleanup[] = $img['tmp_medium'];
              $tmpFilesToCleanup[] = $img['tmp_small'];
          }


          // 5. Удаляем старые изображения, которых больше нет в форме
          $keepIds = array_column($existingImages, 'id');
          $imagesInDb = $this->imageService->getProductImagesAll($id); // получаем мапссив всех изображений из БД

          $idsDb = array_map(fn($img) => $img['id'], $imagesInDb);
          // $idsDb = array_map(fn($img) => $img->id, $imagesInDb);
          $idsToDelete = array_diff($idsDb, $keepIds); //  массив id изображений для удаления в БД

    

          if (!empty($idsToDelete)) {
              // достаём имена файлов по этим id
              $imagesToDelete = array_filter(
                  $imagesInDb,
                  fn($img) => in_array($img['id'], $idsToDelete)
              );

              // удаляем из БД
              $this->imageService->deleteImagesNotInList($id, $keepIds);

              // удаляем файлы
              $this->imageService->cleanupFinal($imagesToDelete);
          }

           // 4. Сохраняем новые изображения, если есть
          $newImagesDto = $this->imageService->createProductImageInputDTO($id, $imagesTMP);
         
          if (!empty($newImagesDto)) {
              $this->imageService->updateImages($newImagesDto);
          }

  
          // 5. Обновляем порядок существующих изображений, если есть
          if (!empty($existingImages)) {
              $this->imageService->updateImagesOrder($id, $existingImages);
          }

          // 6. Подтверждаем транзакцию
          $this->repository->commit();

          // 7. Переносим файлы в финальную папку (только после успешного commit)
          if (!empty($imagesTMP)) {
              $finalPaths = $this->imageService->finalizeImages($imagesTMP);
              $this->imageService->cleanup($imagesTMP);
          }

          return true;

      } catch (\Throwable $error) {
          $this->repository->rollback();

          // удаляем tmp-файлы
          $this->imageService->cleanup($imagesTMP);

          throw $error;
      }
  }

  public function getAdminProductsList(ProductFilterDTO $filters, ?int $perPage = null): array 
  {
    // Получим отфильтрованные модели продуктов 
    $productsData = $this->getFilteredProductsData($filters, $perPage);

    $models = $productsData['products'];
    $total = $productsData['total'];
    $filters = $productsData['filters'];

    // Формируем массив DTO
    $products = array_map([$this, 'createProductAdminListDTO'], $models);
  
    return ['products' => $products, 'total' => $total, 'filters' => $filters]; 
  }

  public function getAdminEditProduct(int $id): EditProductDTO 
  {
    $product = $this->getProductModelById($id);
    return $this->createEditProductDTO($product);
  }


  /** images */ 
  private function splitVisibleHidden(array $images): array
  {
      return  $this->productImageService->splitVisibleHidden($images);
  }

  public function getProductsImages(array $products): array
  {
      $imagesByProductId = [];

      foreach ($products as $product) {
          $imagesMainAndOthers = $this->productImageService->splitImages($product->images);
          $imagesByProductId[$product->getId()] = $imagesMainAndOthers;
      }

      return $imagesByProductId;
  }

  public function addImages(int $productId, array $files): array
  {
    return $this->imageService->addImages($productId, $files);
  }



  /** dto */
  private function createProductInputDto(array $data): ProductInputDTO
  {
      $isNew = empty($data['id']); // если id нет — новый продукт

      $dataDto = new ProductInputDTO([
              'category_id' => (int) ($data['category_id'] ?? 1),
              'brand_id' => (int) ($data['brand_id'] ?? 1),
              'slug' => (string) ($data['slug'] ?? ''),
              'title' => (string) ($data['title'] ?? ''),
              'description' => (string) ($data['description'] ?? ''),
              'price' => (int) ((int) $data['price'] ?? 0),
              'sku' => (string) ($data['sku'] ?? ''),
              'stock' => (int) ( (int) $data['stock'] ?? 0),
              'url' => (string) ($data['url'] ?? ''),
              'status' => (string) ($data['status'] ?? ''),
              'edit_time' => time()
            ]);

      if ($isNew) {
          $dataDto->datetime = new \DateTime();
      }

      return $dataDto;

  }

  private function createTranslateInputDto(array $data, int $productId): array
  {
    $productTranslationsDto = [];

    foreach($data as $locale => $translate) {
        $productTranslationsDto[] = new ProductTranslationInputDTO([
            'product_id' => (int) ($productId ?? 0),
            'slug' => (string) ($translate['slug'] ?? ''),
            'locale' => (string) $locale, 
            'title' => (string) ($translate['title'] ?? ''),
            'description' => (string) ($translate['description'] ?? ''),
            'meta_title' => (string) ($translate['meta_title'] ?? $translate['title'] ?? ''),
            'meta_description' => (string) ($translate['meta_description'] ?? $translate['description'] ?? '')
        ]);
    }
        
    return  $productTranslationsDto;

  }

  /**
   * Создает dto для админки продукта
   *
   * @param Product $product
   * @return ProductAdminListDTO
 */
  private function createProductAdminListDTO(Product $product): ProductAdminListDTO
  {
      // Получим и установим перевод
      $productId = $product->getId();
      $translations = $this->translationRepo->getLocaleTranslation($productId, $this->defaultLang);
      $product->setTranslations($translations);

      // Создаем dto 
      $brandDTO = $this->brandService->createBrandProductDTO((int) $product->getBrandId());
      $categoryDTO = $this->categoryService->createCategoryProductDTO((int) $product->getCategoryId());
      $imageDto = $this->productImageService->getMainImageDTO($productId);
      
      $dtoFactory = new ProductAdminListDTOFactory($this->localeService);
      $dto = $dtoFactory->createFromProduct(
        product: $product,
        category: $categoryDTO,
        brand: $brandDTO,
        image:  $imageDto
      );

      return $dto; 
  }

  private function createEditProductDTO(Product $product): EditProductDTO
  {
      // Получим и установим перевод
      $productId = $product->getId();
      $translations = $this->translationRepo->loadTranslations($productId);
      $product->setTranslations($translations);

   
      // Создаем dto для категории и бренда продукта
      $categoryDTO = $this->categoryService->createCategoryProductDTO((int) $product->getCategoryId());
      $brandDTO = $this->brandService->createBrandProductDTO((int) $product->getBrandId());

      // Создаем dto изображения продукта и подготавливаем к отображению 
      $images = $this->productImageService->getProductImagesAll($productId);
      
      $dtoFactory = new EditProductDTOFactory($this->localeService);
      $dto = $dtoFactory->createFromProduct(
        product: $product,
        category: $categoryDTO,
        brand: $brandDTO,
        images:  $images
      );

      return $dto; 
  }



  // filter actions
  public function applyAction(int $productId, string $action): bool
  {
      switch ($action) {
          case 'hide':
              return $this->hideProduct($productId);
          case 'show':
              return $this->publishProduct($productId);
          case 'archived':
              return $this->archiveProduct($productId, false);
          default:
              return false;
      }
  }

  public function getActionList(): array
  {
      return $this->actions;
  }

  public function handleStatusAction(array $data): void 
  {

      if ( 
        isset($data['action-submit']) && 
        (isset($data['action']) && !empty($data['action'])) &&
        (isset($data['products']) && !empty($data['products'])) ) {
        $action = $data['action'];

        foreach ($data['products'] as $key=> $productId) {
          $this->applyAction((int) $productId, $action);
        }

      }

  }

  // change product status
  public function getActions(): array 
  {
    return $this->actions;
  }


  /* CHANGE STATUS */
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

}
