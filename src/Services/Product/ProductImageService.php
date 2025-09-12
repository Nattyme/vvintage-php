<?php
declare(strict_types=1);

namespace Vvintage\Services\Product;

use Vvintage\DTO\Product\ProductImageDTO;
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

 

}
