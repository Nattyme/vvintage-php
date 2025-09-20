<?php 
declare(strict_types=1);

namespace Vvintage\Services\Admin\Product;

use Vvintage\Services\Product\ProductService;
use Vvintage\Services\Admin\Product\AdminProductImageService;

/** DTO */
use Vvintage\DTO\Product\ProductInputDTO;
use Vvintage\DTO\Product\ProductImageInputDTO;

use Vvintage\DTO\Product\ProductTranslationInputDTO;



final class AdminProductService extends ProductService
{

  private AdminProductImageService $imageService;

  private array $actions = [
    'hide'     => 'Скрыть',
    'show'     => 'Показать',
    'archived' => 'В архив'
  ];

  public function __construct()
  {
    parent::__construct();
    $this->imageService = new AdminProductImageService();
  }

  
  private function splitVisibleHidden(array $images): array
  {
      return  $this->productImageService->splitVisibleHidden($images);
  }

  public function getActions(): array 
  {
    return $this->actions;
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


 
  public function updateProduct(int $id, array $data, array $existingImages, array $processedImages): bool 
  {
      $tmpFilesToCleanup = [];

      $this->repository->begin(); // начало транзакции

      try {
          // 1. Обновляем продукт
          $productDto = $this->createProductInputDto($data);
          $this->repository->updateProductData($id, $productDto);

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
              $tmpFilesToCleanup[] = $img['tmp_small'];
          }


          // 5. Удаляем старые изображения, которых больше нет в форме
          $keepIds = array_column($existingImages, 'id');
          $imagesInDb = $this->imageService->getProductImagesAll($id); // получаем мапссив DTO всех изображений из БД
          // error_log(print_r(   $imagesInDb, true));
          $idsDb = array_map(fn($img) => $img->id, $imagesInDb);
          $idsToDelete = array_diff($idsDb, $keepIds); //  массив id изображений для удаления в БД

           // 4. Сохраняем новые изображения, если есть
          $newImagesDto = $this->imageService->buildImageDtos($id, $imagesTMP);
         
          if (!empty($newImagesDto)) {
              $this->imageService->updateImages($newImagesDto);
          }


          if (!empty($idsToDelete)) {
              // достаём имена файлов по этим id
              $imagesToDelete = array_filter(
                  $imagesInDb,
                  fn($img) => in_array($img->id, $idsToDelete)
              );
    // error_log(print_r($imagesToDelete, true));
              // удаляем из БД
              $this->imageService->deleteImagesNotInList($id, $keepIds);

              // удаляем файлы
              $this->imageService->cleanupFinal($imagesToDelete);
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
  // public function updateProduct(int $id, array $data, array $existingImages, array $processedImages): bool 
  // {
  //     $tmpFilesToCleanup = [];

  //     $this->repository->begin(); // начало транзакции

  //     try {
  //         // 1. Обновляем продукт
  //         $productDto = $this->createProductInputDto($data);
  //         $this->repository->updateProductData($id, $productDto);

  //         // 2. Обновляем перевод продукта
  //         if (!empty($data['translations'])) {
  //             $translateDto = $this->createTranslateInputDto($data['translations'], $id);
  //             $this->translationRepo->saveProductTranslation($translateDto);
  //         }

  //         // 3. Подготавливаем изображения (tmp + resize)
  //         $imagesTMP = $this->imageService->prepareImages($processedImages);

  //         // Собираем tmp-файлы для возможного удаления при ошибке
  //         foreach ($imagesTMP as $img) {
  //             $tmpFilesToCleanup[] = $img['tmp_full'];
  //             $tmpFilesToCleanup[] = $img['tmp_small'];
  //         }

  //         // 4. Сохраняем новые изображения, если есть
  //         $newImagesDto = $this->imageService->buildImageDtos($id, $imagesTMP);
         
  //         if (!empty($newImagesDto)) {
  //             $this->imageService->updateImages($newImagesDto);
  //         }

  //         // 5. Удаляем старые изображения, которых больше нет в форме
  //         $keepIds = array_column($existingImages, 'id');
  //         $imagesInDb = $this->imageService->getProductImagesAll($id); // получаем мапссив DTO всех изображений из БД
  //         // error_log(print_r(   $imagesInDb, true));
  //         $idsDb = array_map(fn($img) => $img->id, $imagesInDb);
  //         $idsToDelete = array_diff($idsDb, $keepIds); //  массив id изображений для удаления в БД

  //         if (!empty($idsToDelete)) {
  //             // достаём имена файлов по этим id
  //             $imagesToDelete = array_filter(
  //                 $imagesInDb,
  //                 fn($img) => in_array($img->id, $idsToDelete)
  //             );
  //   // error_log(print_r($imagesToDelete, true));
  //             // удаляем из БД
  //             $this->imageService->deleteImagesNotInList($id, $keepIds);

  //             // удаляем файлы
  //             $this->imageService->cleanupFinal($imagesToDelete);
  //         }
     

  
  //         // 5. Обновляем порядок существующих изображений, если есть
  //         if (!empty($existingImages)) {
  //             $this->imageService->updateImagesOrder($id, $existingImages);
  //         }

  //         // 6. Подтверждаем транзакцию
  //         $this->repository->commit();

  //         // 7. Переносим файлы в финальную папку (только после успешного commit)
  //         if (!empty($imagesTMP)) {
  //             $finalPaths = $this->imageService->finalizeImages($imagesTMP);
  //             $this->imageService->cleanup($imagesTMP);
  //         }

  //         return true;

  //     } catch (\Throwable $error) {
  //         $this->repository->rollback();

  //         // удаляем tmp-файлы
  //         $this->imageService->cleanup($imagesTMP);

  //         throw $error;
  //     }
  // }

  public function createProductDraft(array $data, array $images, array $processedImages): int
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
        $imagesTMP = $this->imageService->prepareImages($processedImages);

        // Собираем tmp-файлы для возможного удаления при ошибке
        foreach ($imagesTMP as $img) {
            $tmpFilesToCleanup[] = $img['tmp_full'];
            $tmpFilesToCleanup[] = $img['tmp_small'];
        }

        // 4. Сохраняем новые изображения, если есть
        $imagesDto = $this->imageService->buildImageDtos($productId, $imagesTMP);

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

  public function addImages(int $productId, array $files): array
  {
    return $this->imageService->addImages($productId, $files);
  }

}
