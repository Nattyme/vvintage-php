<?php

declare(strict_types=1);

namespace Vvintage\Repositories\Post;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

/** Контракты */
// use Vvintage\Contracts\Post\PostTranslationRepositoryInterface;
use Vvintage\DTO\Post\PostTranslationInputDTO;

/** Абстрактный репозиторий */
use Vvintage\Repositories\AbstractRepository;

// final class PostTranslationRepository.php extends AbstractRepository implements PostRepositoryInterface
final class PostTranslationRepository extends AbstractRepository 
{ 
    private const TABLE = 'poststranslation';

    /** Создаёт новый OODBBean для перевода продукта */
    public function createPostTranslateBean(): OODBBean 
    {
      return $this->createBean(self::TABLE);
    }

    public function createTranslateInputDto(array $data, int $postId): array
    {
      $postTranslationsDto = [];
  
      foreach($data as $locale => $translate) {
          $postTranslationsDto[] = new PostTranslationInputDTO([
              'post_id' => (int) $postId,
              'slug' => (string) ($translate['slug'] ?? ''),
              'locale' => (string) $locale, 
              'title' => (string) ($translate['title'] ?? ''),
              'description' => (string) ($translate['description'] ?? ''),
              'content' => (string) ($translate['content'] ?? ''),
              'meta_title' => (string) ($translate['meta_title'] ?? $translate['title'] ?? ''),
              'meta_description' => (string) ($translate['meta_description'] ?? $translate['description'] ?? '')
          ]);
      }
         
      return  $postTranslationsDto;

    }

    public function loadTranslations(int $postId): array
    {
        $sql = 'SELECT *
                FROM ' . self::TABLE .' 
                WHERE post_id = ?';
        $rows = $this->getAll($sql, [$postId]);


        $translations = [];
        foreach ($rows as $row) {
            $translations[$row['locale']] = [
                'title' => $row['title'] ?? '',
                'description' => $row['description'] ?? '',
                'content' => $row['content'] ?? '',
                'meta_title' => $row['meta_title'] ?? '',
                'meta_description' => $row['meta_description'] ?? '',
            ];
        }
        return $translations;
    }
    

    public function getLocaleTranslation(int $id, string $locale): array 
    {

      $translations = $this->loadTranslations($id);

      return $translations[$locale] ?? [
            'title' => '',
            'description' => '',
            'meta_title' => '',
            'meta_description' => ''
        ];

    }

    public function savePostTranslation(array $translateDto): ?array
    {
        $ids = [];

        foreach ($translateDto as $dto) {
            // if (!$dto) {
            //     return null;
            // }
            if (!$dto) {
              throw new \RuntimeException("Не удалось обновить переводы статьи");
            }


            // ищем существующий перевод
            $bean = $this->findOneBy(self::TABLE, ' post_id = ? AND locale = ? ', [$dto->post_id, $dto->locale]);

            if (!$bean) {
                // если нет → создаём новый
                $bean = $this->createPostTranslateBean();
                $bean->post_id = $dto->post_id;
                $bean->locale = $dto->locale;
            }

            // обновляем данные
            $bean->slug = $dto->slug;
            $bean->title = $dto->title;
            $bean->description = $dto->description;
            $bean->meta_title = $dto->meta_title;
            $bean->meta_description = $dto->meta_description;

            $result = $this->saveBean($bean);

            if (!$result) {
              throw new \RuntimeException("Не удалось обновить переводы статьи");
            }

            $ids[] = (int) $bean->id;
        }

        return $ids;
    }

    
    

    































































    private function unitePostRawData(?int $postId = null): array
    {

        $sql = '
            SELECT 
                p.*,
                pt.locale,
                pt.content,
                pt.title,
                pt.description,
                pt.meta_title,
                pt.meta_description,
                c.id AS category_id,
                c.title AS category_title,
                c.parent_id AS category_parent_id,
                c.image AS category_image,
                ct.title AS category_title_translation,
                ct.description AS category_description,
                ct.meta_title AS category_meta_title,
                ct.meta_description AS category_meta_description
            FROM ' . self::TABLE .' p
            LEFT JOIN ' . self::TABLE_TRANSLATION .' pt ON pt.post_id = p.id AND pt.locale = ?
            LEFT JOIN ' . self::TABLE_CATEGORIES .' c ON p.category_id = c.id
            LEFT JOIN ' . self::TABLE_CATEGORIES_TRANSLATION . ' ct ON ct.category_id = c.id AND ct.locale = ?
        ';

        $locale = $this->currentLang ?? self::DEFAULT_LANG;
        $bindings = [$locale, $locale];

        if ($postId !== null) {
            $sql .= ' WHERE p.id = ? LIMIT 1';
            $bindings[] = $postId;
            // ⬇Заворачиваем в массив
            $row = R::getRow($sql, $bindings);

            return $row ?[$row] : [];
        } else {
            $sql .= ' GROUP BY p.id ORDER BY p.id DESC';
            return $this->getAll($sql, $bindings);
        }
    }



