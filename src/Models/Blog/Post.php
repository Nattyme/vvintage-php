<?php
declare(strict_types=1);

namespace Vvintage\Models\Blog;

use RedBeanPHP\OODBBean;

final class Post
{
    private int $id;
    private string $title;
    private string $cat;
    private string $description;
    private string $content;
    private float $timestamp;
    private string $views;
    private ?array $cover = null;
    private ?array $cover_small = null;
    private ?string $edit_time = null;

    private function __construct() {}

    public static function fromBean(OODBBean $bean): self
    {
        $post = new self();
        $post->id = (int) $bean->id;
        $post->title = $bean->title;
        $post->cat = $bean->cat;
        $post->description = $bean->description;
        $post->content = $bean->content;
        $post->timestamp = (float) $bean->timestamp;
        $post->views = $bean->views;
        $post->cover = $bean->cover;
        $post->cover_small = $bean->cover_small;
        $post->edit_time = $bean->edit_time;

        return $post;
    }

    public static function fromArray(array $data): self
    {
        $post = new self();
        $post->id = (int) $data['id'];
        $post->title = $data['title'];
        $post->cat = $data['cat'];
        $post->description = $data['description'];
        $post->content = $data['content'];
        $post->timestamp = (float) $data['timestamp'];
        $post->views = $data['views'];
        $post->cover = $data['cover'] ?? null;
        $post->cover_small = $data['cover_small'] ?? null;
        $post->edit_time = $data['edit_time'] ?? null;

        return $post;
    }

    // Геттеры 
    public function getTitle(): string
    {
        return $this->title;
    }

}
