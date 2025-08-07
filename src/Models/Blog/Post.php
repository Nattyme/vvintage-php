<?php
declare(strict_types=1);

namespace Vvintage\Models\Blog;

use Vvintage\DTO\Post\PostDTO;
use Vvintage\Models\PostCategory\PostCategory;


final class Post
{
    private int $id;
    private string $title;
    private PostCategory $category;
    private string $slug;
    private string $description;
    private string $content;
    private float $timestamp;
    private ?int $views = 0;
    private ?string $cover = null;
    private ?string $cover_small = null;
    private ?string $edit_time = null;

    private ?array $translations = null;
    private string $currentLocale = 'ru';

    private function __construct() {}


    public static function fromArray(array $data): self
    {
        $post = new self();
        $post->id = (int) $data['id'];
        $post->title = $data['title'];
        $post->category = $data['category'];
        $post->slug = $data['slug'];
        $post->description = $data['description'];
        $post->content = $data['content'];
        $post->timestamp = (float) $data['timestamp'];
        $post->views = $data['views'];
        $post->cover = $data['cover'] ?? null;
        $post->cover_small = $data['cover_small'] ?? null;
        $post->edit_time = $data['edit_time'] ?? null;
        $post->translations = $data['translations'] ?? [];
        $post->currentLocale = (string) ($data['locale'] ?? 'ru');

        return $post;
    }

   
    public static function fromDTO(PostDTO $dto): self
    {
        $post = new self();

        $post->id = $dto->id;
        $post->category = PostCategory::fromDTO($dto->categoryDTO);

        $post->title = $dto->title;
        $post->slug = $dto->slug;
        $post->description = $dto->description;
        $post->content = $dto->content;

        $post->timestamp = (float) time();
        $post->views = $dto->views;
        $post->cover = $dto->cover;
        $post->cover_small = $dto->cover_small;
        $post->edit_time = (string) time();
        $post->translations = $dto->translations;

        return $post;
    }

    
    // Геттеры 
    public function getId(): int
    {
      return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCat(): int
    {
      return $this->category();
    }

    public function getDesc(): string
    {
      return $this->description;
    }

    public function getContent(): string
    {
      return $this->content;
    }
    
    public function getTime(): ?float
    {
      return $this->timestamp;
    }
    public function getViews(): ?int
    {
      return $this->views;
    }
    public function getCover(): ?string 
    {
      return $this->cover;
    }
    public function getCoverSmall(): ?string 
    {
      return $this->cover_small;
    }
    public function getEditTime(): string 
    {
      return $this->edit_time;
    }

    public function getTranslations(): ?array
    {
      return $this->translations[$this->currentLocale];
    }
    
}
