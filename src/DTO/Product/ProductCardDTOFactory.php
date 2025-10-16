<?php
declare(strict_types=1);

namespace Vvintage\DTO\Product;

use Vvintage\Models\Product\Product;
use Vvintage\DTO\Product\ProductCardDTO;
use Vvintage\DTO\Brand\BrandForProductDTO;
use Vvintage\DTO\Category\CategoryForProductDTO;

final class ProductCardDTOFactory
{

    public function createFromProduct(
      Product $product, 
      CategoryForProductDTO $category, 
      BrandForProductDTO $brand, 
      array $images, 
      string $currentLang
    ): ProductCardDTO
    {
      $translations = (array) $product->getTranslations($currentLang) ?? [];

      return new ProductCardDTO(
          id: (int) $product->getId(),

          category_id: (int) $category->id,
          category_parent_id: (int) $category->parent_id,
          category_title: (string) $category->title,

          brand_id: (int) $brand->id,
          brand_title: (string) $brand->title,

          slug: (string) $product->getSlug() ?? '',
          title: (string) ($translations['title'] ?? ''),
          price: (string) ($product->getPrice() ?? ''),
          images: (string) ($product->getImages() ?? ''),
      );
    }

}
 // 'id' => $row['id'],
  //         'category_id' => $categoryDTO->id,
  //         'category_title' => $categoryDTO->title,
  //         'category_parent_id' => $categoryDTO->parent_id,
  //         'brand_id' => $brandDTO->id,
  //         'brand_title' => $brandDTO->title,
  //         'slug' => $row['slug'],
  //         'title' => $translations[$this->currentLang]['title'] ?? $translations['title'],
  //         'description' => $translations[$this->currentLang]['description'] ?? $translations['description'],
  //         'price' => $row['price'],
  //         'url' => $row['url'],
  //         'sku' => $row['sku'],
  //         'stock' => $row['stock'],
  //         'datetime' => $row['datetime'],

  //         'status' => $row['status'],
  //         'edit_time' => $row['edit_time'],
  //         'images' => $images,
  //         'translations' => $translations