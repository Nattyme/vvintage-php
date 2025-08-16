<?php
declare(strict_types=1);

namespace Vvintage\Services\Admin\Validation;

use Vvintage\Services\Messages\FlashMessage;

final class AdminBrandValidator
{
    private FlashMessage $notes;

    public function __construct()
    {
        $this->notes = new FlashMessage();
    }

    public function new(array &$data): bool // & — чтобы можно было изменять данные
    {
        $valid = true;

        // Обязательные поля
        $valid && $this->validateRequired($data, 'title', 'Заполните название бренда');
        $valid && $this->validateRequired($data, 'description', 'Заполните описание бренда');
        $valid && $this->validateRequired($data, 'meta_title', 'Заполните SEO заголовок страницы бренда');
        $valid && $this->validateRequired($data, 'meta_description', 'Заполните SEO описание страницы бренда');

        // Длина
        $valid && $this->validateLength($data['title'] ?? [], 2, 255, 'Название бренда');
        $valid && $this->validateLength($data['meta_title'] ?? [], 5, 70, 'SEO заголовок');
        $valid && $this->validateLength($data['meta_description'] ?? [], 10, 160, 'SEO описание');

        // Проверка допустимых символов + автоочистка
        $valid && $this->validateAllowedChars($data, 'title', 'Название бренда');

        // Логотип
        if (!empty($_FILES['image']['name'])) {
            $valid && $this->validateImage($_FILES['image']);
        }

        return (bool)$valid;
    }

    /**
     * Проверка обязательных полей
     */
    private function validateRequired(array $data, string $fieldName, string $message): bool
    {
        $valid = true;
        foreach ($data[$fieldName] ?? [] as $lang => $value) {
            if (trim((string)$value) === '') {
                $flagPath = HOST . "static/img/svgsprite/stack/svg/sprite.stack.svg#flag-$lang";
                $this->notes->pushError('Пустое поле', $message, $flagPath);
                $valid = false;
            }
        }
        return $valid;
    }

    /**
     * Проверка длины строки
     */
    private function validateLength(array $fields, int $min, int $max, string $fieldLabel): bool
    {
        $valid = true;
        foreach ($fields as $lang => $value) {
            $len = mb_strlen(trim((string)$value));
            if ($len < $min || $len > $max) {
                $flagPath = HOST . "static/img/svgsprite/stack/svg/sprite.stack.svg#flag-$lang";
                $this->notes->pushError(
                    'Некорректная длина',
                    "$fieldLabel должно быть от $min до $max символов",
                    $flagPath
                );
                $valid = false;
            }
        }
        return $valid;
    }

    /**
     * Проверка допустимых символов с автоочисткой
     */
    private function validateAllowedChars(array &$data, string $fieldName, string $fieldLabel): bool
    {
        $valid = true;
        $pattern = '/^[\p{L}\p{N}\s\'\-]+$/u'; // Разрешённые символы
        $cleanupPattern = '/[^\p{L}\p{N}\s\'\-]+/u'; // Всё, что нужно удалить

        foreach ($data[$fieldName] ?? [] as $lang => $value) {
            $trimmed = trim((string)$value);
            if ($trimmed !== '' && !preg_match($pattern, $trimmed)) {
                // Автоочистка
                $cleaned = preg_replace($cleanupPattern, '', $trimmed);
                $data[$fieldName][$lang] = $cleaned;

                $flagPath = HOST . "static/img/svgsprite/stack/svg/sprite.stack.svg#flag-$lang";
                $this->notes->pushError(
                    'Недопустимые символы',
                    "$fieldLabel был автоматически очищен от лишних символов",
                    $flagPath
                );
                $valid = false;
            }
        }
        return $valid;
    }

    /**
     * Проверка загруженного изображения
     */
    private function validateImage(array $file): bool
    {
        $valid = true;

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->notes->pushError('Ошибка загрузки', 'Не удалось загрузить логотип');
            return false;
        }

        $maxSize = 2 * 1024 * 1024; // 2MB
        if ($file['size'] > $maxSize) {
            $this->notes->pushError('Слишком большой файл', 'Максимальный размер логотипа — 2 МБ');
            $valid = false;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'];
        if (!in_array($mime, $allowed, true)) {
            $this->notes->pushError('Неверный формат', 'Допустимые форматы: JPG, PNG, WEBP, SVG');
            $valid = false;
        }

        return $valid;
    }
}
