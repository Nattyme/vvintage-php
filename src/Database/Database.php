<?php

declare(strict_types=1);

namespace Vvintage\Database;

use RedBeanPHP\R;
use Vvintage\Config\Config;

/**
 * Класс Database управляет подключением к БД и получением данных
 */
final class Database
{
    /**
     * Подключение к БД иcпользуя ReadBean
     */
    public static function connect(): void
    {
        R::setup(
            'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME,
            Config::DB_USER,
            Config::DB_PASS
        );
        // можно включить JSON-фичи, если нужно
        // R::useJSONFeatures(true); // Настройка ReadBean, кот. сохраняет массив в БД в JSON формате
    }

    /**
     * Получение массива настроек из таблицы settings
     *
     * @return array<string, string>
    */
    public static function getSettingsArray(): array
    {
        $settingsArray = R::find('settings', ' section LIKE ? ', ['settings']);
        $result = [];

        foreach ($settingsArray as $item) {
            $result[$item->name] = $item->value;
        }

        return $result;
    }

    /**
     * Возвращает массив данных о продукте
     * @return array<string, string>
    */
    // public static function getProductRow( int $id): array
    // {
    //     // Запрашиваем информацию по продукту
    //     $sqlQuery = 'SELECT
    //         p.id,
    //         p.title,
    //         p.content,
    //         p.brand,
    //         p.category,
    //         p.price,
    //         p.timestamp,
    //         c.title AS cat_title,
    //         b.title AS brand_title
    //       FROM `products` p
    //       LEFT JOIN `categories` c ON  p.category = c.id
    //       LEFT JOIN `brands` b ON p.brand = b.id
    //       WHERE p.id = ? LIMIT 1
    //     ';

    //     $row = R::getRow($sqlQuery, [$id]);

    //     return $row;
    // }

    // public static function getProductsRow( array $pagination): array
    // {
    //   $sqlQuery = 'SELECT
    //               p.id,
    //               p.article,
    //               p.title,
    //               p.price,
    //               p.url,
    //               b.title AS brand,
    //               c.title AS category,
    //               pi.filename

    //            FROM `products` p
    //            LEFT JOIN `brands` b ON p.brand = b.id
    //            LEFT JOIN `categories` c ON p.category = c.id
    //            LEFT JOIN (
    //             SELECT product_id, filename
    //             FROM productimages
    //             WHERE image_order = 1
    //            ) pi ON p.id = pi.product_id
    //            ORDER BY p.id DESC ' . $pagination["sql_page_limit"];

    //   $rows = R::getAll($sqlQuery);

    //   return $rows;
    // }

    /**
     * Возвращает массив изображений по id продукта
     * @return array<string, string>
    */
    public static function getProductImagesRow(int $id)
    {

        // Запрашиваем информацию по тзображениям
        $sqlQuery = 'SELECT pi.filename, pi.image_order 
        FROM `productimages` pi
        WHERE product_id = ?
        ORDER BY image_order ASC';

        $row = R::getAll($sqlQuery, [$id]);

        return $row;
    }
}
