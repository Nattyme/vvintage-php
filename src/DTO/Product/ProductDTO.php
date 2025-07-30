<?php
declare(strict_types=1);

namespace Vvintage\DTO\Product;


final class ProductDTO
{
  
    private int $id;
    private string $category;
    private string $brand;
    private string $slug;
    private string $title;
    private string $content;
    private float $price;
    private string $url;
    private string $article;
    private string $stock;
    private string $datetime;
    private ?array $images = null; // изначально изображения не загружены
    private ?int $imagesTotal = null;

    public array $translations;
    public string $seoTitle;
    public string $seoDescription;

    public function __construct(array $data)
    {
        $this->id = (int) ($data['id'] ?? null);
        $this->title = (string) ($data['title'] ?? '');
        $this->image = (string) ($data['image'] ?? '');
        $this->translations = is_array($data['translations'] ?? null) ? $data['translations'] : [];
        $this->seoTitle = (string) ($data['seo_title'] ?? '');
        $this->seoDescription = (string) ($data['seo_description'] ?? '');
    }
     
  
 
}
