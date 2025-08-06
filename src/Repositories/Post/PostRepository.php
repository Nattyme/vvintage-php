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
use Vvintage\Models\Blog\Post;


final class PostRepository extends AbstractRepository implements PostRepositoryInterface
{  
    private const TABLE_POSTS = 'posts';
    private const TABLE_POSTS_TRANSLATION = 'posts_translation';

    private const TABLE_POSTS_CATEGORIES = 'posts_categories';
    private const TABLE_POSTS_CATEGORIES_TRANSLATION = 'posts_categories_translation';

    private string $currentLocale;
    private const DEFAULT_LOCALE = 'ru';

    public function __construct(string $currentLocale = self::DEFAULT_LOCALE)
    {
        $this->currentLocale = $currentLocale;
    }

    private function unitePostRawData(?int $postId = null): array
    {
        $sql = '
            SELECT 
                p.*,
                pt.locale,
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
            FROM ' . self::TABLE_POSTS .' p
            LEFT JOIN ' . self:: TABLE_POSTS_TRANSLATION .' pt ON pt.product_id = p.id AND pt.locale = ?
            LEFT JOIN ' . self::TABLE_CATEGORIES .' c ON p.category_id = c.id
            LEFT JOIN ' . self::TABLE_CATEGORIES_TRANSLATION . ' ct ON ct.category_id = c.id AND ct.locale = ?
        ';

        $locale = $this->currentLocale ?? self::DEFAULT_LOCALE;
        $bindings = [$locale, $locale, $locale];

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


    private function loadTranslations(int $productId): array
    {
        $rows = R::getAll(
            'SELECT locale, title, description, meta_title, meta_description 
             FROM ' . self::TABLE_PRODUCTS_TRANSLATION .' 
             WHERE product_id = ?',
            [$productId]
        );

        $translations = [];
        foreach ($rows as $row) {
            $translations[$row['locale']] = [
                'title' => $row['title'],
                'description' => $row['description'],
                'meta_title' => $row['meta_title'],
                'meta_description' => $row['meta_description'],
            ];
        }

        return $translations;
    }

    private function createCategoryDTOFromArray(array $row): PostCategoryDTO
    {
        $locale = $this->currentLocale ?? self::DEFAULT_LOCALE;;

        return new PostCategoryDTO([
            'id' => (int) $row['category_id'],
            'title' => (string) ($row['category_title_translation'] ?? ''),
            'parent_id' => (int) ($row['category_parent_id'] ?? 0),
            'image' => (string) ($row['category_image'] ?? ''),
            'translations' => [
                $locale => [
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

        $translations = $this->loadTranslations($productId);
        $categoryDTO = $this->createCategoryDTOFromArray($row);

        $dto = new PostDTO([
            'id' => (int) $row['id'],
            'categoryDTO' => $categoryDTO,
            'slug' => (string) $row['slug'],
            'title' => (string) $row['title'],
            'description' => (string) $row['description'],
            'price' => (string) $row['price'],
            'url' => (string) $row['url'],
            'sku' => (string) $row['sku'],
            'stock' => (int) $row['stock'],
            'datetime' => (string) $row['datetime'],
            'images_total' => count($imagesDTO),
            'translations' => $translations,
            'locale' => $this->currentLocale ?? self::DEFAULT_LOCALE,
            'images' => $imagesDTO,
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
      return $this->countAll(self::TABLE_POSTS, $sql, $params);
    }
}
