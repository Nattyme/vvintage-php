<?php
declare(strict_types=1);

namespace Vvintage\Models\Post;

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
    private \Datetime $datetime;
    private ?int $views = 0;
    private ?string $cover = null;
    private ?string $cover_small = null;
    private \Datetime  $edit_time;

    private ?array $translations = null;
    private string $currentLang = 'ru';

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
        $post->datetime = $data['datetime'];
        $post->views = $data['views'];
        $post->cover = $data['cover'] ?? null;
        $post->cover_small = $data['cover_small'] ?? null;
        $post->edit_time = $data['edit_time'] ?? null;
        $post->translations = $data['translations'] ?? [];
        $post->currentLang = (string) ($data['locale'] ?? 'ru');

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

        $post->datetime = new \Datetime ();
        $post->views = $dto->views;
        $post->cover = $dto->cover;
        $post->cover_small = $dto->cover_small;
        $post->edit_time = new \Datetime ();
        $post->translations = $dto->translations;

        return $post;
    }

    
    // Геттеры 
    public function getId(): int
    {
      return $this->id;
    }

    // Получение названия в нужной локали, иначе fallback title
    public function getTitle(?string $locale = null): string
    {
      return $this->title;
        // $locale = $locale ?? $this->currentLang;

        // return $this->translations[$locale]['title']
        //     ?? $this->translations['ru']['title']
        //     ?? $this->title;
    }


    public function getCategory(): ?PostCategory
    {
      return $this->category;
    }


    // Получение названия в нужной локали, иначе fallback description
    public function getDescription(?string $locale = null): string
    {
        return $this->description;
    }

     // Получение названия в нужной локали, иначе fallback description
    public function getContent(?string $locale = null): string
    {
      return $this->content;
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
    public function getDateTime(): \Datetime
    {
      return $this->datetime;
    }

    public function getEditTime(): string 
    {
      return $this->edit_time;
    }

    public function getTranslations(): ?array
    {
      return $this->translations[$this->currentLang];
    }

    /** SEO */
    public function getMetaTitle(): ?string
    {
      return $this->meta_title;
    }

    public function getMetaDescription(): ?string
    {
       return $this->meta_description;
  
    }

    
}
