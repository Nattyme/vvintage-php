<?php
declare(strict_types=1);

namespace Vvintage\DTO\Brand;
use Vvintage\Models\Brand\Brand;

final class BrandForProductDTO
{
    public int $id;
    public ?string $title;
    public ?string $description;

    public function __construct(Brand $brand)
    {
        $this->id = (int)($brand->getId() ?? 0);
        $this->title = (string) ($brand->getTranslations()['title'] ?? '');
        $this->description = (string)($brand->getTranslations()['description'] ?? '');
    }

}
