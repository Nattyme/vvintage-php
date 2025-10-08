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
      $translations = $this->product->getCurrentTranslations();

      return new SeoDTO(
        title: $translations['title'] ?? $translations['title'] ?? '',
        description: $translations['description'] ?? $translations['title'] ?? '',
        meta_title: $translations['meta_title'] ?? $translations['title'] ?? '',
        meta_description: $translations['meta_description'] ?? $translations['description'] ?? '',
        currentLang: $this->product->getCurrentLang(),
        structuredData: $this->getStructuredData(),
        isIndexed: 'index,follow'
      );
    }

    public function getStructuredData(): string
    {
        $currentLang = $this->product->getCurrentLang();
        $translations = $this->product->getTranslations();
        $meta = $translations ?? [];

        $data = [
            "@context" => "https://schema.org",
            "@type" => "Product",
            "name" => $meta['title'] ?? '',
            "description" => $meta['description'] ?? '',
            "brand" => [
                "@type" => "Brand",
                "name" => $this->product->getBrand()->getSeoTitle(),
                "description" => $this->product->getBrand()->getSeoDescription() ?? ''
            ],
            "category" => $this->product->getCategory()->getSeoTitle() ?? ''
        ];

        return '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_UNICODE) . '</script>';
    }


    public function getOG(): array 
    {

    }

}
