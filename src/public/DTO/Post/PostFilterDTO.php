<?php
declare(strict_types=1);

namespace Vvintage\Public\DTO\Post;

// TODO: вынести пагинацию и сдлеать readonly
final class PostFilterDTO {
    public function __construct(
      public ?array $categories = null,
      public ?array $search = null,
      public ?array $sort = null,
      public ?array $pagination = null,
      public ?int $perPage = null
    ) {}
}
