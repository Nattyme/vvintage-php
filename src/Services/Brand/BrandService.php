<?php

declare(strict_types=1);

namespace Vvintage\Services\Brand;

/** Модель */
use Vvintage\Models\Brand\Brand;
use Vvintage\Repositories\Brand\BrandRepository;

require_once ROOT . "./libs/functions.php";

final class BrandService
{
    private array $languages;
    private string $currentLang;
    private BrandRepository $repository;

    public function __construct($languages, $currentLang)
    {
        $this->languages = $languages;
        $this->currentLang = $currentLang;
        $this->repository = new BrandRepository($this->currentLang);
    }


    public function getBrandsArray(): array
    {
      return $this->repository->getBrandsArray();
    }

}
