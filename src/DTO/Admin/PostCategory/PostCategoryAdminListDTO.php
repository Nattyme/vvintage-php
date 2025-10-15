<?php
declare(strict_types=1);

namespace Vvintage\DTO\Admin\PostCategory;

final class PostCategoryAdminListDTO
{
    public function __construct(
    public int $id,
    public int $parent_id,
    public string $title,
    public string $slug
  )
   
  {}
}
