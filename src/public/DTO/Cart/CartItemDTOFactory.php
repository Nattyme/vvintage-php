<?php
declare(strict_types=1);

namespace Vvintage\Public\DTO\Cart;

use Vvintage\Models\Product\Product;
use Vvintage\Public\Services\Product\ProductImageService;
use Vvintage\Public\DTO\Product\ImageForProductCardDTO;
use Vvintage\Public\DTO\Cart\CartItemDTO;


final readonly class CartItemDTOFactory
{
    public function createFromProduct(
      Product $product,
      string $currentLang
    ): CartItemDTO
    {
      $productId = (int) $product->getId();

      $translations = (array) $product->getTranslation($currentLang);

      $service = new ProductImageService();
      $image = $service->getMainImageDTO($productId);
      
      // Подставляем дефолтное изображение, если $image = null
      $imageFilename = !empty($image?->filename) ? $image->filename : 'no-photo.jpg';
      $imageAlt = !empty($image?->alt) ? $image->alt : ($translations['title'] ?? $product->getTitle() ?? '');


      return new CartItemDTO (
          id: $productId,
          slug: (string) $product->getSlug() ?? '',
          title: (string) ($translations['title'] ?? ''),
          price: (int) ($product->getPrice() ?? null),
     
          image_filename: $imageFilename,
          image_alt: $imageAlt
      );
    }


}
 