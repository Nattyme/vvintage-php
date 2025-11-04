<?php
declare(strict_types=1);

namespace Vvintage\admin\DTO\Post;

final class PostTranslationInputDTO
{
    public ?int $post_id;
    public string $slug;
    public string $locale;
    public string $title;
    public string $description;
    public string $content;
    public string $meta_title;
    public string $meta_description;

    public function __construct(array $data)
    {

        $this->post_id = (int) ($data['post_id'] ?? 0);
        $this->slug = (string) ($data['slug'] ?? '');
        $this->locale = (string) ($data['locale'] ?? 'ru');
        $this->title = (string) ($data['title'] ?? '');
        $this->description = (string) ($data['description'] ?? '');
        $this->content = (string) ($data['content'] ?? '');
        $this->meta_title = (string) ($data['meta_title'] ?? $data['title'] ?? '');
        $this->meta_description = (string) ($data['meta_description'] ?? $data['description'] ?? '');
    }
}
