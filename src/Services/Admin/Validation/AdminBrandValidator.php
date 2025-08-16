<?php
declare(strict_types=1);

namespace Vvintage\Services\Admin\Validation;

use Vvintage\Services\Messages\FlashMessage;

final class AdminBrandValidator
{
    private FlashMessage $flash;

    public function __construct()
    {
        $this->flash = new FlashMessage();
    }

    public function new(array &$data): bool
    {
        $valid = true;

        // Обязательные поля
        $valid = $this->validateRequired($data, 'title', 'Заполните название бренда') && $valid;
        $valid = $this->validateRequired($data, 'description', 'Заполните описание бренда') && $valid;
        $valid = $this->validateRequired($data, 'meta_title', 'Заполните SEO заголовок страницы бренда') && $valid;
        $valid = $this->validateRequired($data, 'meta_description', 'Заполните SEO описание страницы бренда') && $valid;

        // Длина
        $valid = $this->validateLength($data['title'] ?? [], 2, 255, 'Название бренда') && $valid;
        $valid = $this->validateLength($data['meta_title'] ?? [], 5, 70, 'SEO заголовок') && $valid;
        $valid = $this->validateLength($data['meta_description'] ?? [], 10, 160, 'SEO описание') && $valid;

        // Проверка допустимых символов + автоочистка
        $valid = $this->validateAllowedChars($data, 'title', 'Название бренда') && $valid;

        // Логотип
        if (!empty($_FILES['image']['name'])) {
            $valid = $this->validateImage($_FILES['image']) && $valid;
        }

        return $valid;
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
                $this->flash->pushError('Пустое поле', $message, $flagPath);
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
                $this->flash->pushError(
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

            // Автоочистка недопустимых символов
            $cleaned = preg_replace($cleanupPattern, '', $trimmed);

            // Если были недопустимые символы, пушим сообщение об ошибке
            if ($trimmed !== '' && $trimmed !== $cleaned) {
                $flagPath = HOST . "static/img/svgsprite/stack/svg/sprite.stack.svg#flag-$lang";
                $this->flash->pushError(
                    'Недопустимые символы',
                    "$fieldLabel был автоматически очищен от лишних символов",
                    $flagPath
                );
                $valid = false;
            }

            // Приведение к нормальному формату: первая буква заглавная
            $cleaned = mb_strtolower($cleaned, 'UTF-8'); 
            if ($cleaned !== '') {
                $cleaned = mb_strtoupper(mb_substr($cleaned, 0, 1, 'UTF-8')) 
                        . mb_substr($cleaned, 1, null, 'UTF-8');
            }

            $data[$fieldName][$lang] = $cleaned;
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
            $this->flash->pushError('Ошибка загрузки', 'Не удалось загрузить логотип');
            return false;
        }

        $maxSize = 2 * 1024 * 1024; // 2MB
        if ($file['size'] > $maxSize) {
            $this->flash->pushError('Слишком большой файл', 'Максимальный размер логотипа — 2 МБ');
            $valid = false;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'];
        if (!in_array($mime, $allowed, true)) {
            $this->flash->pushError('Неверный формат', 'Допустимые форматы: JPG, PNG, WEBP, SVG');
            $valid = false;
        }

        return $valid;
    }
}
