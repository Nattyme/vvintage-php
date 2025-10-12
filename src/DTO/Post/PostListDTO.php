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
    public  $edit_time;
    public ?string $cover_small = '';

    public function __construct(Post $data, string $currentLang)
    {
     
        $translation = $data->getTranslation($currentLang);
        $category = $data->getCategory();
        $categoryTranslation =  $category->getTranslation($currentLang);

        $this->id = (int) ($data->getId() ?? null);
        $this->title = trim($translation['title'] ?? '');

        $this->category['id'] = (int) ($data->getId() ?? null);
        $this->category['parent_id'] = (int) ($category->getParentId() ?? null);
        $this->category['title'] = (string) ($categoryTranslation['title'] ?? '');
        $this->category['description'] = (string) ($categoryTranslation['description'] ?? '');

        $this->description = (string) trim($translation['description'] ?? '');
        $this->views = (int) ($data->getViews() ?? 0);
        $this->edit_time =  ($data->getEditTime() ?? '');
        $this->cover_small = (string) ($data->getCoverSmall() ?? '');

        $coverPath = ROOT . '/uploads/blog/' . $this->cover_small;

        $this->cover_small = file_exists($coverPath) && $cover_small !== ''
            ? $this->cover_small
            : 'no-photo.jpg'; // дефолтное изображение
        }
}
