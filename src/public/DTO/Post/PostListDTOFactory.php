<?php
declare(strict_types=1);

namespace Vvintage\public\DTO\Post;

use Vvintage\public\DTO\Post\PostListDTO;

/** Model */
use Vvintage\public\Models\Post\Post;

use Vvintage\public\Services\Locale\LocaleService;

final class PostListDTOFactory
{
    public function __construct(
        private LocaleService $localeService
    ) {
      $this->localeService = $localeService;
    }

    public function createFromPost(Post $post): PostListDTO
    {
        $currentLang = $this->localeService->getCurrentLang();
        $category = $post->getCategory();
        $coverFile = $post->getCoverSmall() && file_exists(HOST . 'usercontent/blog/' . $post->getCoverSmall())
                    ? h($post->getCoverSmall())
                    : 'no-photo@2x.jpg';

        return new PostListDTO(
            id: (int) ($post->getId() ?? null),
            title: (string) ($post->getTitle($currentLang) ?? ''),
            description: (string) ($post->getDescription($currentLang) ?? ''),

            category_id : (int) ($category->getId() ?? null),
            category_parent_id : (int) ($category->getParentId() ?? null),
            category_title : (string) ($category->getTitle($currentLang) ?? ''),
   

            formatted_date: (string) ( $this->localeService->formatDateTime($post->getDateTime()) ),
            iso_date:(string) $post->getDateTime()->format('c'),
            cover_small: (string) $coverFile,
            views: (int)  ($post->getViews() ?? 0)
        );
    }
}

