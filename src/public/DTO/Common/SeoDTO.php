<?php
declare(strict_types=1);

namespace Vvintage\Public\DTO\Common;

class SeoDTO
{
    public string $title = '';
    public ?string $slug = '';
    public ?string $description = '';
    public ?string $content = '';
    public ?string $meta_title = '';
    public ?string $meta_description = '';
    public ?string $currentLang = 'ru';
    public ?string $structuredData = '';
    public ?string $isIndexed = 'noindex,follow';

    public function __construct(
        string $title = '',
        string $slug = '',
        string $description = '',
        string $content = '',
        string $meta_title = '',
        string $meta_description = '',
        string $currentLang = '',
        string $structuredData = '',
        string $isIndexed = 'noindex,follow'
    ) {
        $this->title = $title ?: 'Страница продукта';
        $this->slug = $slug ?: '';
        $this->description = $description ?: 'Винтажный товар, редкий экземпляр, больше не выпускается';
        $this->content = $content ?: '';
        $this->meta_title = $meta_title ?: 'Страница продукта';
        $this->meta_description = $meta_description ?? 'Винтажный товар, редкий экземпляр, больше не выпускается';
        $this->currentLang = $currentLang ?: 'ru';
        $this->structuredData = $structuredData ?? '';
        $this->isIndexed = $isIndexed ?? 'noindex,follow';
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
