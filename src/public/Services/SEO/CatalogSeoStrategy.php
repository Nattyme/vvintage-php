<?php
declare(strict_types=1);

namespace Vvintage\public\Services\SEO;

use Vvintage\Contracts\SeoStrategyInterface;
use Vvintage\public\DTO\Common\SeoDTO;


class CatalogSeoStrategy implements SeoStrategyInterface
{
    private $model;
    private $lang;

    public function __construct($model, $lang)
    {
        $this->lang = $lang;
        $this->model = $model;
    }

   
    public function getSeo(): SeoDTO
    {
      $translations = $this->model->getCurrentTranslations();
    
      return new SeoDTO(
        title: $translations['title'] ?? $translations['title'] ?? '',
        description: $translations['description'] ?? $translations['title'] ?? '',
        meta_title: $translations['meta_title'] ?? $translations['title'] ?? '',
        meta_description: $translations['meta_description'] ?? $translations['description'] ?? '',
        currentLang: $this->lang,
        structuredData: $this->getStructuredData(),
        isIndexed: 'index,follow'
      );
    }

    public function getStructuredData(): string
    {

        $currentLang = $this->lang;
        $translations = $this->model->getCurrentTranslations();
       
        $meta = $translations ?? [];

        $data = [
            "@context" => "https://schema.org",
            "@type" => "Catalog",
            "name" => $meta['meta_title'] ?? '',
            "description" => $meta['meta_description'] ?? '',
        ];

        return '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_UNICODE) . '</script>';
    }


    public function getOG(): array 
    {

    }

}
