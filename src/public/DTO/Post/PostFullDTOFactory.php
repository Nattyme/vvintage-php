<?php
declare(strict_types=1);

namespace Vvintage\Public\DTO\Post;

use Vvintage\Public\DTO\Post\PostFullDto;

/** Model */
use Vvintage\Models\Post\Post;

use Vvintage\Utils\Services\Locale\LocaleService;

final class PostFullDTOFactory
{
    public function __construct(
      private LocaleService $localeService
    ) 
    {
      $this->localeService = $localeService;
    }

    public function createFromPost(Post $post): PostFullDTO
    {
        $currentLang = $this->localeService->getCurrentLang();
        $category = $post->getCategory();
        $coverFile = $post->getCover() && file_exists(HOST . 'usercontent/blog/' . $post->getCover())
                    ? h($post->getCover())
                    : 'no-photo@2x.jpg';

        return new PostFullDTO(
            id: (int) ($post->getId() ?? null),
            title: (string) ($post->getTitle($currentLang) ?? ''),
            description: (string) ($post->getDescription($currentLang) ?? ''),
            content: (string) ($post->getContent($currentLang) ?? ''),
            slug: (string) ($post->getSlug() ?? ''),

            category_id : (int) ($category->getId() ?? null),
            category_parent_id : (int) ($category->getParentId() ?? null),
            category_title : (string) ($category->getTitle($currentLang) ?? ''),
   

            formatted_date: (string) ( $this->localeService->formatDateTime($post->getDateTime()) ),
            iso_date:(string) $post->getDateTime()->format('c'),
            cover: (string) $coverFile,
            views: (int)  ($post->getViews() ?? 0)
        );
    }
}

