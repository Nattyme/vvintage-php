<?php
declare(strict_types=1);

namespace Vvintage\DTO\Category;
use Vvintage\Models\Category\Category;

final class CategoryForProductDTO
{
    public int $id;
    public string $title;
    public ?string $description;
    public ?int $parent_id;

    public function __construct(Category $category)
    {
        $this->id = (int) ($category->getId() ?? 0);
        $this->title = (string) ($category->getTranslations()['title'] ?? '');
        $this->description = (string)($category->getTranslations()['description'] ?? '');
        $this->parent_id = (int) ($category->getParentId() ?? 0);
    }

}
