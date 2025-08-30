<?php
declare(strict_types=1);

namespace Vvintage\DTO\PostCategory;

final class PostCategoryInputDTO extends PostCategoryDTO
{
  public function __construct(array $data)
  {
      parent::__construct($data);
  }
}
