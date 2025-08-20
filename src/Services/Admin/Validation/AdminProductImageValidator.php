<?php
declare(strict_types=1);

namespace Vvintage\Services\Admin\Validation;

final class AdminProductImageValidator
{
    public static function validate(array $data): array
    {
        $errors = [];

        if (!isset($data['filename']) || !is_string($data['filename']) || empty($data['filename'])) {
            $errors['filename'] = 'Имя файла обязательно';
        }

        if (!isset($data['product_id']) || !is_int($data['product_id'])) {
            $errors['product_id'] = 'Номер продукта обязателен и должен быть числом.';
        }

        if (!isset($data['image_order']) || !is_int($data['image_order'])) {
            $errors['image_order'] = 'Порядок изображений должен быть числовым';
        }

          return ['errors' => $errors];
    }
}
