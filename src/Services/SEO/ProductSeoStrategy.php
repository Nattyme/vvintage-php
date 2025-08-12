<?php
declare(strict_types=1);

namespace Vvintage\Services\SEO;

use Vvintage\Contracts\SeoStrategyInterface;
use Vvintage\DTO\Common\SeoDTO;


class ProductSeoStrategy implements SeoStrategyInterface
{
    private $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    public function getSeo(): SeoDTO
    {
      $locale = $this->product->getCurrentLocale();
      $translations = $this->product->getTranslations();

        // Используем данные из продукта
        $meta = $translations [ $locale ] ?? [];

        return new SeoDTO(
            $meta['meta_title'] ?? $meta['title'] ?? '',
            $meta['meta_description'] ?? $meta['description'] ?? ''
        );
    }

    public function getStructuredData(): string
    {
        $locale = $this->product->getCurrentLocale();
        $translations = $this->product->getTranslations();
        $meta = $translations[$locale] ?? [];

        $data = [
            "@context" => "https://schema.org",
            "@type" => "Product",
            "name" => $meta['title'] ?? '',
            "description" => $meta['description'] ?? '',
            "brand" => [
                "@type" => "Brand",
                "name" => $this->product->getBrandName()
            ],
            "image" => $this->product->getImageUrl(),
        ];

        return '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_UNICODE) . '</script>';
    }

}
