<?php
declare(strict_types=1);

namespace Vvintage\DTO\Product;

final class ProductImageOutputDTO
{
    public int $id;
    public int $product_id;
    public string $url;
    public ?string $alt;

    public function __construct(array $data)
    {
        $this->id = (int) ($data['id'] ?? 0);
        $this->product_id = (int) ($data['product_id'] ?? 0);
        $this->url = (string) ($data['url'] ?? '');
        $this->alt = $data['alt'] ?? null;
    }
}
