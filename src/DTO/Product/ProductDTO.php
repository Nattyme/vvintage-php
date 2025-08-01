<?php
declare(strict_types=1);

namespace Vvintage\DTO\Product;
use Vvintage\DTO\Category\CategoryDTO;

final class ProductDTO
{
    public int $id;
    public int $category_id;
    public string $category_title;
    public CategoryDTO $categoryDTO;

    public int $brand_id;
    public string $brand_title;

    public string $slug;
    public string $title;
    public string $content;
    public string $price;
    public string $url;
    public string $article;
    public int $stock;
    public string $datetime;

    public ?array $images;
    public ?int $imagesTotal;
    

    public array $translations;
    public string $seo_title;
    public string $seo_description;
    public string $locale; 

    public function __construct(array $data)
    {
        $this->id = (int) ($data['id'] ?? 0);

        $this->category_id = isset($data['category_id']) ? (int) $data['category_id'] : 0;
        $this->category_title = isset($data['category_title']) ? (string) $data['category_title'] : '';
        $this->categoryDTO = $data['categoryDTO'];

        $this->brand_id = (int) ($data['brand_id'] ?? 0);
        $this->brand_title = (string) ($data['brand_title'] ?? '');

        $this->slug = (string) ($data['slug'] ?? '');
        $this->title = (string) ($data['title'] ?? '');
        $this->content = (string) ($data['content'] ?? '');
        $this->price = isset($data['price']) ? (string) $data['price'] : '';
        $this->url = (string) ($data['url'] ?? '');
        
        $this->article = (string) ($data['article'] ?? '');
        $this->stock = (int) ($data['stock'] ?? 0);
        $this->datetime = (string) ($data['datetime'] ?? '');

        $imagesRaw = $data['images'] ?? null;
        if (is_array($imagesRaw)) {
            $this->images = $imagesRaw;
        } elseif (is_string($imagesRaw)) {
            $this->images = array_filter(explode(',', $imagesRaw));
        } else {
            $this->images = null;
        }

        $this->imagesTotal = isset($this->images) ? count($this->images) : null;

        $this->translations = is_array($data['translations'] ?? null) ? $data['translations'] : [];
        $this->seo_title = (string) ($data['seo_title'] ?? '');
        $this->seo_description = (string) ($data['seo_description'] ?? '');
        $this->locale = (string) ($data['locale'] ?? 'ru'); // локаль по умолчанию
    }
}
