<?php
declare(strict_types=1);

namespace Vvintage\DTO\PostCategory;

final class PostCategoryInputDTO extends PostCategoryDTO
{
  public int $id;
  
  public function __construct(array $data)
  {
      parent::__construct($data);
      $this->id = (int) ($data['id'] ?? 0);
  }
}
