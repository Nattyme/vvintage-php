<?php

declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

final class PostRepository
{
    public function findById(int $id): ?OODBBean
    {
        $bean = R::findOne('posts', 'id = ?', [$id]);
        return $bean ?: null;
    }

    public function findAll(array $pagination): array
    {
        return R::findAll('posts', 'ORDER BY id DESC ' . $pagination['sql_page_limit']);
    }

    public function findByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        // Подготовим placeholders (?, ?, ?) и массив параметров
        $placeholders = R::genSlots($ids);
        $sql = "id IN ($placeholders) ORDER BY id DESC";

        return R::find('posts', $sql, $ids);
    }

    public function countAll(): int
    {
        return R::count('posts');
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

}
