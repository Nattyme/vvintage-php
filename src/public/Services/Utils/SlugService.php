<?php
declare(strict_types=1);

namespace Vvintage\public\Services\Utils;

class SlugService
{
    public function generate(string $text): string
    {
        $slug = strtolower(trim($text));
        $slug = preg_replace('/[^a-z0-9]+/u', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }

    public function ensureUnique(string $slug, callable $existsCheck): string
    {
        $baseSlug = $slug;
        $counter = 1;

        while ($existsCheck($slug)) {
            $slug = $baseSlug . '-' . $counter++;
        }

        return $slug;
    }

    public function isValid(string $slug): bool
    {
        return preg_match('/^[a-z0-9\-]+$/', $slug) === 1;
    }
}


// $slug = $slugService->generate($title);
// $slug = $slugService->ensureUnique($slug, function ($slug) {
//     return $slugRepo->existsInCategory($slug); // или в продукте
// });
