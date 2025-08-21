<?php
declare(strict_types=1);

namespace Vvintage\DTO\Product;

final class ProductInputDTO
{
    public int $category_id;
    public int $brand_id;

    public string $slug;
    public string $title;
    public string $description;
    public int $price;
    public string $sku;
    public string $url;
    public int $stock;
    public string $status;
    public string $locale;
    public string $datetime;
    public string $edit_time;

    public function __construct(array $data)
    {
        $this->category_id = (int) ($data['category_id'] ?? 0);
        $this->brand_id = (int) ($data['brand_id'] ?? 0);

        $this->slug = (string) ($data['slug'] ?? '');
        $this->title = (string) ($data['title'] ?? '');
        $this->description = (string) ($data['description'] ?? '');
        $this->price = (int) ($data['price'] ?? '');
        $this->sku = (string) ($data['sku'] ?? '');
        $this->stock = (int) ($data['stock'] ?? 0);
        $this->url = (string) ($data['url'] ?? '');
        $this->status = (string) ($data['status'] ?? '');
        $this->datetime = (string) ($data['datetime'] ?? '');
        $this->edit_time = (string) ($data['edit_time'] ?? '');

        // $this->locale = (string) ($data['locale'] ?? 'ru');
    }
}
