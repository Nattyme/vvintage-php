<?php
declare(strict_types=1);

namespace Vvintage\DTO\Page;

class PageDTO
{
    // public int $id;
    public ?string $slug;
    public ?string $title;
    public int $visible;
    public array $translations; // ['ru' => ['title'=>..., 'description'=>...], 'en' => [...]];
    // public string $locale;

    public function __construct(array $data)
    {
        // $this->id = (int)($data['id'] ?? 0);
        $this->slug = $data['slug'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->visible = $data['visible'] ?? 0;

        
        if (isset($data['translations']) && is_array($data['translations'])) {
            foreach ($data['translations'] as $locale => $fields) {
                $this->translations[$locale] = [];
                if (isset($fields['title'])) {
                    $this->translations[$locale]['title'] = (string)$fields['title'];
                }
                if (isset($fields['description'])) {
                    $this->translations[$locale]['description'] = (string)$fields['description'];
                }
                if (isset($fields['meta_title'])) {
                    $this->translations[$locale]['meta_title'] = (string)$fields['meta_title'];
                }
                if (isset($fields['meta_description'])) {
                    $this->translations[$locale]['meta_description'] = (string)$fields['meta_description'];
                }
            }
        } else {
          $this->translations = [];
        }
        // $this->locale = (string) $data['locale'];
    }
}
