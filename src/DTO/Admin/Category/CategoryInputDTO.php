<?php
declare(strict_types=1);

namespace Vvintage\DTO\Admin\Category;
use Vvintage\DTO\Category\CategoryDTO;

final class CategoryInputDTO extends CategoryDTO
{
  
    public function __construct(array $data)
    {
      parent::__construct($data);
    }

}
