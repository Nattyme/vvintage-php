<?php
declare(strict_types=1);

namespace Vvintage\DTO\Product\Page;

use Vvintage\DTO\Category\CategoryForProductDTO;
use Vvintage\DTO\Brand\BrandForProductDTO;
use Vvintage\Models\Product\Product;


final class ProductPageDTOFactory
{

    public function createFromProduct(
      Product $product,
      CategoryForProductDTO $category,
      BrandForProductDTO  $brand,
      array $images,
      string $currentLang
    ): ProductPageDTO
    {

      $translations = (array) $product->getTranslation($currentLang);


      return new ProductPageDTO(
          id: (int) $product->getId(),

          category_id: (int) $category->id,
          category_parent_id: (int) $category->parent_id,
          category_title: (string) $category->title,

          brand_id: (int) $brand->id,
          brand_title: (string) $brand->title,

          slug: (string) $product->getSlug() ?? '',
          title: (string) ($translations['title'] ?? ''),
          description: (string) ($translations['description'] ?? ''),
          price: (int) ($product->getPrice() ?? null),
          edit_time: (string) ($product->getEditTime() ?? null),
          images: $images
      );
    }

}
 