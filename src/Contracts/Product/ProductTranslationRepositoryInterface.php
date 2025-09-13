<?php

declare(strict_types=1);

namespace Vvintage\Contracts\Product;

use Vvintage\Models\Product\Product;
use Vvintage\DTO\Product\ProductDTO;


interface ProductTranslationRepositoryInterface
{
  
     /** Создаёт новый OODBBean для перевода продукта */
    public function createProductTranslateBean(): OODBBean;

    public function createTranslateInputDto(array $data, int $productId): array;

    public function loadTranslations(int $productId): array;

    public function saveProductTranslation(array $translateDto): ?array;

}
