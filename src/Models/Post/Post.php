<?php
declare(strict_types=1);

namespace Vvintage\Models\Post;

use Vvintage\DTO\Post\PostDTO;
use Vvintage\Models\PostCategory\PostCategory;


final class Post
{
    private int $id;

    private PostCategory $category;
    private int $category_id;

    private string $slug;
    private string $title;
    private string $description;
    private string $content;

    private \Datetime $datetime;
    private ?int $views = 0;
    private ?string $cover = null;
    private ?string $cover_small = null;
    private string $edit_time;

    private array $translations;

    private function __construct() {}


    public static function fromArray(array $data): self
    {
        $post = new self();
        $post->id = (int) $data['id'];

        $post->slug = (string) ($data['slug'] ?? null);
        $post->title = (string) ($data['title'] ?? '');
        $post->description = (string) ($data['description'] ?? '');
        $post->content = (string) ($data['content'] ?? '');

        $post->category_id = (int) ($data['category_id'] ?? null);
        $post->views = (int) ($data['views'] ?? null);

        
        $post->cover = (string) ($data['cover'] ?? null);
        $post->cover_small = (string) ($data['cover_small'] ?? null);

        $post->datetime = !empty($data['datetime'])
            ? (is_numeric($data['datetime'])
                ? (new \DateTime())->setTimestamp((int)$data['datetime'])
                : new \DateTime($data['datetime']))
            : new \DateTime();;
        $post->edit_time = (string) ($data['edit_time'] ?? '');

        return $post;
    }

   
    public static function fromBean($data): self
    {

        $post = new self();

        $post->id = (int) ($data->id ?? null);
        $post->category_id = (int) ($data->category_id ?? '');

        $post->title = (string) ($data->title ?? '');
        $post->slug = (string) ($data->slug ?? '');
        $post->description = (string) ($data->description ?? '');
        $post->content = (string) ($data->content ?? '');

        $post->datetime = !empty($data['datetime'])
            ? (is_numeric($data['datetime'])
                ? (new \DateTime())->setTimestamp((int)$data['datetime'])
                : new \DateTime($data['datetime']))
            : new \DateTime();;
        $post->edit_time = (string) ($data['edit_time'] ?? '');

        $post->views = (int) ($data->views ?? null);
        $post->cover = (string) ($data->cover ?? '');
        $post->cover_small = (string) ("290-{$data->cover}" ?? '');
        $post->translations = array ($data->translations ?? []);

        return $post;
    }
    // public static function fromObj($dto): self
    // {
    //     $post = new self();

    //     $post->id = $dto->id;
    //     $post->category_id = $dto->category_id;

    //     $post->title = $dto->title;
    //     $post->slug = $dto->slug;
    //     $post->description = $dto->description;
    //     $post->content = $dto->content;

    //     $post->datetime = new \Datetime ();
    //     $post->views = $dto->views;
    //     $post->cover = $dto->cover;
    //     $post->cover_small = $dto->cover_small;
    //     $post->edit_time = new \Datetime ();
    //     $post->currentLocale = $dto->locale ?? 'ru';
    //     $post->translations = $dto->translations;

    //     return $post;
    // }

    
    // Геттеры 
    public function getId(): int
    {
      return $this->id;
    }

    // Получение названия в нужной локали, иначе fallback title
    public function getTitle(?string $locale = null): string
    {
        $locale = $locale ?? null;

        return $this->translations[$locale]['title'] ?? $this->translations['ru']['title']
            ?? $this->title;
    }

    // Получение названия в нужной локали, иначе fallback description
    public function getDescription(?string $locale = null): string
    {
      $locale = $locale ?? null;

      return $this->translations[$locale]['description'] ?? $this->translations['ru']['description']
          ?? $this->description;
    }


    public function getCategoryId(): int 
    {
      return $this->category_id;
    }


    public function getCategory(): ?PostCategory
    {
      return $this->category;
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

    /** SEO */
    public function getMetaTitle(): ?string
    {
      return $this->meta_title;
    }

    public function getMetaDescription(): ?string
    {
       return $this->meta_description;
  
    }

    public function setTranslations(array $translations): void 
    {
      $this->translations = $translations;
    }

    public function setCategory(PostCategory $category): void 
    {
      $this->category = $category;
    }

    public function getTranslation(string $locale): array
    {
        return $this->translations[$locale] ?? $this->translations['ru'] ?? [];
    }


    
}
