<?php
declare(strict_types=1);

namespace Vvintage\Services\Product;

use Vvintage\DTO\Product\ProductImageDTO;
use Vvintage\DTO\Product\ProductImageInputDTO;
use Vvintage\Repositories\Product\ProductImageRepository;

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
          if ($img->image_order === 1 && $mainImage === null) {
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

  public function createImageDTO (array $row): array
  {
    $imagesRows = $this->repository->fetchImageDTOs($row); 
    return array_map(fn($imageRow) => new ProductImageDTO($imageRow), $imagesRows);
  }


  // public function buildImageDtos(array $processedImages): array
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

 

}
