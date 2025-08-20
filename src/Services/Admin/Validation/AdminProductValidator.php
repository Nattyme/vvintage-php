<?php
declare(strict_types=1);

namespace Vvintage\Services\Admin\Validation;

final class AdminProductValidator
{
  public $errors = [];

  /**
   * Формат ответа с сервера
   * { "success": true|false, "errors": { "field_name": ["Сообщение 1", "Сообщение 2"], "another_field": ["Ошибка"] }, "data": { "id": 123, ... } }
   * вернуть из валидатора { "field_name": ["Сообщение 1", "Сообщение 2"], "another_field": ["Ошибка"] }, возможно data
   */
    public function validate(array $data): array
    {
      $this->textValidation($data);

  
      return [
        'errors' => $this->errors
      ];
        // $response['data'] = $textValidation['data'] ?? [];
     
    }

    private function textValidation (array $data): array
    {
        //  $errors = [];

        // Проверка переводов
        $this->validateTranslation($data['translations']);
        // foreach ($data['translations'] as $lang => $trans) {
        //     // title
        //     $title = trim($trans['title'] ?? '');
        //     $errors['title'][$lang] = [];
        //     if ($title === '') {
        //         // $errors['title'][$lang] = 'Поле названия не может быть пустым';
        //     } elseif (!is_string($title)) {
        //         $errors['title'][$lang]  = 'Поле названия должно быть строкой';
        //     } elseif (ctype_digit($title)) {
        //         $errors['title'][$lang]  = 'Название не может состоять только из цифр';
        //     } elseif (!preg_match('/^[\p{L}\d\s]+$/u', $title)) {
        //        $errors['title'][$lang]  = 'Название может содержать только буквы, цифры и пробелы';
        //     }
        //     if (empty($errors['title'][$lang])) {
        //         unset($errors['title'][$lang] );
        //     }

        //     // description
        //     $description = trim($trans['description'] ?? '');
        //     $errors['description'][$lang] = [];
        //     if ($description === '') {
        //       // $errors['description'][$lang] = 'Поле описания не может быть пустым';
        //     } elseif (!is_string($description)) {
        //         $errors['description'][$lang] = 'Поле описания должно быть строкой';
        //     } elseif (preg_match('/^[\s.,!?()-]+$/u', $description)) {
        //         $errors['description'][$lang] = 'Описание должно содержать буквы или цифры';
        //     } elseif (ctype_digit($description)) {
        //        $errors['description'][$lang] = 'Описание не может состоять только из цифр';
        //     } elseif (mb_strlen($description) < 20) {
        //         $errors['description'][$lang] = 'Описание должно быть не менее 20 символов';
        //     } elseif (mb_strlen($description) > 1000) {
        //        $errors['description'][$lang] = 'Описание слишком длинное (максимум 1000 символов)';
        //     } elseif (!preg_match('/^[\p{L}\d\s.,!?()-]+$/u', $description)) {
        //        $errors['description'][$lang] = 'Описание содержит недопустимые символы';
        //     }
        //     if (empty( $errors['description'][$lang])) {
        //         unset( $errors['description'][$lang]);
        //     }
        // }

        // Синхронизация с основными полями (русский)
        $data[] = $this->synchronize($data['translations']);
        // if (!empty($data['translations']['ru'])) {
        //     $data['title'] = $data['translations']['ru']['title'] ?? '';
        //     $data['description'] = $data['translations']['ru']['description'] ?? '';
        // }

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
       dd($this->errors);
             error_log(print_r($this->errors, true));

             

        return ['errors' => $this->errors];
    }

    private function validateTranslation($translation)
    {
      foreach ($translation as $lang => $trans) {
          $this->validateTitle($trans['title'], $lang);
          $this->validateDescription($trans['description'], $lang);
      }
    }

