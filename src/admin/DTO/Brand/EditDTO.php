<?php
declare(strict_types=1);

namespace Vvintage\Admin\DTO\Brand;

final readonly class EditDTO
{
    public function __construct(
    public int $id,
    public string $title,
    public string $description,
    public ?string $image,
    public array $translations
  )
  {}
}
