<?php
declare(strict_types=1);

namespace Vvintage\DTO\Brand;
use Vvintage\Models\Brand\Brand;

final class BrandOutputDTOfromModel 
{
    public int $id;
    public ?string $title;
    public ?string $image;
    public ?string $description;
    public ?array $translations;

    public function __construct(Brand $brand)
    {
        $this->id = (int)($brand->getId() ?? 0);
        $this->translations = $brand->getTranslations() ?? [];
        $this->title = (string) ($this->translations['title'] ?? '');
        $this->description = (string)($this->translations['description'] ?? '');
    }

}
