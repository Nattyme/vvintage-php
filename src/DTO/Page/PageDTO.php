<?php
declare(strict_types=1);

namespace Vvintage\DTO\Page;

class PageDTO
{
    // public int $id;
    public ?string $slug;
    public ?string $title;
    public int $visible;
    public int $show_in_navigation;
    public array $translations; // ['ru' => ['title'=>..., 'description'=>...], 'en' => [...]];
    // public string $locale;

    public function __construct(array $data)
    {
        // $this->id = (int)($data['id'] ?? 0);
        $this->slug = $data['slug'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->visible = $data['visible'] ?? 0;
        $this->show_in_navigation = $data['show_in_navigation'] ?? 0;

        
        $this->translations = [];
        foreach (($data['translations'] ?? []) as $locale => $fields) {
            $this->translations[$locale] = array_filter([
                'title' => $fields['title'] ?? null,
                'meta_title' => $fields['meta_title'] ?? null,
                'meta_description' => $fields['meta_description'] ?? null,
                'description' => $fields['description'] ?? null,
            ]);
        }

        // $this->locale = (string) $data['locale'];
    }
}
