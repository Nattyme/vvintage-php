<?php
declare(strict_types=1);

namespace Vvintage\Services\Admin\Product;

use Vvintage\DTO\Product\ProductImageDTO;
use Vvintage\Services\Product\ProductImageService;

final class AdminProductImageService extends ProductImageService
{
  public function __construct()
  {
    parent::__construct();
  }

  public function addImages(int $productId, array $files): array
  {
      $result = ['success' => true, 'images' => []];

      foreach ($files['name'] as $key => $name) {
          $tmpName = $files['tmp_name'][$key];
          $type = $files['type'][$key];

          $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
          if (!in_array($type, $allowedTypes)) {
              return ['success' => false, 'error' => 'Неверный формат изображения'];
          }

          $filename = time() . '_' . $name;
          $uploadPath = "upload/$filename";

          if (!move_uploaded_file($tmpName, $uploadPath)) {
              return ['success' => false, 'error' => 'Ошибка загрузки файла'];
          }

          // Если нужно, можно добавить уменьшение/миниатюру здесь

          $image = R::dispense('image');
          $image->product_id = $productId;
          $image->filename = $filename;
          R::store($image);

          $result['images'][] = $filename;
      }

      return $result;
  }

}
