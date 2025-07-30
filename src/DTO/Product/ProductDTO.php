<?php
declare(strict_types=1);

namespace Vvintage\DTO\Product;


final class ProductDTO
{
  
    private int $id;
    private string $title;
    private string $content;
    private string $brand;
    private string $url;
    private string $category;
    private float $price;
    private string $datetime;
    private ?array $images = null; // изначально изображения не загружены
    private ?int $imagesTotal = null;
    public array $translations;
    public string $seoTitle;
    public string $seoDescription;

    public function __construct(array $data)
    {
        $this->id = (int) $data['id'];
        $this->title = $data['title'];
        $this->parent_id = (int) $data['parent_id'];
        $this->image = $data['image'];
        $this->translations = $data['translations'];
        $this->seoTitle = $data['seo_title'];
        $this->seoDescription = $data['seo_description'];
    }
}
