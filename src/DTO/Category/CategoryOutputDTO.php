<?php
declare(strict_types=1);

namespace Vvintage\DTO\Category;
use Vvintage\DTO\Category\CategoryDTO;

final class CategoryOutputDTO extends CategoryDTO
{

    public function __construct(array $data)
    {
        parent::__construct($data);
    }

}
