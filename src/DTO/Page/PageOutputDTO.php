<?php
declare(strict_types=1);

namespace Vvintage\DTO\Page;
use Vvintage\DTO\Page\PageDTO;

class PageOutputDTO extends PageDTO
{
    public int $id;
  
    public function __construct(array $data)
    {
      $this->id = (int)($data['id'] ?? 0);
      parent::__construct($data);
    }

}
