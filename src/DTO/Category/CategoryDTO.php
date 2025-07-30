<?php
declare(strict_types=1);

namespace Vvintage\DTO\Category;


final class CategoryDTO
{
    public int $id;
    public string $title;
    public int $parent_id;
    public string $image;
    public array $translations;
    public string $seoTitle;
    public string $seoDescription;

    public function __construct(array $data)
    {
        $this->id = (int) $data['id'];
        $this->title = $data['title'];
        $this->parent_id = (int) $data['parent_id'];
        $this->image = $data['image'];
        $this->translations = $data['translations'];
        $this->seoTitle = $data['seo_title'];
        $this->seoDescription = $data['seo_description'];
    }
}
