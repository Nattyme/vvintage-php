<?php
declare(strict_types=1);

namespace Vvintage\DTO\Admin\Product;

use Vvintage\Models\Product\Product;

use Vvintage\Services\Locale\LocaleService;

use Vvintage\DTO\Admin\Product\ProductAdminListDTO;
use Vvintage\DTO\Brand\BrandForProductDTO;
use Vvintage\DTO\Category\CategoryForProductDTO;
use Vvintage\DTO\Product\Card\ImageForProductCardDTO;


final class ProductAdminListDTOFactory
{
    public function __construct(
      private LocaleService $localeService
    ) 
    {
      $this->localeService = $localeService;
    }

    public function createFromProduct(
      Product $product, 
      BrandForProductDTO $brand,
      CategoryForProductDTO $category,
      ImageForProductCardDTO $image
    ): ProductAdminListDTO
    {

      // Подставляем дефолтное изображение, если $image = null
      $imageFilename = !empty($image?->filename) && file_exists(ROOT . 'usercontent/products/' . $image->filename) 
                        ? $image->filename 
                        : 'no-photo.jpg';
      $imageAlt = !empty($image?->alt) ? $image->alt : ($product->getTitle() ?? '');
      $translations = $product->getTranslations();


      return new ProductAdminListDTO(
          id: (int) $product->getId(),
          title: (string) ($translations['title'] ?? ''),
          brand_title: (string) $brand->title,
          category_title: (string) $category->title,
          price: (int) ($product->getPrice()),
          url: (string) ($product->getUrl() ?? null),
          status: (string) ( $product->getStatus()),
          edit_time: (string) ( $this->localeService->formatDateTime($product->getEditTime()) ),
          image_filename: $imageFilename
      );
    }

}
 