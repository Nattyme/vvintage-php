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
      $translations = $this->post->getCurrentTranslations();

      return new SeoDTO(
        title: $translations['title'] ?? $translations['title'] ?? '',
        description: $translations['description'] ?? $translations['title'] ?? '',
        meta_title: $translations['meta_title'] ?? $translations['title'] ?? '',
        meta_description: $translations['meta_description'] ?? $translations['description'] ?? '',
        currentLang: $this->post->getCurrentLang(),
        structuredData: $this->getStructuredData(),
        isIndexed: 'index,follow'
      );
    }

    public function getStructuredData(): string
    {
        $currentLang = $this->post->getCurrentLang();
        $translations = $this->post->getTranslations();
        $meta = $translations ?? [];

        $data = [
            "@context" => "https://schema.org",
            "@type" => "Post",
            "name" => $meta['title'] ?? '',
            "description" => $meta['description'] ?? '',
            "category" => [
                "@type" => "Category",
                "name" => $this->post->getCategory()->getSeoTitle(),
                "description" => $this->post->getCategory()->getSeoDescription() ?? ''
            ],
        ];

        return '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_UNICODE) . '</script>';
    }

   

}
