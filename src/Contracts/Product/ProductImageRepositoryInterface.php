<?php

declare(strict_types=1);

namespace Vvintage\Contracts\Product;

use Vvintage\Models\Product\Product;
use Vvintage\DTO\Product\ProductDTO;
use Vvintage\DTO\Product\ProductInputDTO;
use Vvintage\DTO\Product\ProductImageOutputDTO;
use Vvintage\DTO\Product\ProductImageInputDTO;

use Vvintage\DTO\Product\ProductFilterDTO;

interface ProductImageRepositoryInterface
{
  /**
     * Получить все изображения продукта, отсортированные по порядку
  */
  public function getAllImages(int $product_id): array;

  /**
   * Получить изображение по id
  */
  public function getImageById(int $id): ?ProductImageOutputDTO;

  /**
   * Добавить новое изображение продукта
   */
  public function addImage(ProductImageInputDTO $input): ProductImageOutputDTO;
   
  /**
     * Обновить существующее изображение
  */
  public function updateImage(int $id, ProductImageInputDTO $input): ProductImageOutputDTO;

  /**
   * Удалить одно изображение
   */
  public function removeImage(int $id): void;


  /**
     * Удалить все изображения продукта
  */
  public function removeAllImages(int $product_id): void;
  public function deleteImagesNotInList(int $productId, array $keepIds): void;
  public function updateImagesOrder(int $productId, array $images): void;
}
