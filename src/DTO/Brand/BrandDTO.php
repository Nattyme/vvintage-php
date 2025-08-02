<?php
declare(strict_types=1);

namespace Vvintage\DTO\Brand;

final class BrandDTO
{
    public int $id;
    public string $title;
    public string $image;
    public array $translations; // ['ru' => [...], 'en' => [...]]

    public function __construct(array $data)
    {
        $this->id = (int) ($data['id'] ?? 0);
        $this->title = (string) ($data['title'] ?? '');
        $this->image = (string) ($data['image'] ?? '');
        $this->translations = is_array($data['translations'] ?? null) ? $data['translations'] : [];
    }
}
