<?php
declare(strict_types=1);

namespace Vvintage\Services\Admin\Validation;

final class AdminProductValidator
{
    public static function validate(array $data): array
    {
        $errors = [];

        // title
        if (empty($data['title']) || !is_string($data['title'])) {
            $errors['title'] = 'Поле названия должно быть строкой';
        }

        // price
        if (!isset($data['price']) || !is_numeric($data['price'])) {
            $errors['price'] = 'Поле цены должно быть числом';
        }

        // sku
        if (empty($data['sku']) || !is_string($data['sku'])) {
            $errors['sku'] = 'Поле sku обязательно для заполнения';
        }

        // stock
        if (!isset($data['stock']) || !is_numeric( $data['stock'])) {
            $errors['stock'] = 'Поле сток должно быть числом';
        }

        if (!isset($data['category_id']) || !is_numeric( $data['category_id'] )) {
          $errors['category_id'] = 'Выберите категорию товара';
        }

        if (!isset($data['brand_id']) || !is_numeric( $data['brand_id'] )) {
          $errors['brand_id'] = 'Выберите бренд товара';
        }


        // url (необязательное поле, но если есть, то проверяем формат)
        if (!empty($data['url']) && !filter_var($data['url'], FILTER_VALIDATE_URL)) {
            $errors['url'] = 'Поле URL невалидно';
        }

        // status
        if (!isset($data['status']) || !in_array($data['status'], ['active','inactive'], true)) {
            $errors['status'] = 'Поле статус должно быть активным ил не активным';
        }

        return ['errors' => $errors];
    }
}
