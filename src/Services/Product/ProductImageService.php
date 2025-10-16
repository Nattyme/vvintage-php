<?php
declare(strict_types=1);

namespace Vvintage\Services\Product;

use Vvintage\DTO\Product\ProductImageDTO;
use Vvintage\DTO\Product\ProductImageInputDTO;
use Vvintage\Repositories\Product\ProductImageRepository;
use Vvintage\DTO\Product\ImageForProductCardDTO;

class ProductImageService
{

  protected ProductImageRepository $repository;

  public function __construct() 
  {
    $this->repository = new ProductImageRepository();
  }
  
  /**
   * Разбивает массив DTO изображений на main и другие, с fallback
   * @param ProductImageDTO[] $images
   * @return array
   */
  public function splitImages(array $images): array
  {

      $mainImage = null;
      $otherImages = [];

      foreach ($images as $img) {
  
          if ($img->image_order === 0 && $mainImage === null) {
              $mainImage = $img;
          } else {
              $otherImages[] = $img;
          }
      }

      if ($mainImage === null && count($otherImages) > 0) {
          $mainImage = array_shift($otherImages);
      }

      return [
          'main' => $mainImage,
          'others' => $otherImages,
      ];
  }

  /**
   * Делит остальные изображения на видимые и скрытые (если понадобится)
   * @param ProductImageDTO[] $otherImages
   * @return array
   */
  public function splitVisibleHidden(array $otherImages): array
  {
      $visible = array_slice($otherImages, 0, 4);
      $hidden = array_slice($otherImages, 4);

      return [
          'visible' => $visible,
          'hidden' => $hidden,
      ];
  }

  public function countAll(array $images): int
  {
    return count($images);
  }

  public function getImageViewData(array $images): array
  {
    
    // Делим массив изображений на два массива - главное и другие
    $mainAndOthers = $this->splitImages($images);
    $gallery = $this->splitVisibleHidden($mainAndOthers['others']);
    $total = $this->countAll($images);

    return [
      'main' =>  $mainAndOthers['main'],
      'others' => $mainAndOthers['others'],
      'gallery' => $gallery,
      'total' => $total
    ];
  }

  public function buildImageDtos(int $productId, array $processedImages): array
  {
      $imagesDto = [];

      foreach ($processedImages as $img) {
          if (!empty($img['id'])) {
              continue; // уже существующие изображения
          }

          if (empty($img['final_full'])) {
              continue; // пустые файлы игнорируем
          }

          $imagesDto[] = new ProductImageInputDTO([
              'product_id' => $productId,
              'filename' => $img['final_full'],
              'image_order' => $img['image_order'] ?? 0,
              'alt' => $img['alt'] ?? '',
          ]);
      }

      return $imagesDto;
  }

  public function createImageDTO (int $productId): array
  {

    $imagesRows = $this->repository->fetchImageDTOs($productId); 
  
     
    return array_map(fn($imageRow) => new ProductImageDTO($imageRow), $imagesRows);
  }

  public function getImagesDTOs (array $images): array
  {
    return array_map(fn($image) => new ProductImageDTO($image), $images);
  }

  public function getMainImage($productId)
  {
    $image = $this->repository->getMainImage((int) $productId);
  }

  public function getMainImageDTO (int $productId): ?ImageForProductCardDTO
  {
    $image = $this->repository->getMainImage($productId); 

    if (!$image) {
        return null;
    }

    return new ImageForProductCardDTO(
        filename: $image['filename'] ?? null,
        alt: $image['alt'] ?? null
    );
  }

   public function getFlatImages(array $data): array 
  {
    $images = [];

    if (!empty($data['main'])) {
        $images[] = $data['main'];
    }

    if (!empty($data['others'])) {
        $images = array_merge($images, $data['others']);
    }

    return $images;

  }

  public function getProductImagesAll(int $productId): array 
  {
    return $this->repository->getAllImages($productId);
  }


}
