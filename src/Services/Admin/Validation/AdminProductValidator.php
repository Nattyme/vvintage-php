<?php
declare(strict_types=1);

namespace Vvintage\Services\Admin\Validation;

final class AdminProductValidator
{
  public $errors = [];

  
    public function validate(array $data): array
    {
        // Сначала синхронизация — подставим английские переводы в пустые языки
        $data = $this->synchronize($data['translations'] ?? [], $data);

        // Проверка переводов (обязательные ru и en)
        $this->validateTranslation($data['translations']);

        // Проверка остальных полей
        $this->validateSlug($data['slug'] ?? null);
        $this->validatePrice($data['price'] ?? null);
        $this->validateSku($data['sku'] ?? null);
        $this->validateStock($data['stock'] ?? null);
        $this->validateCategory($data['category_id'] ?? null);
        $this->validateBrand($data['brand_id'] ?? null);
        $this->validateUrl($data['url'] ?? null);
        $this->validateStatus($data['status'] ?? null);

        return [
            'errors' => $this->errors,
            'data' => $data
        ];
    }

    private function validateTranslation(array $translations): void
    {
        foreach (['ru', 'en'] as $lang) {
            if (!isset($translations[$lang])) {
                $this->errors['translations'][$lang][] = "Перевод для $lang обязателен";
                continue;
            }

            $this->validateTitle($translations[$lang]['title'] ?? '', $lang);
            $this->validateDescription($translations[$lang]['description'] ?? '', $lang);
        }
    }

    private function validateTitle(?string $title, ?string $lang): void
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

    private function validateDescription(?string $description, ?string $lang): void
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
            $this->errors['description'][$lang][] = 'Описание не может состоять только из цифр';
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

    /**
     * Синхронизация переводов: если остальные языки пустые — заполняем английским
     */
    // private function synchronize(array $translations, array $data): array
    // {
    //     // Основные поля берем с русского
    //     $data['title'] = $translations['ru']['title'] ?? '';
    //     $data['description'] = $translations['ru']['description'] ?? '';

    //     // Убедимся, что английский существует
    //     $translations['en']['title'] = $translations['en']['title'] ?? '';
    //     $translations['en']['description'] = $translations['en']['description'] ?? '';

    //     // Остальные языки — если пусто, подставляем английский
    //     foreach ($translations as $lang => $trans) {
    //         if (in_array($lang, ['ru','en'], true)) continue;

    //         $translations[$lang]['title'] =  $trans['title'] ?: $translations['en']['title'];;
    //         $translations[$lang]['description'] = $trans['description'] ?: $translations['en']['description'];
    //     }

    //     $data['translations'] = $translations;
    //     return $data;
    // }
    private function synchronize(array $translations, array $data): array
    {
        // Основные поля берем с русского
        $data['title'] = $translations['ru']['title'] ?? '';
        $data['description'] = $translations['ru']['description'] ?? '';

        // Убедимся, что английский существует
        $translations['en']['title'] = $translations['en']['title'] ?? '';
        $translations['en']['description'] = $translations['en']['description'] ?? '';

        foreach ($translations as $lang => &$trans) {
            if (in_array($lang, ['ru', 'en'], true)) continue;

            $titleEmpty = !isset($trans['title']) || trim($trans['title']) === '';
            $descEmpty  = !isset($trans['description']) || trim($trans['description']) === '';

            if ($titleEmpty && $descEmpty) {
                // если оба поля пустые — подставляем английские значения
                $trans['title'] = $translations['en']['title'];
                $trans['description'] = $translations['en']['description'];
            }
        }

        $data['translations'] = $translations;
        return $data;
    }



  /**
   * Формат ответа с сервера
   * { "success": true|false, "errors": { "field_name": ["Сообщение 1", "Сообщение 2"], "another_field": ["Ошибка"] }, "data": { "id": 123, ... } }
   * вернуть из валидатора { "field_name": ["Сообщение 1", "Сообщение 2"], "another_field": ["Ошибка"] }, возможно data
   */
    // public function validate(array $data): array
    // {
    //   $dataAdded = $this->textValidation($data);

  
    //   return [
    //     'errors' => $this->errors,
    //     'data' => $dataAdded
    //   ];
    
