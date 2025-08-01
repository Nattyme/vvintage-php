<?php
declare(strict_types=1);

namespace Vvintage\DTO\Common;

class SeoDTO
{
    public string $title;
    public string $description;

    public function __construct(string $title = '', string $description = '')
    {
        $this->title = $title;
        $this->description = $description;
    }
}
