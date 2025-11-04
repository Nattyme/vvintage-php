<?php
declare(strict_types=1);

namespace Vvintage\DTO\Admin\Product;

final class ProductInputDTO
{
    public ?int $id = null;
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
    public ?\Datetime $datetime;
    public string $edit_time;

    public function __construct(array $data)
    {
        $this->id = isset($data['id']) ? (int) $data['id'] : null; 
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

        // Только при создании нового продукта
        if (empty($this->id)) {
            $this->datetime = $data['datetime'] ?? new \DateTime();
        } else {
            $this->datetime = $data['datetime'] ?? null; // или оставить unset
        }

        $this->edit_time =  (string) $data['edit_time'] ?? (new \DateTime())->format('Y-m-d H:i:s');;
    }

    public function toArray(): array 
    {
      return [
          'id' => $this->id,
          'category_id' => $this->category_id,
          'brand_id' => $this->brand_id,
          'slug' => $this->slug,
          'title' => $this->title,
          'description' => $this->description,
          'price' => $this->price,
          'sku' => $this->sku,
          'url' => $this->url,
          'stock' => $this->stock,
          'status' => $this->status,
          'datetime' => $this->datetime,
          'edit_time' => $this->edit_time
      ];
    }
}
