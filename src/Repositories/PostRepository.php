<?php

declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R; // Подключаем readbean
use Vvintage\Models\Blog\Post;

final class PostRepository
{
    public static function findById(int $id): ?Post
    {
        // Запрашиваем информацию по продукту
        $sqlQuery = 'SELECT
                        p.id, 
                        p.title, 
                        p.cat, 
                        p.description, 
                        p.content, 
                        p.timestamp, 
                        p.views,
                        p.cover,
                        p.cover_small,
                        p.edit_time
                      FROM `posts` p
                      LEFT JOIN `post_categories` c ON  p.cat = c.id
                      WHERE p.id = ? LIMIT 1
                    ';
        $row = R::getRow($sqlQuery, [$id]);

        if (!$row) {
            return null;
        }

        $post = new Post();
        $post->loadFromArray($row);
        return $post;
    }

    public static function findAll(array $pagination): array
    {
        $sqlQuery = 'SELECT
                p.id, 
                p.title, 
                p.cat, 
                p.description, 
                p.content, 
                p.timestamp, 
                p.views,
                p.cover,
                p.cover_small,
                p.edit_time
            FROM `posts` p
            LEFT JOIN `posts_categories` c ON p.cat = c.id
            ORDER BY p.id DESC ' . $pagination["sql_page_limit"];

        return R::getAll($sqlQuery);
    }

    public static function findByIds(array $idsData): array
    {

        // Массив ids
        $ids = array_keys($idsData);

        // Плейсхолдеры для запроса
        $slotString = R::genSlots($ids);

        // Находим продукты и их главное изображение
        $sql = "SELECT 
                  p.id, 
                  p.title, 
                  p.cat, 
                  p.description, 
                  p.content, 
                  p.timestamp, 
                  p.views,
                  p.cover,
                  p.cover_small,
                  p.edit_time
            FROM `posts` p
            LEFT JOIN `posts_categories` c ON p.cat = c.id
            WHERE p.id IN ($slotString)";

        $postssData = R::getAll($sql, $ids);

        $posts = [];

        foreach ($postsData as $key => $value) {
            $posts[$value['id']] = $value;
        }

        return $posts;
    }
}
