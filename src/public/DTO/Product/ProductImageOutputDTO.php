<?php
declare(strict_types=1);

namespace Vvintage\Public\DTO\Product;

use Vvintage\Public\DTO\Product\ProductImageDTO;

final class ProductImageOutputDTO extends ProductImageDTO
{
    public int $id;
    public int $product_id;
    public string $url;
    public ?string $alt;

    public function __construct(array $data)
    {
      
        $this->id = (int) ($data['id'] ?? 0);
        $this->product_id = (int) ($data['product_id'] ?? 0);
        $this->filename = (string) ($data['filename'] ?? '');
        $this->alt = isset($data['alt']) ? (string)$data['alt'] : null;
    }
}
