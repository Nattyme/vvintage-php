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
use Vvintage\DTO\PostCategory\PostCategoryOutputDTO;
use Vvintage\DTO\Post\PostDTO;


// final class PostRepository extends AbstractRepository implements PostRepositoryInterface
final class PostRepository extends AbstractRepository 
{  
    private const TABLE = 'posts';

    private function createPostBean(): OODBBean 
    {
        return $this->createBean(self::TABLE);
    }

    public function getPostById(int $id): ?Post
    {
      return array_values($this->getPosts(['id' => $id]))[0];
    }

    public function getPosts(array $filters = []): array 
    {
        $conditions = [];
        $pagination = [];
        $params = [];

        if(isset($filters['pagination'])) {
           $pagination = $filters['pagination'];
        }

        // применяем простые фильтры
        [$conditions, $params] = $this->applySimpleFilters($filters, $conditions, $params);

         // применяем сложные фильтры
        [$conditions, $params, $orderBy] = $this->applyAdvancedFilters($filters, $conditions, $params);

        // Вызов универсального метода
        $beans = $this->findAll(
            table: self::TABLE,
            conditions: $conditions,
            params: $params,
            orderBy: $orderBy,
            limit:  $pagination['perPage'] ?? null,
            offset: $pagination['offset'] ?? null
        );

        $posts = array_map(fn($bean) => Post::fromBean($bean), $beans);

        return $posts;
    }

    private function applySimpleFilters(array $filters, array $conditions, array $params): array
    {
        if (isset($filters['id'])) {
            $conditions[] = "id = ?";
            $params[] = (int)$filters['id'];
        }

        // if (isset($filters['status'])) {
        //     $conditions[] = "status = ?";
        //     $params[] = $filters['status'];
        // }

        if (isset($filters['category_id'])) {
            $conditions[] = "category_id = ?";
            $params[] = (int)$filters['category_id'];
        }

        // $limit = !empty($filters['perPage']) ? (int)$filters['perPage'] : 20;

        return [$conditions, $params];
    }

    private function applyAdvancedFilters(array $filters, array $conditions, array $params): array
    {

        // категории
        if (!empty($filters['categories'])) {
            $placeholders = $this->genSlots($filters['categories']);
            $conditions[] = "category_id IN ($placeholders)";
            $params = array_merge($params, $filters['categories']);
        }

        // сортировка
        $orderBy = 'datetime DESC';
        $allowedSorts = ['id ASC', 'id DESC', 'datetime DESC'];
        if (!empty($filters['sort']) && in_array($filters['sort'], $allowedSorts)) {
            $orderBy = $filters['sort'];
        }


        return [$conditions, $params, $orderBy];
    }

    public function getLastPosts(int $count) 
    {
      $filter['pagination']['perPage'] = $count;
      return $this->getPosts( $filter);
    }

    public function getParamsFromColumn(string $column): array 
    {
      return $this->getDistinctColumnValues(self:: TABLE, $column);
    }


    private function loadTranslations(int $postId): array
    {
        $sql =  'SELECT locale, title, slug, description, content, meta_title, meta_description 
             FROM ' . self::TABLE_TRANSLATION .' 
             WHERE post_id = ?';
        $rows = $this->getAll($sql, [$postId]);

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

    public function getPostsByIds(array $ids): array
    {
         if (empty($ids)) {
            return [];
        }

        $posts = [];
        foreach ($ids as $id) {
          $post = $this->getPostById($id);
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



    public function findBySlug(string $slug): PostCategoryDTO
    {
        $row = $this->findOneBy(self::TABLE_CATEGORIES, 'slug = ?', [$slug]);
        return $this->createCategoryOutputDTO($row);
    }

}
