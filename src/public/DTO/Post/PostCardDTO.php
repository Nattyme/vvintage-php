<?php
declare(strict_types=1);

namespace Vvintage\public\DTO\Post;

/** Model */
use Vvintage\Models\Post\Post;

final class PostCardDTO
{
    public int $id;
    public string $title;
    public ?string $cover_small = '';

    public function __construct(Post $data, string $currentLang)
    {
        $translation = $data->getTranslation($currentLang);

        $this->id = (int) ($data->getId() ?? 0);
        $this->title = trim($translation['title'] ?? '');
        $this->cover_small = $data->getCoverSmall() ?? '';

        $coverPath = ROOT . '/uploads/blog/' . $this->cover_small;

        $this->cover_small = file_exists($coverPath) && $cover_small !== ''
            ? $this->cover_small
            : 'no-photo.jpg'; // дефолтное изображение
        }
}
