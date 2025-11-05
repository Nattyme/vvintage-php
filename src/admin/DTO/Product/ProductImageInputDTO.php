<?php
declare(strict_types=1);

namespace Vvintage\Admin\DTO\Product;

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

        if ($this->filename === '') {
            throw new \InvalidArgumentException("Filename для изображения не может быть пустым");
        }
    }

    public function toArray(): array
    {
        return [
            'product_id' => $this->product_id,
            'filename' => $this->filename,
            'image_order' => $this->image_order,
            'alt' => $this->alt
        ];
    }
}
