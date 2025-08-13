<?php 
declare(strict_types=1);

namespace Vvintage\Services\Admin;

use Vvintage\Services\Product\ProductService;


final class AdminProductService extends ProductService
{

    public function __construct(string $currentLang)
    {
      parent::__construct($currentLang);
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
}
