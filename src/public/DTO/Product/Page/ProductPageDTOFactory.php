<?php
declare(strict_types=1);

namespace Vvintage\Public\DTO\Product\Page;

use Vvintage\Models\Product\Product;

use Vvintage\Utils\Services\Locale\LocaleService;

/* DTO */
use Vvintage\Public\DTO\Category\CategoryForProductDTO;
use Vvintage\Public\DTO\Brand\BrandForProductDTO;



final readonly class ProductPageDTOFactory
{
    public function __construct(
      private LocaleService $localeService
    ) 
    {
      $this->localeService = $localeService;
    }

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
          edit_time: (string) ( $this->localeService->formatDateTime($product->getEditTime()) ),
          images: $images
      );
    }

}
 