    private function createCategoryOutputDTO(array $row): PostCategoryOutputDTO
    {
        $locale = $this->currentLang ?? self::DEFAULT_LANG;;

        return new PostCategoryOutputDTO([
            'id' => (int) $row['category_id'],
            'title' => (string) ($row['category_title_translation'] ?? ''),
            'parent_id' => (int) ($row['category_parent_id'] ?? 0),
            'image' => (string) ($row['category_image'] ?? ''),
            'translations' => [
                $locale => [
                    'slug' => $row['category_slug_translation'] ?? '',
                    'title' => $row['category_title_translation'] ?? '',
                    'description' => $row['category_description'] ?? '',
                    'seo_title' => $row['category_meta_title'] ?? '',
                    'seo_description' => $row['category_meta_description'] ?? '',
                ]
            ],
            'locale' => $locale,
        ]);
    }
    // private function createCategoryDTOFromArray(array $row): PostCategoryOutputDTO
    // {
    //     $locale = $this->currentLang ?? self::DEFAULT_LANG;;

    //     return new PostCategoryDTO([
    //         'id' => (int) $row['category_id'],
    //         'title' => (string) ($row['category_title_translation'] ?? ''),
    //         'parent_id' => (int) ($row['category_parent_id'] ?? 0),
    //         'image' => (string) ($row['category_image'] ?? ''),
    //         'translations' => [
    //             $locale => [
    //                 'slug' => $row['category_slug_translation'] ?? '',
    //                 'title' => $row['category_title_translation'] ?? '',
    //                 'description' => $row['category_description'] ?? '',
    //                 'seo_title' => $row['category_meta_title'] ?? '',
    //                 'seo_description' => $row['category_meta_description'] ?? '',
    //             ]
    //         ],
    //         'locale' => $locale,
    //     ]);
    // }


    private function fetchPostWithJoins(array $row): Post
    {
        $postId = (int) $row['id'];

        $translations = $this->loadTranslations($postId);
    
        $categoryDTO = $this->createCategoryOutputDTO($row);

        $dto = new PostDTO([
            'id' => (int) $row['id'],
            'categoryDTO' => $categoryDTO,
            'title' => (string) $row['title'],
            'description' => (string) $row['description'],
            'content' => (string) $row['content'],
            'slug' => (string) $row['slug'],
            'views' => (int) $row['views'],
            'cover' => (string) $row['cover'],
            'cover_small' => (string) $row['cover_small'],
            'datetime' => (string) $row['datetime'],
            'translations' => $translations,
            'locale' => $this->currentLang ?? self::DEFAULT_LANG
        ]);

        return Post::fromDTO($dto);
    }

   
    public function getPostById(int $id): ?Post
    {
        $rows = $this->unitePostRawData($id);
       
        return $rows ? $this->fetchPostWithJoins($rows[0]) : null;
    }

    public function getAllPosts(array $pagination): array
    {
        $rows = $this->unitePostRawData();

        return array_map([$this, 'fetchPostWithJoins'], $rows);
    }

    public function getPostsByIds(array $ids): array
    {
         if (empty($ids)) {
            return [];
        }

        $posts = [];
        foreach ($ids as $id) {
            $beans = $this->unitePostRawData($id);
            if ($beans) {
                $posts[] = $this->fetchPostWithJoins($beans[0]);
            }
        }

        return $posts;
    }

    public function savePost (Post $post): int
    {
        $bean = $this->createBean(self::TABLE_POSTS);

        $bean->title = $post->title;
        $bean->cat = $post->cat;
        $bean->description = $post->description;
        $bean->content = $post->content;
        $bean->timestamp = $post->timestamp;
        $bean->views = $post->views;
        $bean->cover = $post->cover;
        $bean->cover_small = $post->cover_small;
        $bean->edit_time = $post->edit_time;

        return (int) $this->saveBean($bean);
    }

    public function getAllPostsCount (?string $sql = null, array $params = []): int
    {
      return $this->countAll(self::TABLE, $sql, $params);
    }

    /* :::::::: Категории :::::::: */

    // Получаем категорию поста
    // public function getCategory(Post $post): PostCategoryDTO 
    // {
    //     $catId = $post->getCategory()->getId();
    //     $row = $this->loadBean(self::TABLE_CATEGORIES, $catId);

    //     return $this->createCategoryDTOFromArray($row);
    // }

    public function findBySlug(string $slug): PostCategoryDTO
    {
        $row = $this->findOneBy(self::TABLE_CATEGORIES, 'slug = ?', [$slug]);
        return $this->createCategoryOutputDTO($row);
    }


    // public function getAllDTO(): array
    // {
    //     $rows = $this->findAll(self::TABLE_CATEGORIES);
    //     return array_map([ $this, 'createCategoryDTOFromArray'], $rows);
    // }
}
