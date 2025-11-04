<?php
declare(strict_types=1);

namespace Vvintage\public\DTO\Post;


class PostFilterDTO {
   

    public function __construct(
      public $categories = null,
      public $search = null,
      public $sort = null,
      public $pagination = [],
      public $perPage = []
    ) {}
}
