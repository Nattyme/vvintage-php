<?php
declare(strict_types=1);

namespace Vvintage\DTO\Product;

use Vvintage\DTO\Product\ProductImageDTO;

final class ProductImageInputDTO extends ProductImageDTO
{
    public int $product_id;
    public string $filename;
    public int $image_order;
    public ?string $alt;

    public function __construct(array $data)
    {
    
        $this->product_id = (int) ($data['product_id'] ?? 0);
        $this->filename = (string) ($data['cover'] ?? '');
        $this->image_order = (int) ($data['image_order'] ?? 1);
        $this->alt = $data['alt'] ?? null;

        if ($this->filename === '') {
            throw new \InvalidArgumentException("Filename для изображения не может быть пустым");
        }
    }
}
