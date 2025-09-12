<?php 
declare(strict_types=1);

namespace Vvintage\Services\Admin\Product;

use Vvintage\Services\Product\ProductService;
use Vvintage\Services\Admin\Product\AdminProductImageService;

/** DTO */
use Vvintage\DTO\Product\ProductInputDTO;
use Vvintage\DTO\Product\ProductImageInputDTO;



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

    public function createProductDraft(array $data, array $images, array $processedImages): int
    {
     
        $data['status'] = 'hidden'; // или draft
        $productDto = $this->createProductInputDto($data);

        $translations = $data['translations'] ?? [];
        $imagesDto = $this->buildImageDtos($processedImages);
    
        $productId = $this->repository->saveProduct($productDto, $translations,  $images, $processedImages);

        if( ! $productId) {
          return null;
        }

        return $productId;
    }

    public function updateProduct(int $id, array $data, array $existingImages, array $processedImages): bool
    {
        // 1. Собираем DTO продукта
        $productDto = $this->createProductInputDto($data);
        $translations = $data['translations'] ?? [];

        // 2. Обновляем сам продукт (текстовые поля, цену и т.п.)
        $updated = $this->repository->updateProductData($id, $productDto, $translations);

        if (! $updated) {
            return false;
        }

        // 2. Удаляем изображения, которых нет в existingImages
        $existingIds = array_column($existingImages, 'id');
         error_log(print_r(  $existingIds, true));
        $this->imageService->deleteImagesNotInList($id, $existingIds);

        // 3. Обновляем порядок оставшихся изображений
        $this->imageService->updateImagesOrder($id, $existingImages);




        // 3. Конвертация изображений в DTO
        $imagesDto = $this->buildImageDtos($processedImages);
        // $imagesDto = [];
    
        // foreach ($processedNewImages as $img) {
        //     if (empty($img)) {
        //         continue;
        //     }

        //     $imagesDto[] = new ProductImageInputDTO([
        //         'filename' => $img['final_full'] ?? '',
        //         'image_order' => $img['image_order'] ?? 0,
        //         'alt' => $img['alt'] ?? '',
        //     ]);
        // }

        // 4. Добавляем новые картинки
        if (!empty($imagesDto)) {
            $this->repository->addProductImages($id, $imagesDto);
        }

        return true;
    }

    // public function updateProduct(int $id, array $data, array $processedNewImages): bool
    // {
    //     // 1. Собираем DTO продукта
    //     $productDto = $this->createProductInputDto($data);
    //     $translations = $data['translations'] ?? [];

    //     // 2. Обновляем сам продукт (текстовые поля, цену и т.п.)
    //     $updated = $this->repository->updateProductData($id, $productDto, $translations);

    //     if (! $updated) {
    //         return false;
    //     }

    //     // 3. Если есть новые картинки → добавляем
    //     if (!empty($processedNewImages)) {
    //         $this->repository->addProductImages($id, $processedNewImages);
    //     }

    //     return true;
    // }



    private function createProductInputDto(array $data): ProductInputDTO
    {
        return new ProductInputDTO([
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
                'datetime' => (new \DateTime())->format('Y-m-d H:i:s'),
                'edit_time' => time()
              ]);
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

    private function buildImageDtos(array $processedImages): array
    {
        $imagesDto = [];

        foreach ($processedImages as $img) {
            if (empty($img)) {
                continue;
            }

            $imagesDto[] = new ProductImageInputDTO([
                'filename'    => $img['final_full'] ?? '',
                'image_order' => $img['image_order'] ?? 0,
                'alt'         => $img['alt'] ?? '',
            ]);
        }

        return $imagesDto;
    }

}
