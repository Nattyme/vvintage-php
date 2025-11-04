<?php
declare(strict_types=1);

namespace Vvintage\admin\DTO\Post;

final class PostEditDTO
{
    public function __construct(
    public int $id,
    public string $title,
    public string $description,
    public string $content,
    public string $slug,
    public int $category_id,
    public int $category_parent_id,
    public string $category_title,
    public string $formatted_date,
    public string $iso_date,
    public string $cover_small,
    public string $edit_time,
    public array $translations
  )
   
  {}
}