    // }

    private function textValidation (array $data): array
    {
        //  $errors = [];

        // Проверка переводов
        $this->validateTranslation($data['translations']);
        foreach ($data['translations'] as $lang => $trans) {
            // title
            $title = trim($trans['title'] ?? '');
            $errors['title'][$lang] = [];
            if ($title === '') {
                // $errors['title'][$lang] = 'Поле названия не может быть пустым';
            } elseif (!is_string($title)) {
                $errors['title'][$lang]  = 'Поле названия должно быть строкой';
            } elseif (ctype_digit($title)) {
                $errors['title'][$lang]  = 'Название не может состоять только из цифр';
            } elseif (!preg_match('/^[\p{L}\d\s]+$/u', $title)) {
               $errors['title'][$lang]  = 'Название может содержать только буквы, цифры и пробелы';
            }
            if (empty($errors['title'][$lang])) {
                unset($errors['title'][$lang] );
            }

            // description
            $description = trim($trans['description'] ?? '');
            $errors['description'][$lang] = [];
            if ($description === '') {
              // $errors['description'][$lang] = 'Поле описания не может быть пустым';
            } elseif (!is_string($description)) {
                $errors['description'][$lang] = 'Поле описания должно быть строкой';
            } elseif (preg_match('/^[\s.,!?()-]+$/u', $description)) {
                $errors['description'][$lang] = 'Описание должно содержать буквы или цифры';
            } elseif (ctype_digit($description)) {
               $errors['description'][$lang] = 'Описание не может состоять только из цифр';
            } elseif (mb_strlen($description) < 20) {
                $errors['description'][$lang] = 'Описание должно быть не менее 20 символов';
            } elseif (mb_strlen($description) > 1000) {
               $errors['description'][$lang] = 'Описание слишком длинное (максимум 1000 символов)';
            } elseif (!preg_match('/^[\p{L}\d\s.,!?()-]+$/u', $description)) {
               $errors['description'][$lang] = 'Описание содержит недопустимые символы';
            }
            if (empty( $errors['description'][$lang])) {
                unset( $errors['description'][$lang]);
            }
        }

        // Синхронизация с основными полями (русский)
        $dataAdded = $this->synchronize($data['translations'], $data);

        // slug
        $this->validateSlug($data['slug']);
    
        // price
        $this->validatePrice($data['price']);

        // sku
        $this->validateSku($data['sku']);
       
        // stock
        $this->validateStock($data['stock']);
   
        // category_id
        $this->validateCategory($data['category_id']);
       
        // brand_id
        $this->validateBrand($data['brand_id']);
       
        // url (необязательное поле)
        $this->validateUrl($data['url']);

        // status
        $this->validateStatus($data['status']);
            
        return $dataAdded;
    }

    // private function validateTranslation(?array $translation)
    // {
    //   foreach ($translation as $lang => $trans) {
    //       $this->validateTitle($trans['title'], $lang);
    //       $this->validateDescription($trans['description'], $lang);
    //   }
    // }

    // private function validateTitle(?string $titleData, ?string $lang): void
    // {
    //     $title = trim($titleData ?? '');
    //     // $this->errors['title'][$lang] = [];

    //     if ($title === '') {
    //         // $this->errors['title'][$lang][] = 'Поле названия не может быть пустым';
    //     } elseif (!is_string($title)) {
    //         $this->errors['title'][$lang][]  = 'Поле названия должно быть строкой';
    //     } elseif (ctype_digit($title)) {
    //         $this->errors['title'][$lang][]  = 'Название не может состоять только из цифр';
    //     } elseif (!preg_match('/^[\p{L}\d\s]+$/u', $title)) {
    //         // $this->errors['title'][$lang][]  = 'Название может содержать только буквы, цифры и пробелы';
    //     }
    //     if (empty($this->errors['title'][$lang])) {
    //         unset($this->errors['title'][$lang] );
    //     }
    // }

    // private function validateDescription(?string $descData, ?string $lang): void 
    // {
    //     $description = trim($descData ?? '');
    //     // $this->errors['description'][$lang] = [];

