<?php
declare(strict_types=1);

namespace Vvintage\Admin\DTO\PostCategory;

final readonly class PostCategoryInputDTO 
{
  public int $id;
  
  public function __construct(array $data)
  {
      $this->parent_id = $data['parent_id'] ? (int) $data['parent_id'] :  null;
      $this->title = (string) ($data['title'] ?? '');
      $this->slug = (string) ($data['slug'] ?? '');
      $this->image = (string) ($data['image'] ?? '');
      $this->translations = is_array($data['translations'] ?? null) ? $data['translations'] : [];
      $this->id = (int) ($data['id'] ?? 0);
  }
}
