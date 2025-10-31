<?php
declare(strict_types=1);

namespace Vvintage\DTO\Product\Card;

use Vvintage\Models\Product\Product;
use Vvintage\DTO\Product\Card\ProductCardDTO;
use Vvintage\DTO\Brand\BrandForProductDTO;
use Vvintage\DTO\Category\CategoryForProductDTO;
use Vvintage\DTO\Product\Card\ImageForProductCardDTO;


final class ProductCardDTOFactory
{

    public function createFromProduct(
      Product $product, 
      CategoryForProductDTO $category, 
      BrandForProductDTO $brand, 
      ImageForProductCardDTO $image, 
      string $currentLang
    ): ProductCardDTO
    {

      $translations = (array) $product->getTranslation('fr');
   
      // Подставляем дефолтное изображение, если $image = null
      $imageFilename = !empty($image?->filename) && file_exists(ROOT . 'usercontent/products/' . $image->filename)  
                      ? $image->filename 
                      : 'products-no-foto.jpg';
      $imageAlt = !empty($image?->alt) ? $image->alt : ($product->getTitle() ?? '');


      return new ProductCardDTO(
          id: (int) $product->getId(),

          category_id: (int) $category->id,
          category_parent_id: (int) $category->parent_id,
          category_title: (string) $category->title,

          brand_id: (int) $brand->id,
          brand_title: (string) $brand->title,

          slug: (string) $product->getSlug() ?? '',
          title: (string) ($translations['title'] ?? ''),
          price: (int) ($product->getPrice() ?? null),
          image_filename: $imageFilename,
          image_alt: $imageAlt
      );
    }

}
 