<?php
declare(strict_types=1);

namespace Vvintage\admin\Services\Validation;

abstract class AdminBaseValidator
{
    protected array $errors = [];

    protected function validateTranslation(array $translations): void
    {
        foreach (['ru', 'en'] as $lang) {
            if (!isset($translations[$lang])) {
                $this->errors['translations'][$lang][] = "Перевод для $lang обязателен";
                continue;
            }

            $this->validateTitle($translations[$lang]['title'] ?? '', $lang);
            $this->validateDescription($translations[$lang]['description'] ?? '', $lang);
            $this->validateSeoTitle($translations[$lang]['meta_title'] ?? '', $lang);
            $this->validateSeoDescription($translations[$lang]['meta_description'] ?? '', $lang);
        }
    }

    protected function validateTitle(?string $title, ?string $lang): void
    {
        $title = trim($title ?? '');

        if ($title === '') {
            $this->errors['title'][$lang][] = 'Поле названия не может быть пустым';
        } elseif (!is_string($title)) {
            $this->errors['title'][$lang][] = 'Поле названия должно быть строкой';
        } elseif (ctype_digit($title)) {
            $this->errors['title'][$lang][] = 'Название не может состоять только из цифр';
        } 
        // elseif (!preg_match('/^[\p{L}\d\s]+$/u', $title)) {
        //     $this->errors['title'][$lang][] = 'Название может содержать только буквы, цифры и пробелы';
        // }

        if (empty($this->errors['title'][$lang])) {
            unset($this->errors['title'][$lang]);
        }
    }

    protected function validateSeoTitle(?string $title, ?string $lang): void
    {
        $title = trim($title ?? '');

        if ($title === '') {
            $this->errors['meta_title'][$lang][] = 'Поле сео названия не может быть пустым';
        } elseif (!is_string($title)) {
            $this->errors['meta_title'][$lang][] = 'Поле сео названия должно быть строкой';
        } elseif (ctype_digit($title)) {
            $this->errors['meta_title'][$lang][] = 'Заголовок сео не может состоять только из цифр';
        } 
        // elseif (!preg_match('/^[\p{L}\d\s]+$/u', $title)) {
        //     $this->errors['title'][$lang][] = 'Название может содержать только буквы, цифры и пробелы';
        // }

        if (empty($this->errors['meta_title'][$lang])) {
            unset($this->errors['meta_title'][$lang]);
        }
    }

    protected function validateDescription(?string $description, ?string $lang): void
    {
        $description = trim($description ?? '');

        if ($description === '') {
            $this->errors['description'][$lang][] = 'Поле описания не может быть пустым';
        } elseif (!is_string($description)) {
            $this->errors['description'][$lang][] = 'Поле описания должно быть строкой';
        } 
        // elseif (preg_match('/^[\s.,!?()-]+$/u', $description)) {
        //     $this->errors['description'][$lang][] = 'Описание должно содержать буквы или цифры';
        // } 
        elseif (ctype_digit($description)) {
            $this->errors['description'][$lang][] = 'Описание  не может состоять только из цифр';
        } 
        // elseif (mb_strlen($description) < 20) {
        //     $this->errors['description'][$lang][] = 'Описание должно быть не менее 20 символов';
        // } 
        elseif (mb_strlen($description) > 1000) {
            $this->errors['description'][$lang][] = 'Описание слишком длинное (максимум 1000 символов)';
        }

        if (empty($this->errors['description'][$lang])) {
            unset($this->errors['description'][$lang]);
        }
    }

    protected function validateSeoDescription(?string $description, ?string $lang): void
    {
        $description = trim($description ?? '');

        if ($description === '') {
            $this->errors['meta_description'][$lang][] = 'Поле seo описания не может быть пустым';
        } elseif (!is_string($description)) {
            $this->errors['meta_description'][$lang][] = 'Поле seo описания должно быть строкой';
        } 
        // elseif (preg_match('/^[\s.,!?()-]+$/u', $description)) {
        //     $this->errors['description'][$lang][] = 'Описание должно содержать буквы или цифры';
        // } 
        elseif (ctype_digit($description)) {
            $this->errors['meta_description'][$lang][] = 'Seo описание  не может состоять только из цифр';
        } 
        // elseif (mb_strlen($description) < 20) {
        //     $this->errors['description'][$lang][] = 'Описание должно быть не менее 20 символов';
        // } 
        elseif (mb_strlen($description) > 1000) {
            $this->errors['meta_description'][$lang][] = 'Описание seo слишком длинное (максимум 1000 символов)';
        }

        if (empty($this->errors['meta_description'][$lang])) {
            unset($this->errors['meta_description'][$lang]);
        }
    }

    
    protected function synchronize(array $translations, array $data): array
    {
        // Основные поля берем с русского
        $data['title'] = $translations['ru']['title'] ?? '';
        $data['description'] = $translations['ru']['description'] ?? '';
        
        // Убедимся, что английский существует
        $translations['en']['title'] = $translations['en']['title'] ?? '';
        $translations['en']['description'] = $translations['en']['description'] ?? '';
        $translations['en']['meta_title'] = $translations['en']['meta_title'] ?? '';
        $translations['en']['meta_description'] = $translations['en']['meta_description'] ?? '';

        foreach ($translations as $lang => &$trans) {
            if (in_array($lang, ['ru', 'en'], true)) continue;

            if (empty(trim($trans['title'] ?? ''))) {
                $trans['title'] = $translations['en']['title'];
            }

            if (empty(trim($trans['description'] ?? ''))) {
                $trans['description'] = $translations['en']['description'];
            }

            if (empty(trim($trans['meta_title'] ?? ''))) {
                $trans['meta_title'] = $trans['title'] ?: $translations['en']['meta_title'];
            }

            if (empty(trim($trans['meta_description'] ?? ''))) {
                $trans['meta_description'] = $trans['description'] ?: $translations['en']['meta_description'];
            }
        }


        $data['translations'] = $translations;
        return $data;
    }


    

    protected function validateSlug(?string $slugData):void
    {
        $slug = trim($slugData ?? '');
        $this->errors['slug'] = [];

        if ($slug === '') {
            $this->errors['slug'][] = 'Поле slug не может быть пустым';
        } elseif (!is_string($slug)) {
            $this->errors['slug'][] = 'Поле slug должно быть строкой';
        } elseif (ctype_digit($slug)) {
            $this->errors['slug'][] = 'Поле slug не может состоять только из цифр';
        } 
        if (empty($this->errors['slug'])) {
            unset($this->errors['slug']);
        }
    }

}