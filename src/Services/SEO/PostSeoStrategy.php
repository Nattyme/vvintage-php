<?php
declare(strict_types=1);

namespace Vvintage\Services\SEO;

use Vvintage\Contracts\SeoStrategyInterface;
use Vvintage\DTO\Common\SeoDTO;


class PostSeoStrategy implements SeoStrategyInterface
{
    private $post;

    public function __construct($post)
    {
        $this->post = $post;
    }

    public function getSeo(): SeoDTO
    {
      $locale = $this->post->getCurrentLocale();
      $translations = $this->post->getTranslations();

        
      return new SeoDTO(
          $translations['title'] ?? $translations['title'] ?? '',
          $translations['meta_description'] ?? $translations['title'] ?? '',
          $translations['meta_title'] ?? $translations['title'] ?? '',
          $translations['meta_description'] ?? $translations['description'] ?? ''
      );
    }

    public function getStructuredData(): string
    {
        $locale = $this->post->getCurrentLocale();
        $translations = $this->post->getTranslations();
        $meta = $translations[$locale] ?? [];

        $data = [
            "@context" => "https://schema.org",
            "@type" => "Product",
            "name" => $meta['title'] ?? '',
            "description" => $meta['description'] ?? '',
            "brand" => [
                "@type" => "Brand",
                "name" => $this->post->getBrandTitle()
            ]
            // "image" => $this->post->getImageUrl(),
        ];

        return '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_UNICODE) . '</script>';
    }

}
