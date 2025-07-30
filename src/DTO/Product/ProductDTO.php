<?php
declare(strict_types=1);

namespace Vvintage\DTO\Product;

final class ProductDTO
{
    public int $id;
    public int $category_id;
    public string $brand;
    public string $slug;
    public string $title;
    public string $content;
    public string $price;
    public string $url;
    public string $article;
    public string $stock;
    public string $datetime;

    public ?array $images;
    public ?int $imagesTotal;

    public array $translations;
    public string $seoTitle;
    public string $seoDescription;
    public string $locale; // 👈 добавлено

    public function __construct(array $data)
    {
        $this->id = (int) ($data['id'] ?? 0);
        $this->category_id = isset($data['category_id']) ? (int) $data['category_id'] : 0;
        $this->brand = (string) ($data['brand'] ?? '');
        $this->slug = (string) ($data['slug'] ?? '');
        $this->title = (string) ($data['title'] ?? '');
        $this->content = (string) ($data['content'] ?? '');
        $this->price = isset($data['price']) ? (int) $data['price'] : '0';
        $this->url = (string) ($data['url'] ?? '');
        $this->article = (string) ($data['article'] ?? '');
        $this->stock = (int) ($data['stock'] ?? '');
        $this->datetime = (string) ($data['datetime'] ?? '');

        // 🖼️ Обработка изображений
        if (is_array($data['images'] ?? null)) {
            $this->images = $data['images'];
        } elseif (is_string($data['images'] ?? null)) {
            $this->images = array_filter(explode(',', $data['images']));
        } else {
            $this->images = null;
        }

        $this->imagesTotal = isset($data['images_total']) ? (int) $data['images_total'] : null;

        $this->translations = is_array($data['translations'] ?? null) ? $data['translations'] : [];

        $this->seoTitle = (string) ($data['seo_title'] ?? '');
        $this->seoDescription = (string) ($data['seo_description'] ?? '');
        $this->locale = (string) ($data['locale'] ?? 'ru'); // локаль по умолчанию
    }
}
