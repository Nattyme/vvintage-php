<?php
declare(strict_types=1);

namespace Vvintage\DTO\Cart;
use Vvintage\Models\Product\Product;


final class CartItemDtoFactory
{

    public function createFromProduct(
      Product $product,
      array $images,
      string $currentLang
    ): ProductPageDTO
    {

      $translations = (array) $product->getTranslation($currentLang);


      return new CartItemDto (
          id: (int) $product->getId(),

    
          slug: (string) $product->getSlug() ?? '',
          title: (string) ($translations['title'] ?? ''),
          description: (string) ($translations['description'] ?? ''),
          price: (int) ($product->getPrice() ?? null),
          edit_time: (string) ($product->getEditTime() ?? null),
          images: $images
      );
    }

}
 