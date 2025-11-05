<?php
declare(strict_types=1);

namespace Vvintage\Public\Services\Product;

use Vvintage\Public\DTO\Product\Image\ProductImageDTO;
use Vvintage\Repositories\Product\ProductImageRepository;
use Vvintage\Public\DTO\Product\Card\ImageForProductCardDTO;
use Vvintage\Public\DTO\Product\Page\ProductPageImageDTO;

class ProductImageService
{

  protected ProductImageRepository $repository;

  public function __construct() 
  {
    $this->repository = new ProductImageRepository();
  }

      /**
     * Преобразовать RedBean OODBBean в ProductImageOutputDTO
     */
    private function createProductPageImageDTO(array $image): ProductPageImageDTO
    {        
        return new ProductPageImageDTO(
            id: (int) $image['id'],
            product_id: (int) $image['product_id'],
            filename: (string) $image['filename'],
            image_order: (int) $image['image_order'],
            alt: (string) $image['alt']
        );
    }

  
 

  public function getProductPageImagesDtos(int $poductId): array
  {
    $images = $this->getProductImagesAll($poductId);

    $imagesDtos = array_map([$this, 'createProductPageImageDTO'], $images);
  
    // Делим массив изображений на два массива - главное и другие
    $mainAndOthers = $this->splitImages($imagesDtos);
    $gallery = $this->splitVisibleHidden($mainAndOthers['others']);
    $total = $this->countAll($images);

    return [
      'main' =>  $mainAndOthers['main'],
      'others' => $mainAndOthers['others'],
      'gallery' => $gallery,
      'total' => $total
    ];
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

  public function getProductImagesAll(int $productId): array 
  {
    return $this->repository->getAllImages($productId);
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



  public function createImageDTO (int $productId): array
  {

    $imagesRows = $this->repository->fetchImageDTOs($productId); 
  
     
    return array_map(fn($imageRow) => new ProductImageDTO($imageRow), $imagesRows);
  }

  public function getImagesDTOs (array $images): array
  {
    return array_map(fn($image) => new ProductImageDTO($image), $images);
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

  


}
