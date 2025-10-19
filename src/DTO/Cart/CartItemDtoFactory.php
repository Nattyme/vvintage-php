<?php
declare(strict_types=1);

namespace Vvintage\DTO\Cart;
use Vvintage\Models\Product\Product;
use Vvintage\Services\Product\ProductImageService;
use Vvintage\DTO\Product\ImageForProductCardDTO;
use Vvintage\DTO\Cart\CartItemDto;


final class CartItemDTOFactory
{
    public function createFromProduct(
      Product $product,
      string $currentLang
    ): CartItemDto
    {
      $productId = (int) $product->getId();

      $service = new ProductImageService();
      $image = $service->getMainImageDTO($productId);

      $translations = (array) $product->getTranslation($currentLang);

      return new CartItemDto (
          id: $productId,
          slug: (string) $product->getSlug() ?? '',
          title: (string) ($translations['title'] ?? ''),
          price: (int) ($product->getPrice() ?? null),
     
          image_filename: $image->filename,
          image_alt: $image->alt
      );
    }


}
 