<?php
declare(strict_types=1);

namespace Vvintage\Public\DTO\Brand;

final class BrandTranslationInputDTO
{
    public int $brand_id;
    public string $locale;
    public string $title;
    public string $description;
    public string $meta_title;
    public string $meta_description;

    public function __construct(array $data)
    {
        $this->brand_id = (int) ($data['brand_id'] ?? 0);
        $this->locale = (string) ($data['locale'] ?? 'ru');
        $this->title = (string) ($data['title'] ?? '');
        $this->description = (string) ($data['description'] ?? '');
        $this->meta_title = (string) ($data['meta_title'] ?? $data['title'] ?? '');
        $this->meta_description = (string) ($data['meta_description'] ?? $data['description'] ?? '');
    }
}
