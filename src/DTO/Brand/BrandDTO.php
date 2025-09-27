<?php
declare(strict_types=1);

namespace Vvintage\DTO\Brand;

class BrandDTO
{
    // public int $id;
    public ?string $title;
    public ?string $description;
    public string $image;
    // public array $translations; // ['ru' => ['title'=>..., 'description'=>...], 'en' => [...]];
    // public string $locale;

    public function __construct(array $data)
    {
        // $this->id = (int)($data['id'] ?? 0);
        $this->title = $data['title'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->image = $data['image'] ?? null;

        
        // if (isset($data['translations']) && is_array($data['translations'])) {
        //     foreach ($data['translations'] as $locale => $fields) {
        //         $this->translations[$locale] = [];
        //         if (isset($fields['title'])) {
        //             $this->translations[$locale]['title'] = (string)$fields['title'];
        //         }
        //         if (isset($fields['description'])) {
        //             $this->translations[$locale]['description'] = (string)$fields['description'];
        //         }
        //         if (isset($fields['meta_title'])) {
        //             $this->translations[$locale]['meta_title'] = (string)$fields['meta_title'];
        //         }
        //         if (isset($fields['meta_description'])) {
        //             $this->translations[$locale]['meta_description'] = (string)$fields['meta_description'];
        //         }
        //     }
        // } else {
        // $this->translations = [];
          
        // }
        // $this->locale = (string) $data['locale'];
    }
}
