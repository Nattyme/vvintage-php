<?php 
declare(strict_types=1);

namespace Vvintage\Services\Admin;

use Vvintage\Services\Product\ProductService;


final class AdminProductService extends ProductService
{

    public function __construct(array $languages, string $currentLang)
    {
      parent::__construct($languages, $currentLang);
    }

}
