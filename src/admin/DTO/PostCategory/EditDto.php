<?php
declare(strict_types=1);

namespace Vvintage\Admin\DTO\PostCategory;

final readonly class EditDto
{
    public function __construct(
    public bool $isMain,
    public int $id,
    public string $title,
    public string $description,
    public string $slug,
    public ?int $parent_id,
    public ?string $parent_title,
    public array $translations
  )
   
  {}
}
