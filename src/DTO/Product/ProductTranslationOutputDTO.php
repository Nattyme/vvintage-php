<?php
declare(strict_types=1);

namespace Vvintage\DTO\Product;

final class ProductTranslationOutputDTO
{
    public int $id;
    public int $product_id;
    public string $locale;
    public string $title;
    public string $description;

    public function __construct(array $data)
    {
        $this->id = (int) ($data['id'] ?? 0);
        $this->product_id = (int) ($data['product_id'] ?? 0);
        $this->locale = (string) ($data['locale'] ?? 'ru');
        $this->title = (string) ($data['title'] ?? '');
        $this->description = (string) ($data['description'] ?? '');
    }
}
