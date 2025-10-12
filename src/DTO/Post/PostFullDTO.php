<?php
declare(strict_types=1);

namespace Vvintage\DTO\Post;

/** Model */
use Vvintage\Models\Post\Post;

final class PostFullDTO
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
      public string $cover,
      public int $views
    )
    {}
}
