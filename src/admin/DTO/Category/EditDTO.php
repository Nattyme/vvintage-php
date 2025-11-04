<?php
declare(strict_types=1);

namespace Vvintageadmin\DTO\Category;

final class EditDTO
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
