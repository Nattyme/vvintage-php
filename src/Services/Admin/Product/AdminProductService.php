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

    public function createProductDraft(array $data, array $images)
    {
        $data['status'] = 'hidden'; // или draft
    //     $imagesDTO =  array_map(fn($image) => new ProductImageDTO($image), $images);
    //  error_log(print_r(   $data, true));
    //  exit();
        $productDto = new ProductInputDTO([
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

        // $productId = $this->repository->create($productDto);
        $productTranslationsDto = [];
    
        foreach($data['translations'] as $locale => $translate) {
            $productTranslationsDto[] = new ProductTranslationInputDTO([
                'product_id' => (int) 1,
                // 'product_id' => (int) $productId,
                'slug' => (string) ($data['slug'] ?? ''),
                'locale' => (string) $locale, 
                'title' => (string) ($translate['title'] ?? ''),
                'description' => (string) ($translate['description'] ?? ''),
                'meta_title' => (string) ($translate['meta_title'] ?? $translate['title'] ?? ''),
                'meta_description' => (string) ($translate['meta_description'] ?? $translate['description'] ?? '')
            ]);
        }


  // error_log(print_r( $images, true));
  // error_log(print_r( $productTranslationsDto, true));
    

        // foreach($productTranslationsDto as $dto) {
        //   $this->saveTranslation($dto);
        // }
  error_log(print_r($images, true));
     exit();
        $imagesDto = [];
        foreach($images as $image) {
          $imagesDto[] = new ProductImageInputDTO([
              'product_id' => (int) 1,
              // 'product_id' => (int) $productId,
              'filename' => (string) ($image['file_name'] ?? ''),
              'image_order' => (int) ($image['image_order'] ?? 1),
              'alt' => $image['alt'] ?? null
          ]);
        }

        foreach($imagesDto as $dto) {
          $this->imageService->saveImage($dto);
        }
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