    //     if ($description === '') {
    //       $this->errors['description'][$lang][] = 'Поле описания не может быть пустым';
    //     } elseif (!is_string($description)) {
    //         $this->errors['description'][$lang][] = 'Поле описания должно быть строкой';
    //     } elseif (preg_match('/^[\s.,!?()-]+$/u', $description)) {
    //         $this->errors['description'][$lang][] = 'Описание должно содержать буквы или цифры';
    //     } elseif (ctype_digit($description)) {
    //         $this->errors['description'][$lang][] = 'Описание не может состоять только из цифр';
    //     } elseif (mb_strlen($description) < 20) {
    //         $this->errors['description'][$lang][] = 'Описание должно быть не менее 20 символов';
    //     } elseif (mb_strlen($description) > 1000) {
    //         $this->errors['description'][$lang][] = 'Описание слишком длинное (максимум 1000 символов)';
    //     } elseif (!preg_match('/^[\p{L}\d\s.,!?()-]+$/u', $description)) {
    //         // $this->errors['description'][$lang][] = 'Описание содержит недопустимые символы';
    //     }
    //     if (empty( $this->errors['description'][$lang])) {
    //         unset( $this->errors['description'][$lang]);
    //     }
    // }

    // Синхронизация с основными полями (русский)
    // private function synchronize(?array $translations, ?array $data): array
    // {
    //     if (!empty($translations['ru'])) {
    //       $data['title'] =  $translations['ru']['title'] ?? '';
    //       $data['description'] = $translations['ru']['description'] ?? '';
    //     }

    //     return $data;
    // }

    private function validateSlug(?string $slugData):void
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

    private function validatePrice(?string $priceData): void
    {
        $this->errors['price'] = [];
        if (!isset($priceData) || !is_numeric($priceData)) {
          $this->errors['price'][] = 'Поле цены должно быть числом';
        }
        if (empty($this->errors['price'])) {
            unset($this->errors['price']);
        }
    }

    private function validateSku(?string $skuData): void
    {
       $sku = trim($skuData ?? '');

        $this->errors['sku'] = [];
        if ($sku === '') {
            $this->errors['sku'][] = 'Поле SKU обязательно для заполнения';
        } elseif (!is_string($sku)) {
            $this->errors['sku'][] = 'SKU должно быть строкой';
        }
        if (empty($this->errors['sku'])) {
            unset($this->errors['sku']);
        }

    }

    private function validateStock(?string $stockData): void 
    {
      $this->errors['stock'] = [];
      if (!isset($stockData) || !is_numeric($stockData)) {
          $this->errors['stock'][] = 'Поле stock должно быть числом';
      }
      if (empty($this->errors['stock'])) {
          unset($this->errors['stock']);
      }
    }

    private function validateCategory(?string $categoryData): void 
    {
      $this->errors['category_id'] = [];
      if (!isset($categoryData) || !is_numeric($categoryData)) {
          $this->errors['category_id'][] = 'Выберите категорию товара';
      }
      if (empty($this->errors['category_id'])) {
          unset($this->errors['category_id']);
      }

    }


    private function validateBrand(?string $brandData): void 
    {
        $this->errors['brand_id'] = [];
        if (!isset($brandData) || !is_numeric($brandData)) {
            $this->errors['brand_id'][] = 'Выберите бренд товара';
        }
        if (empty($this->errors['brand_id'])) {
            unset($this->errors['brand_id']);
        }
    }

    private function validateUrl(?string $urlData): void 
    {
        $url = trim($urlData ?? '');
        $this->errors['url'] = [];
        if ($url !== '' && !filter_var($url, FILTER_VALIDATE_URL)) {
            $this->errors['url'][] = 'Поле URL невалидно';
        }
        if (empty($this->errors['url'])) {
            unset($this->errors['url']);
        }

    }

    private function validateStatus (?string $statusData): void 
    {
        $this->errors['status'] = [];
        if (!isset($statusData) || !in_array($statusData, ['active','hidden', 'archived'], true)) {
            $this->errors['status'][] = 'Поле статус должно быть "Активный", "Невидимый" или "В архиве';
        }
        if (empty($this->errors['status'])) {
            unset($this->errors['status']);
        }
    }
}
