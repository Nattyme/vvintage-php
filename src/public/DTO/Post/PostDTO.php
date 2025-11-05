<?php
declare(strict_types=1);

namespace Vvintage\Public\DTO\Post;
use Vvintage\Public\DTO\PostCategory\PostCategoryDTO;

final class PostDTO
{
    public int $id;
    public string $title;
    public PostCategoryDTO $categoryDTO;
    public string $slug;
    public string $description;
    public string $content;
    public int $views = 0;
    public ?string $cover = '';
    public ?string $cover_small = '';

    public array $translations;
    public string $locale; 

    public function __construct(array $data)
    {
        $this->id = (int) ($data['id'] ?? 0);
        $this->title = trim($data['title'] ?? '');
        $this->categoryDTO = $data['categoryDTO'];
        $this->slug = trim($data['slug'] ?? '');
        $this->description = trim($data['description'] ?? '');
        $this->content = trim($data['content'] ?? '');
        $this->views = $data['views'] ?? 0;
        $this->cover = $data['cover'] ?? '';
        $this->cover_small = $data['cover_small'] ?? '';

        $this->translations = is_array($data['translations'] ?? null) ? $data['translations'] : [];
        $this->locale = (string) ($data['locale'] ?? 'ru'); // локаль по умолчанию
    }
}
