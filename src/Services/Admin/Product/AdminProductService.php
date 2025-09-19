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
            $imagesMainAndOthers = $this->productImageService->splitImages($products->images);
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

    public function createProductDraft(array $data, array $images, array $processedImages): int
    {
     
        $data['status'] = 'hidden'; // или draft
        $productDto = $this->createProductInputDto($data);

        $translations = $data['translations'] ?? [];
        // $imagesDto = $this->imageService->buildImageDtos($processedImages);
    
        $productId = $this->repository->saveProduct($productDto, $translations,  $images, $processedImages);

        if( ! $productId) {
          return null;
        }

        return $productId;
    }
    public function updateProduct(int $id, array $data, array $existingImages, array $processedImages): bool 
{
    // Массив для временных файлов, чтобы их удалить при ошибке
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
        $sizes = [
            'full'  => [536, 566],
            'small' => [350, 478]
        ];

        $imagesTMP = $this->imageService->prepareImages($processedImages, $sizes);

        // Собираем tmp-файлы для возможного удаления при ошибке
        foreach ($imagesTMP as $img) {
            $tmpFilesToCleanup[] = $img['tmp_full'];
            $tmpFilesToCleanup[] = $img['tmp_small'];
        }

        // 4. Сохраняем имена изображений в БД
        $imagesDto = $this->imageService->buildImageDtos($id, $imagesTMP);
        if (empty($imagesDto)) {
            throw new \RuntimeException("Нет изображений для сохранения в БД");
        }
        $this->imageService->updateImages($imagesDto);

        // 5. Обновляем существующие изображения, если нужно
        $this->imageService->updateImagesOrder($id, $existingImages);

        // 6. Всё ок — подтверждаем транзакцию
        $this->repository->commit();

        // 7. Переносим файлы в финальную папку (только после успешного commit)
        $finalPaths = $this->imageService->finalizeImages($imagesTMP);

        // 8. Удаляем tmp-файлы
        $this->imageService->cleanup($imagesTMP);

        return true;

    } catch (\Throwable $error) {
        // откатываем БД
        $this->repository->rollback();

        // удаляем tmp-файлы
        foreach ($tmpFilesToCleanup as $file) {
            @unlink($file);
        }

        throw $error; // пробрасываем дальше
    }
}


    // public function updateProduct(int $id, array $data, array $existingImages, array $processedImages): bool 
    // {
    //   $this->repository->begin(); // начало транзакции

    //   try {
    //     // 1. Создаём продукт
    //     $productDto = $this->createProductInputDto($data);
    //     $this->repository->updateProductData($id, $productDto);

    //     // 2. Создаём перевод продукта
    //     if(!empty($data['translations'])) {
    //       $translateDto = $this->createTranslateInputDto($data['translations'], $id);
    //       $this->translationRepo->saveProductTranslation($translateDto);
    //     }

    //     // 3. Сохраняем изображения продукта
    //     $sizes = [
    //       'full' => [536, 566],
    //       'small' => [350, 478]
    //     ];
     
    //     $imagesTMP = $this->imageService->prepareImages($processedImages, $sizes); // tmp + resize

    //     // Сохраняем имена файлов в массив для возможного отката
    //     foreach ($imagesTMP as $img) {
    //         $filesToCleanup[] = $img['tmp_full'];
    //         $filesToCleanup[] = $img['tmp_small'];
    //     }


    //     $this->imageService->saveProductImages($id, $imagesTMP); // сохраняем имена в БД
    //     $finalPaths = $this->imageService->finalizeImages($imagesTMP);
    //     $this->imageService->cleanup($imagesTMP);    
    //     // $imagesDto = $this->imageService->buildImageDtos($id, $processedImages);
    //     // $this->imageService->updateImages($imagesDto);


    //     $this->repository->commit(); // если всё ок
    //     return true;

    //   }
    //   catch (\Throwable $error) {
    //     $this->repository->rollback(); // транзакция откатывает все изменения

    //     // tmp
    //     foreach ($imagesTMP as $img) {
    //         @unlink($img['tmp_full']);
    //         @unlink($img['tmp_small']);
    //     }

    //     // финальные
    //     foreach ($finalPaths ?? [] as $fp) {
    //         @unlink($this->imageService->finalFolder . $fp['filename']);
    //         @unlink($this->imageService->finalFolder . $fp['filename_small']);
    //     }


    //     throw $error;
    //   }
    // }

 
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
              'product_id' => (int) $productId,
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

    // private function buildImageDtos(array $processedImages): array
    // {
    //     $imagesDto = [];

    //     foreach ($processedImages as $img) {
    //         // если изображение уже в базе — пропускаем
    //         if (!empty($img['id'])) {
    //             continue;
    //         }

    //         if (empty($img['final_full'])) {
    //             continue; // пустой файл игнорируем
    //         }

    //         $imagesDto[] = new ProductImageInputDTO([
    //             'filename' => $img['final_full'],
    //             'image_order' => $img['image_order'] ?? 0,
    //             'alt' => $img['alt'] ?? '',
    //         ]);
    //     }

    //     return $imagesDto;
    // }


    // private function buildImageDtos(array $processedImages): array
    // {
    //     $imagesDto = [];

    //     foreach ($processedImages as $img) {
    //         if (empty($img)) {
    //             continue;
    //         }

    //         $imagesDto[] = new ProductImageInputDTO([
    //             'filename'    => $img['final_full'] ?? '',
    //             'image_order' => $img['image_order'] ?? 0,
    //             'alt'         => $img['alt'] ?? '',
    //         ]);
    //     }

    //     return $imagesDto;
    // }

    // public function saveBrand(BrandInputDTO $dto, array $translations): int
    // {
    //     $this->brandRepo->begin();

    //     try {
    //         $brandId = $this->brandRepo->save($dto);
    //         $this->translationRepo->saveTranslations($brandId, $translations);

    //         $this->brandRepo->commit();
    //         return $brandId;
    //     } catch (\Throwable $e) {
    //         $this->brandRepo->rollback();
    //         throw $e;
    //     }
    // }
      
  

}
