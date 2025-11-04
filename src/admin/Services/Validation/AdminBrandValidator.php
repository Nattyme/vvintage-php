<?php
declare(strict_types=1);

namespace Vvintage\Services\Admin\Validation;

use Vvintage\Repositories\Brand\BrandRepository;
use Vvintage\Services\Admin\Validation\AdminBaseValidator;

final class AdminBrandValidator extends AdminBaseValidator
{
    public function validate(array $data): array
    {
         // Сначала синхронизация — подставим английские переводы в пустые языки
        $data = $this->synchronize($data['translations'] ?? [], $data);

        // Проверка переводов (обязательные ru и en)
        $this->validateTranslation($data['translations']);

        return [
          'errors' => $this->errors,
          'data' => $data
        ];
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

    private function validateUniqueBrand(array $data, string $fieldName): bool
    {
        $brandRepo = new BrandRepository();


        $valid = true;

        foreach ($data[$fieldName] ?? [] as $lang => $value) {
            // Приведение к стандартному виду: первая буква заглавная, остальные строчные
            $cleaned = mb_strtolower(trim((string)$value), 'UTF-8');
            if ($cleaned !== '') {
                $cleaned = mb_strtoupper(mb_substr($cleaned, 0, 1, 'UTF-8')) 
                        . mb_substr($cleaned, 1, null, 'UTF-8');
            }

            // Сохраняем нормализованное значение обратно в массив данных
            $data[$fieldName][$lang] = $cleaned;

            // Проверка уникальности без учёта регистра
            $exists = $brandRepo->existsByTitle($cleaned);
            
            if ($exists > 0) {
                $flagPath = HOST . "static/img/svgsprite/stack/svg/sprite.stack.svg#flag-$lang";
                $this->flash->pushError(
                    'Такой бренд уже существует',
                    "Бренд уже добавлен",
                    $flagPath
                );
                $valid = false;
            }
        }

        return $valid;
    }

}
