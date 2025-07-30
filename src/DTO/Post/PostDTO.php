<?php
declare(strict_types=1);

namespace Vvintage\DTO\Post;

final class PostDTO
{
    public string $title;
    public int $category_id;
    public string $description;
    public string $content;
    public string $views = '0';
    public ?array $cover = null;
    public ?array $cover_small = null;

    public function __construct(array $data)
    {
        $this->title = trim($data['title'] ?? '');
        $this->category_id = trim($data['category_id'] ?? '');
        $this->description = trim($data['description'] ?? '');
        $this->content = trim($data['content'] ?? '');
        $this->views = $data['views'] ?? '0';
        $this->cover = $data['cover'] ?? null;
        $this->cover_small = $data['cover_small'] ?? null;
    }
}
