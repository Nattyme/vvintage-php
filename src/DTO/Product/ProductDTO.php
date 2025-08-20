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
    public ?CategoryDTO $categoryDTO;

    public int $brand_id;
    public string $brand_title;
    public ?BrandDTO $brandDTO;

    public string $slug;
    public string $title;
    public string $description;
    public string $price;
    public string $url;
    public string $status;
    public string $sku;
    public int $stock;
    public string $datetime;
    public string $edit_time;

    public ?array $images;
    public ?int $imagesTotal;
    

    public array $translations;
    public string $locale; 

    public function __construct(array $data)
    {
        $this->id = (int) ($data['id'] ?? 0);

        $this->category_id = (int) ($data['category_id'] ?? 0);
        $this->category_title = (string) isset($data['category_title']) ? $data['category_title'] : '';
        $this->categoryDTO = $data['categoryDTO'] ?? null;

        $this->brand_id = (int) ($data['brand_id'] ?? 0);
        $this->brand_title = (string) isset($data['brand_title']) ? $data['brand_title'] : '';
        $this->brandDTO = $data['brandDTO'] ?? null;


        $this->slug = (string) ($data['slug'] ?? '');
        $this->title = (string) ($data['title'] ?? '');
        $this->description = (string) ($data['description'] ?? '');
        $this->price = isset($data['price']) ? (string) $data['price'] : '';
        $this->url = (string) ($data['url'] ?? '');
        $this->status = (string) ($data['status'] ?? '');
        
        $this->sku = (string) ($data['sku'] ?? '');
        $this->stock = (int) ($data['stock'] ?? 0);
        $this->datetime = (string) ($data['datetime'] ?? '');
        $this->edit_time = (string) ($data['edit_time'] ?? '');

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
