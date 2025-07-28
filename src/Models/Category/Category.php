<?php
declare(strict_types=1);

namespace Vvintage\Models\Category;

use Vvintage\Models\Category\Category;


use RedBeanPHP\OODBBean;

final class Category
{
    private int $id;
    private string $title;
    private int $parent_id;
    private string $image;

    private function __construct() {}
    
    public static function fromBean(OODBBean $bean): self
    {
        $category = new self();
        $category->id = (int) $bean->id;
        $category->title = (int) $bean->title;
        $category->parent_id = (int) $bean->parent_id;
        $category->image = (int) $bean->image;
        
        return $category;
    }

    public static function fromArray(array $data): self
    {
        $category = new self();
        $category->id = (int) $data['id'];
        $category->title = $data['title'];
        $category->parent_id = $data['parent_id'];
        $category->image = $data['image'];

        return $category;
    }

    // public static function fromDTO(CategoryDTO $dto): self
    // {
    //     $post = new self();
    //     $post->title = $dto->title;
    //     $post->cat = $dto->cat;
    //     $post->description = $dto->description;
    //     $post->content = $dto->content;
    //     $post->timestamp = (float) time();
    //     $post->views = $dto->views;
    //     $post->cover = $dto->cover;
    //     $post->cover_small = $dto->cover_small;
    //     $post->edit_time = (string) time();

    //     return $post;
    // }

    
    // Геттеры 
    public function getId(): int
    {
      return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getParentId(): int
    {
      return $this->parent_id;
    }

    public function getImage(): int
    {
      return $this->image;
    }
    
}
