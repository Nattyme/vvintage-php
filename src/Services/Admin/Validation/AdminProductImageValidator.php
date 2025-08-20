<?php
declare(strict_types=1);

namespace Vvintage\Services\Admin\Validation;

final class AdminProductImageValidator
{
    public static function validate(array $data): array
    {
        $errors = [];
  error_log(print_r( $data, true));
        if (!isset($data['file_name']) || !is_string($data['file_name']) || empty($data['file_name'])) {
            $errors['file_name'] = 'Имя файла обязательно';
        }

        // if (!isset($data['product_id']) || !is_int($data['product_id'])) {
        //     $errors['product_id'] = 'Номер продукта обязателен и должен быть числом.';
        // }

        if (!isset($data['order']) || !is_int( (int) $data['order'])) {
            $errors['order'] = 'Порядок изображений должен быть числовым';
        }

        if (!isset($data['size']) || $data['size'] > 12 * 1024 * 1024) {
            $errors['size'] = 'Размер изображения превышает';
        }

        if (!isset($data['type']) || !preg_match("/\.(gif|jpg|jpeg|png)$/i", $data['file_name'])) {
            $errors['type'] = 'Недопустимый формат файла. Файл изображения должен быть в формате gif, jpg, jpeg или png. ';
        }
    
          return ['errors' => $errors];
    }
}
