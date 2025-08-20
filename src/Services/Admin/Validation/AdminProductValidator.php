<?php
declare(strict_types=1);

namespace Vvintage\Services\Admin\Validation;

final class AdminProductValidator
{

  /**
   * Формат ответа с сервера
   * { "success": true|false, "errors": { "field_name": ["Сообщение 1", "Сообщение 2"], "another_field": ["Ошибка"] }, "data": { "id": 123, ... } }
   * вернуть из валидатора { "field_name": ["Сообщение 1", "Сообщение 2"], "another_field": ["Ошибка"] }, возможно data
   */
    // public static function validate(array $data): array
    // {
    //     $errors = [];
    //     error_log(print_r($data, true));
    //     // title
    //     if (empty($data['title']) || !is_string($data['title'])) {
    //         $errors['title'] = 'Поле названия должно быть строкой';
    //     }

    //     // price
    //     if (!isset($data['price']) || !is_numeric($data['price'])) {
    //         $errors['price'] = 'Поле цены должно быть числом';
    //     }

    //     // sku
    //     if (empty($data['sku']) || !is_string($data['sku'])) {
    //         $errors['sku'] = 'Поле sku обязательно для заполнения';
    //     }

    //     // stock
    //     if (!isset($data['stock']) || !is_numeric( $data['stock'])) {
    //         $errors['stock'] = 'Поле сток должно быть числом';
    //     }

    //     if (!isset($data['category_id']) || !is_numeric( $data['category_id'] )) {
    //       $errors['category_id'] = 'Выберите категорию товара';
    //     }

    //     if (!isset($data['brand_id']) || !is_numeric( $data['brand_id'] )) {
    //       $errors['brand_id'] = 'Выберите бренд товара';
    //     }


    //     // url (необязательное поле, но если есть, то проверяем формат)
    //     if (!empty($data['url']) && !filter_var($data['url'], FILTER_VALIDATE_URL)) {
    //         $errors['url'] = 'Поле URL невалидно';
    //     }

    //     if (empty($data['url'])) {
    //         $errors['url'] = 'Поле URL пустое';
    //     }

    //     // status
    //     if (!isset($data['status']) || !in_array($data['status'], ['active','inactive'], true)) {
    //         $errors['status'] = 'Поле статус должно быть активным ил не активным';
    //     }

    //     return ['errors' => $errors];
    // }

    public static function validate(array $data): array
    {
        $errors = [];

        // title
        $title = trim($data['title'] ?? '');
        $errors['title'] = [];
        if ($title === '') {
            $errors['title'][] = 'Поле названия не может быть пустым';
        } elseif (!is_string($title)) {
            $errors['title'][] = 'Поле названия должно быть строкой';
        } elseif (ctype_digit($title)) {
            $errors['title'][] = 'Название не может состоять только из цифр';
        } elseif (!preg_match('/^[\p{L}\d\s]+$/u', $title)) {
            $errors['title'][] = 'Название может содержать только буквы, цифры и пробелы';
        }
        if (empty($errors['title'])) {
            unset($errors['title']);
        }

        $slug = trim($data['slug'] ?? '');
        $errors['slug'] = [];
        if ($slug === '') {
            $errors['slug'][] = 'Поле slug не может быть пустым';
        } elseif (!is_string($slug)) {
            $errors['slug'][] = 'Поле slug должно быть строкой';
        } elseif (ctype_digit($slug)) {
            $errors['slug'][] = 'Поле slug не может состоять только из цифр';
        } elseif (!preg_match('/^[\p{L}\d\s]+$/u', $slug)) {
            $errors['slug'][] = 'Поле slug может содержать только буквы, цифры и пробелы';
        }
        if (empty($errors['slug'])) {
            unset($errors['slug']);
        }

        // price
        $errors['price'] = [];
        if (!isset($data['price']) || !is_numeric($data['price'])) {
            $errors['price'][] = 'Поле цены должно быть числом';
        }
        if (empty($errors['price'])) {
            unset($errors['price']);
        }

        // sku
        $sku = trim($data['sku'] ?? '');
        $errors['sku'] = [];
        if ($sku === '') {
            $errors['sku'][] = 'Поле SKU обязательно для заполнения';
        } elseif (!is_string($sku)) {
            $errors['sku'][] = 'SKU должно быть строкой';
        }
        if (empty($errors['sku'])) {
            unset($errors['sku']);
        }

        // stock
        $errors['stock'] = [];
        if (!isset($data['stock']) || !is_numeric($data['stock'])) {
            $errors['stock'][] = 'Поле stock должно быть числом';
        }
        if (empty($errors['stock'])) {
            unset($errors['stock']);
        }

        // category_id
        $errors['category_id'] = [];
        if (!isset($data['category_id']) || !is_numeric($data['category_id'])) {
            $errors['category_id'][] = 'Выберите категорию товара';
        }
        if (empty($errors['category_id'])) {
            unset($errors['category_id']);
        }

        // brand_id
        $errors['brand_id'] = [];
        if (!isset($data['brand_id']) || !is_numeric($data['brand_id'])) {
            $errors['brand_id'][] = 'Выберите бренд товара';
        }
        if (empty($errors['brand_id'])) {
            unset($errors['brand_id']);
        }

        // url (необязательное поле)
        $url = trim($data['url'] ?? '');
        $errors['url'] = [];
        if ($url !== '' && !filter_var($url, FILTER_VALIDATE_URL)) {
            $errors['url'][] = 'Поле URL невалидно';
        }
        if (empty($errors['url'])) {
            unset($errors['url']);
        }

        // status
        $errors['status'] = [];
        if (!isset($data['status']) || !in_array($data['status'], ['active','inactive'], true)) {
            $errors['status'][] = 'Поле статус должно быть active или inactive';
        }
        if (empty($errors['status'])) {
            unset($errors['status']);
        }

        return ['errors' => $errors];
    }

}
