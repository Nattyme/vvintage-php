<?php
declare(strict_types=1);

namespace Vvintage\DTO\PostCategory;

final class PostCategoryOutputDTO extends PostCategoryDTO
{
   public ?string $id;

  public function __construct(array $data)
  {
      parent::__construct($data);
      $this->id = (string) ($data['id'] ?? null);
  }

}
