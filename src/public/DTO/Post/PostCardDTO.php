<?php
declare(strict_types=1);

namespace Vvintage\Public\DTO\Post;

/** Model */
use Vvintage\Models\Post\Post;

final readonly class PostCardDTO
{
    public int $id;
    public string $title;
    public ?string $cover_small;

    public function __construct(Post $data, string $currentLang)
    {
        $translation = $data->getTranslation($currentLang);

        $coverName = $data->getCoverSmall();
        $coverPath = ROOT . '/uploads/blog/' . $coverName;
        $coverSmall = file_exists($coverPath) && $cover_small !== '' ? $coverName : 'no-photo.jpg'; // дефолтное изображение

        $this->id = (int) ($data->getId() ?? 0);
        $this->title = trim($translation['title'] ?? '');
        $this->cover_small = $coverSmall;
        }
}
