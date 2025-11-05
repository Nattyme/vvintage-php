<?php
declare(strict_types=1);

namespace Vvintage\Admin\DTO\Post;

use Vvintage\Config\LanguageConfig; 

/** Model */
use Vvintage\Models\Post\Post;
use Vvintage\Admin\DTO\Post\PostEditDTO;
use Vvintage\Utils\Services\Locale\LocaleService;

final class PostEditDTOFactory
{
    private string $currentLang;

    public function __construct(private LocaleService $localeService) 
    {
      $this->localeService = $localeService;
      $this->currentLang = LanguageConfig::getDefault();
    }

    public function createFromPost(Post $post): PostEditDTO
    {
        $category = $post->getCategory();
        $coverFile = $post->getCover() && file_exists(HOST . 'usercontent/blog/' . $post->getCover())
                    ? h($post->getCover())
                    : 'no-photo@2x.jpg';

        return new PostEditDTO(
            id: (int) ($post->getId() ?? null),
            title: (string) ($post->getTitle($this->currentLang) ?? ''),
            description: (string) ($post->getDescription($this->currentLang) ?? ''),
            content: (string) ($post->getContent($this->currentLang) ?? ''),
            slug: (string) ($post->getSlug() ?? ''),

            category_id : (int) ($category->getId() ?? null),
            category_parent_id : (int) ($category->getParentId() ?? null),
            category_title : (string) ($category->getTitle($this->currentLang) ?? ''),
   

            formatted_date: (string) ( $this->localeService->formatDateTime($post->getDateTime()) ),
            iso_date:(string) $post->getDateTime()->format('c'),
            cover_small: (string) $coverFile,
            edit_time: (string) $post->getEditTime(),
            translations: $post->getTranslation()
        );
    }
}
