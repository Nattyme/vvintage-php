<?php
declare(strict_types=1);

namespace Vvintage\DTO\Common;

class SeoDTO
{
    public string $title = '';
    public string $description = '';
    public string $meta_title = '';
    public string $meta_description = '';

    public function __construct(
        string $title = '',
        string $description = '',
        string $meta_title = '',
        string $meta_description = ''
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->meta_title = $meta_title;
        $this->meta_description = $meta_description;
    }

    public function getTitle(): string
    {
        return $this->meta_title !== '' ? $this->meta_title : $this->title;
    }

    public function getDescription(): string
    {
        return $this->meta_description !== '' ? $this->meta_description : $this->description;
    }
}
