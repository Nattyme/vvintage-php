<?php

declare(strict_types=1);

namespace Vvintage\Repositories\Post;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

/** Контракты */
use Vvintage\Contracts\Post\PostRepositoryInterface;

/** Абстрактный репозиторий */
use Vvintage\Repositories\AbstractRepository;

/** Модели */
use Vvintage\Models\Post\Post;
use Vvintage\DTO\PostCategory\PostCategoryDTO;
use Vvintage\DTO\Post\PostDTO;


final class PostRepository extends AbstractRepository implements PostRepositoryInterface
{  
    private const TABLE = 'posts';
    private const TABLE_TRANSLATION = 'posts_translation';

    private const TABLE_CATEGORIES = 'posts_categories';
    private const TABLE_CATEGORIES_TRANSLATION = 'posts_categories_translation';

    private string $currentLang;
    private const DEFAULT_LANG = 'ru';

    public function __construct(string $currentLang = self::DEFAULT_LANG)
    {
        $this->currentLang = $currentLang;
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
            $sql .= ' WHERE p.id = ? GROUP BY p.id LIMIT 1';
            $bindings[] = $postId;
            // ⬇Заворачиваем в массив
            $row = R::getRow($sql, $bindings);

            return $row ?[$row] : [];
        } else {
            $sql .= ' GROUP BY p.id ORDER BY p.id DESC';
            return R::getAll($sql, $bindings);
        }
    }


    private function loadTranslations(int $postId): array
    {
        $rows = R::getAll(
            'SELECT locale, title, slug, description, content, meta_title, meta_description 
             FROM ' . self::TABLE_TRANSLATION .' 
             WHERE post_id = ?',
            [$postId]
        );

        $translations = [];
        foreach ($rows as $row) {
            $translations[$row['locale']] = [
                'title' => $row['title'],
                'slug' => $row['slug'],
                'description' => $row['description'],
                'content' => $row['content'],
                'meta_title' => $row['meta_title'],
                'meta_description' => $row['meta_description'],
            ];
        }

        return $translations;
    }

    private function createCategoryDTOFromArray(array $row): PostCategoryDTO
    {
        $locale = $this->currentLang ?? self::DEFAULT_LANG;;

        return new PostCategoryDTO([
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


    private function fetchPostWithJoins(array $row): Post
    {
        $postId = (int) $row['id'];

        $translations = $this->loadTranslations($postId);
    
        $categoryDTO = $this->createCategoryDTOFromArray($row);

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
                $posts = array_map([$this, 'fetchPostWithJoins'], $beans);;
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
}
