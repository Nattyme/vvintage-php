<?php
declare(strict_types=1);

namespace Vvintage\DTO\Post;


class PostFilterDTO {
    public array $categories = [];
    public ?string $sort = null;
    public ?array $pagination = [];

    public function __construct(array $query) {
        $this->categories = $query['categories'] ?? [];
        $this->sort = $query['sort'] ?? null;
        $this->pagination = $query['pagination'] ?? [];
    }
}
