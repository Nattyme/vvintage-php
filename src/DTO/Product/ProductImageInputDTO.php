<?php
declare(strict_types=1);

namespace Vvintage\DTO\Product;

final class ProductImageInputDTO
{
    public int $product_id;
    public string $filename;
    public int $image_order;
    public ?string $alt;

    public function __construct(array $data)
    {
        $this->product_id = (int) ($data['product_id'] ?? 0);
        $this->filename = (string) ($data['filename'] ?? '');
        $this->image_order = (int) ($data['image_order'] ?? 1);
        $this->alt = $data['alt'] ?? null;
    }
}
