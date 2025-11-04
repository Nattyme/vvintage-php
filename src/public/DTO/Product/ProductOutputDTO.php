<?php
declare(strict_types=1);

namespace Vvintage\public\DTO\Product;
use Vvintage\public\DTO\Product\ProductDTO;
use Vvintage\public\DTO\Category\CategoryOutputDTO;
use Vvintage\public\DTO\Brand\BrandOutputDTO;

final class ProductOutputDTO extends ProductDTO
{
    public int $id;
    public ?int $amount;


    public function __construct(array $data)
    {
      parent::__construct($data);
      $this->id = isset($data['id']) ? (int) $data['id'] : null; 
    }

    public function setAmount(int $data): void 
    {
      $this->amount =  $data;
    }
}
