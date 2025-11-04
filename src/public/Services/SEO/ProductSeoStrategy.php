<?php
declare(strict_types=1);

namespace Vvintage\public\Services\SEO;

use Vvintage\Contracts\SeoStrategyInterface;
use Vvintage\public\DTO\Common\SeoDTO;


class ProductSeoStrategy implements SeoStrategyInterface
{
    private $product;
    private $lang;

    public function __construct($product, $lang)
    {
        $this->product = $product;
        $this->lang = $lang;
    }

   
    public function getSeo(): SeoDTO
    {
       $title = $this->product->getTitle();
       $desc = $this->product->getDescription();
       $metaTitle = $this->product->getSeoTitle($this->lang);
       $metaDesc = $this->product->getSeoDescription($this->lang);

      return new SeoDTO(
        title: $title  ?? '',
        description: $desc ?? '',
        meta_title: $metaTitle ?? '',
        meta_description: $metaDesc ?? '',
        currentLang: $this->lang,
        structuredData: $this->getStructuredData(),
        isIndexed: 'index,follow'
      );
    }

    public function getStructuredData(): string
    {
     
        $metaTitle = $this->product->getSeoTitle($this->lang);
        $metaDesc = $this->product->getSeoDescription($this->lang);
        $brandTitle = $this->product->getBrand()->getSeoTitle($this->lang);
        $brandDesc = $this->product->getBrand()->getSeoDescription($this->lang);
        $categoryTitle = $this->product->getBrand()->getSeoDescription($this->lang);

        $data = [
            "@context" => "https://schema.org",
            "@type" => "Product",
            "name" => $metaTitle ?? '',
            "description" => $metaDesc ?? '',
            "brand" => [
                "@type" => "Brand",
                "name" =>  $brandTitle  ?? '',
                "description" => $this->product->getBrand()->getSeoDescription($this->lang) ?? ''
            ],
            "category" => $categoryTitle  ?? ''
        ];

        return '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_UNICODE) . '</script>';
    }


    public function getOG(): array 
    {

    }

}
