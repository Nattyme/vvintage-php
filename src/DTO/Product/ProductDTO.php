<?php
declare(strict_types=1);

namespace Vvintage\DTO\Product;
use Vvintage\DTO\Category\CategoryDTO;
use Vvintage\DTO\Brand\BrandDTO;

final class ProductDTO
{
    public int $id;
    public int $category_id;
    public string $category_title;
    public CategoryDTO $categoryDTO;

    public int $brand_id;
    public string $brand_title;
    public BrandDTO $brandDTO;

    public string $slug;
    public string $title;
    public string $content;
    public string $price;
    public string $url;
    public string $sku;
    public int $stock;
    public string $datetime;

    public ?array $images;
    public ?int $imagesTotal;
    

    public array $translations;
    public string $locale; 

    public function __construct(array $data)
    {
        $this->id = (int) ($data['id'] ?? 0);

        $this->category_id = isset($data['category_id']) ? (int) $data['category_id'] : 0;
        $this->category_title = isset($data['category_title']) ? (string) $data['category_title'] : '';
        $this->categoryDTO = $data['categoryDTO'];

        $this->brand_id = (int) ($data['brand_id'] ?? 0);
        $this->brand_title = (string) ($data['brand_title'] ?? '');
        $this->brandDTO = $data['brandDTO'];

        $this->slug = (string) ($data['slug'] ?? '');
        $this->title = (string) ($data['title'] ?? '');
        $this->content = (string) ($data['content'] ?? '');
        $this->price = isset($data['price']) ? (string) $data['price'] : '';
        $this->url = (string) ($data['url'] ?? '');
        
        $this->sku = (string) ($data['sku'] ?? '');
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
        $this->locale = (string) ($data['locale'] ?? 'ru'); // локаль по умолчанию
    }
}
