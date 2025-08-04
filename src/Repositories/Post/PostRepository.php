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
    private const TABLE_POSTS = self::TABLE_POSTS;

    public function getPostById(int $id): ?Post
    {
        $bean = $this->findById(self::TABLE_POSTS, 'id = ?', [$id]);
        return $bean ? Post::fromBean($bean) : null;
    }

    public function getAllPosts(array $pagination): array
    {
        $beans = $this->findAll(self::TABLE_POSTS, 'ORDER BY id DESC ' . $pagination['sql_page_limit']);
        return array_map(fn($bean) => Post::fromBean($bean), $beans);
    }

    public function getPostsByIds(array $ids): array
    {
        $beans =  $this->findByIds(self::TABLE_POSTS, $ids);

        return array_map(fn($bean) => Post::fromBean($bean), $beans);
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
