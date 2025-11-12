<?php
declare(strict_types=1);

namespace Vvintage\Admin\DTO\Category;

final readonly class CategoryTranslationInputDTO
{
    public ?int $category_id;
    public string $slug;
    public string $locale;
    public string $title;
    public string $description;
    public string $meta_title;
    public string $meta_description;

    public function __construct(array $data)
    {
        $this->category_id = (int) ($data['category_id'] ?? 0);
        $this->slug = (string) ($data['slug'] ?? '');
        $this->locale = (string) ($data['locale'] ?? 'ru');
        $this->title = (string) ($data['title'] ?? '');
        $this->description = (string) ($data['description'] ?? '');
        $this->meta_title = (string) ($data['meta_title'] ?? $data['title'] ?? '');
        $this->meta_description = (string) ($data['meta_description'] ?? $data['description'] ?? '');
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
