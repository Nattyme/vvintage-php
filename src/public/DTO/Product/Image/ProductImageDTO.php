<?php
declare(strict_types=1);

namespace Vvintage\Public\DTO\Product\Image;

final readonly class ProductImageDTO
{
    public int $id;
    public int $product_id;
    public string $filename;
    public int $image_order;


    public function __construct(array $data)
    {
        $this->id = (int) ($data['id'] ?? 0);
            
        $this->product_id = (int) ($data['product_id'] ?? 0);
        $this->filename = (string) ($data['filename'] ?? '');
        $this->image_order = (int) ($data['image_order'] ?? 0);
    }

    public function getFilename(): string
    {
      return $this->filename;
    }

    public function getId(): int
    {
      return $this->id;
    }

    public function getOrder(): int
    {
      return $this->image_order;
    }


}
