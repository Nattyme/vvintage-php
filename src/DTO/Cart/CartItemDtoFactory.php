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

      $translations = (array) $product->getTranslation($currentLang);

      $service = new ProductImageService();
      $image = $service->getMainImageDTO($productId);
      
      // Подставляем дефолтное изображение, если $image = null
      $imageFilename = !empty($image?->filename) ? $image->filename : 'no-photo.jpg';
      $imageAlt = !empty($image?->alt) ? $image->alt : ($translations['title'] ?? $product->getTitle() ?? '');


      return new CartItemDto (
          id: $productId,
          slug: (string) $product->getSlug() ?? '',
          title: (string) ($translations['title'] ?? ''),
          price: (int) ($product->getPrice() ?? null),
     
          image_filename: $imageFilename,
          image_alt: $imageAlt
      );
    }


}
 