    private function validateTitle(?string $titleData, string $lang): void
    {
        $title = trim($titleData ?? '');
        $this->errors['title'][$lang] = [];

        if ($title === '') {
            // $errors['title'][$lang] = 'Поле названия не может быть пустым';
        } elseif (!is_string($title)) {
            $this->errors['title'][$lang]  = 'Поле названия должно быть строкой';
        } elseif (ctype_digit($title)) {
            $this->errors['title'][$lang]  = 'Название не может состоять только из цифр';
        } elseif (!preg_match('/^[\p{L}\d\s]+$/u', $title)) {
            $this->errors['title'][$lang]  = 'Название может содержать только буквы, цифры и пробелы';
        }
        if (empty($this->errors['title'][$lang])) {
            unset($this->errors['title'][$lang] );
        }
    }

    private function validateDescription(?string $descData, string $lang): void 
    {
        $description = trim($descData ?? '');
        $this->errors['description'][$lang] = [];

        if ($description === '') {
          // $errors['description'][$lang] = 'Поле описания не может быть пустым';
        } elseif (!is_string($description)) {
            $this->errors['description'][$lang] = 'Поле описания должно быть строкой';
        } elseif (preg_match('/^[\s.,!?()-]+$/u', $description)) {
            $this->errors['description'][$lang] = 'Описание должно содержать буквы или цифры';
        } elseif (ctype_digit($description)) {
            $this->errors['description'][$lang] = 'Описание не может состоять только из цифр';
        } elseif (mb_strlen($description) < 20) {
            $this->errors['description'][$lang] = 'Описание должно быть не менее 20 символов';
        } elseif (mb_strlen($description) > 1000) {
            $this->errors['description'][$lang] = 'Описание слишком длинное (максимум 1000 символов)';
        } elseif (!preg_match('/^[\p{L}\d\s.,!?()-]+$/u', $description)) {
            $this->errors['description'][$lang] = 'Описание содержит недопустимые символы';
        }
        if (empty( $this->errors['description'][$lang])) {
            unset( $this->errors['description'][$lang]);
        }
    }

    // Синхронизация с основными полями (русский)
    private function synchronize(array $translations):void
    {
        if (!empty($translations['translations']['ru'])) {
          $data['title'] =  $translations['ru']['title'] ?? '';
          $data['description'] = $translations['ru']['description'] ?? '';
        }
    }

    private function validateSlug(string $slugData):void
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

    private function validatePrice(string $priceData): void
    {
        $this->errors['price'] = [];
        if (!isset($priceData) || !is_numeric($priceData)) {
          $this->errors['price'][] = 'Поле цены должно быть числом';
        }
        if (empty($this->errors['price'])) {
            unset($this->errors['price']);
        }
    }

    private function validateSku(string $skuData): void
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

    private function validateStock(string $stockData): void 
    {
      $this->errors['stock'] = [];
      if (!isset($stockData) || !is_numeric($stockData)) {
          $this->errors['stock'][] = 'Поле stock должно быть числом';
      }
      if (empty($this->errors['stock'])) {
          unset($this->errors['stock']);
      }
    }

    private function validateCategory(int $categoryData): void 
    {
      $this->errors['category_id'] = [];
      if (!isset($categoryData) || !is_numeric($categoryData)) {
          $this->errors['category_id'][] = 'Выберите категорию товара';
      }
      if (empty($this->errors['category_id'])) {
          unset($this->errors['category_id']);
      }

    }


    private function validateBrand(int $brandData): void 
    {
        $this->errors['brand_id'] = [];
        if (!isset($brandData) || !is_numeric($brandData)) {
            $this->errors['brand_id'][] = 'Выберите бренд товара';
        }
        if (empty($this->errors['brand_id'])) {
            unset($this->errors['brand_id']);
        }
    }

    private function validateUrl(string $urlData): void 
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

    private function validateStatus (string $statusData): void 
    {
        $this->errors['status'] = [];
        if (!isset($statusData) || !in_array($statusData, ['active','inactive'], true)) {
            $this->errors['status'][] = 'Поле статус должно быть active или inactive';
        }
        if (empty($this->errors['status'])) {
            unset($this->errors['status']);
        }
    }
}
