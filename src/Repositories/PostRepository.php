<?php

declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

/** Модели */
use Vvintage\Models\Blog\Post;

final class PostRepository
{

  
    public function findById(int $id): ?Post
    {
        $bean = R::findOne('posts', 'id = ?', [$id]);
        return $bean ? Post::fromBean($bean) : null;
    }

    public function findAll(array $pagination): array
    {
        $beans = R::findAll('posts', 'ORDER BY id DESC ' . $pagination['sql_page_limit']);
        return array_map(fn($bean) => Post::fromBean($bean), $beans);
    }

    public function findByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        // Подготовим placeholders (?, ?, ?) и массив параметров
        $placeholders = R::genSlots($ids);
        $sql = "id IN ($placeholders) ORDER BY id DESC";

        $beans = R::find('posts', $sql, $ids);
        return array_map(fn($bean) => Post::fromBean($bean), $beans);
    }

    public function save(Post $post): int
    {
        $bean = R::dispense('posts');

        $bean->title = $post->title;
        $bean->cat = $post->cat;
        $bean->description = $post->description;
        $bean->content = $post->content;
        $bean->timestamp = $post->timestamp;
        $bean->views = $post->views;
        $bean->cover = $post->cover;
        $bean->cover_small = $post->cover_small;
        $bean->edit_time = $post->edit_time;

        return (int) R::store($bean);
    }

    public function countAll(): int
    {
      return (int) R::count('posts');
    }

}
