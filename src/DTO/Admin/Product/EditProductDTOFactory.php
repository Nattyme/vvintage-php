<?php
declare(strict_types=1);

namespace Vvintage\DTO\Admin\Product;

use Vvintage\Models\Product\Product;

use Vvintage\Services\Locale\LocaleService;

use Vvintage\DTO\Admin\Product\EditProductDTO;
use Vvintage\DTO\Brand\BrandForProductDTO;
use Vvintage\DTO\Category\CategoryForProductDTO;
// use Vvintage\DTO\Product\Card\ImageForProductCardDTO;


final class EditProductDTOFactory
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
      BrandForProductDTO $brand,
      array $images
    ): EditProductDTO
    {

      $translations = $product->getTranslations();

      return new EditProductDTO(
        id : (int) ($product->getId() ?? 0),

        category_id: (int) $category->id,
        category_title: (string) $category->title ?? null,
        category_parent_id: (string) $category->parent_id ?? null,

        brand_id: (int) $brand->id,
        brand_title: (string) $brand->title,
     
        slug: (string) ($product->getSlug() ?? ''),
        title: (string) ($product->getTitle() ?? ''),
        description: (string) ($product->getDescription() ?? ''),
        translations: $translations,
        price: (int) ($product->getPrice() ?? ''),
        status: (string) ($product->getStatus() ?? ''),
        
        sku: (string) ($product->getSku() ?? ''),
        url: (string) ($product->getUrl() ?? ''),
        stock: (int) ($product->getStock() ?? 0),
        edit_time: (string) ($product->getEditTime() ?? ''),
        images: $images
      );
    }

}
