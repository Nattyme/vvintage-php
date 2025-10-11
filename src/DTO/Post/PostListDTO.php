<?php
declare(strict_types=1);

namespace Vvintage\DTO\Post;

/** Model */
use Vvintage\Models\Post\Post;

final class PostListDTO
{
    public int $id;
    public array $category;

    public string $title;
    public string $description;
    public int $views = 0;
    public ?string $cover_small = '';

    public function __construct(Post $data, string $currentLang)
    {
        $translation = $data->getTranslation($currentLang);
        $category = $data->getCategory();
        $categoryTranslation =  $category->getTranslation($currentLang);

        $this->id = (int) ($data->getId() ?? 0);
        $this->title = trim($translation['title'] ?? '');

        $this->category['id'] = $data->getId();
        $this->category['parent_id'] = $category->getParentId();
        $this->category['title'] = $categoryTranslation['title'];
        $this->category['description'] = $categoryTranslation['description'];

        $this->description = trim($translation['description'] ?? '');
        $this->views = $data->getViews() ?? 0;
        $this->cover_small = $data->getCoverSmall() ?? '';

         dd($this);
    }
}
