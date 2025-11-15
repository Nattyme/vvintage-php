<?php
declare(strict_types=1);

namespace Vvintage\Public\DTO\Post;

// TODO: вынести пагинацию и сдлеать readonly
final class PostFilterDTO {
    public function __construct(
      public ?array $categories = [],
      public ?array $search = [],
      public ?array $sort = [],
      public ?array $pagination = [],
      public ?int $perPage = null
    ) {}
}
