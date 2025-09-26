<?php
declare(strict_types=1);

namespace Vvintage\DTO\Brand;

final class BrandOutputDTO extends BrandDTO
{
    public int $id;
    public ?string $title;
    public ?string $description;

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->id = (int)($data['id'] ?? 0);
        $this->title = (string) ($data['title'] ?? '');
        $this->description = (string)($data['description'] ?? '');
    }

}
