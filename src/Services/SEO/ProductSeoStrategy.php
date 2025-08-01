<?php
declare(strict_types=1);

namespace Vvintage\Services\SEO;

use Vvintage\Contracts\SeoStrategyInterface;


class ProductSeoStrategy implements SeoStrategyInterface
{
    private $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    public function getSeo(): SeoDTO
    {
        // Используем данные из продукта, например, его поля
        $meta = $this->product->translations[$this->product->currentLocale] ?? [];

        return new SeoDTO(
            $meta['meta_title'] ?? $this->product->seo_title ?? '',
            $meta['meta_description'] ?? $this->product->seo_description ?? ''
        );
    }
}
