<?php
declare(strict_types=1);

namespace Vvintage\admin\Services\Validation;
use Vvintage\admin\Services\Validation\AdminBaseValidator;

final class AdminProductValidator extends AdminBaseValidator
{
  public array $errors = [];

  
    /**
     * Валидирует продукт и возвращает массив ошибок и данных
     * 
     * @param array $data - данные для валидации
     * 
     * @return array - массив ошибок и данных
     */
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


    /**
     * Проверка полей title и description для каждого языка
     *
     * @param array $data - данные для валидации
     *
     * @return array - массив ошибок и данных
     */
    private function textValidation (array $data): array
    {   
        // Проверка переводов
        $this->validateTranslation($data['translations']);
        foreach ($data['translations'] as $lang => $trans) {
            // title
            $title = trim($trans['title'] ?? '');
            $errors = [];
            if ($title === '') {
                $errors[] = "Поле названия для языка `{$lang}` не может быть пустым";
            } elseif (!is_string($title)) {
                $errors[]  = "Поле названия для языка `{$lang}`должно быть строкой";
            } elseif (ctype_digit($title)) {
                $errors[]  = "Название для языка `{$lang}` не может состоять только из цифр";
            } elseif (!preg_match('/^[\p{L}\d\s]+$/u', $title)) {
               $errors[]  = "Название для языка `{$lang}` может содержать только буквы, цифры и пробелы";
            }
            if (empty($errors)) {
                unset($errors);
            }

            // description
            $description = trim($trans['description'] ?? '');
            $errors = [];
            if ($description === '') {
              // $errors['description'][$lang] = 'Поле описания не может быть пустым';
            } elseif (!is_string($description)) {
                $errors[] = "Поле описания для языка `{$lang}` должно быть строкой";
            } elseif (preg_match('/^[\s.,!?()-]+$/u', $description)) {
                $errors[] = "Описание для языка `{$lang}` должно содержать буквы или цифры";
            } elseif (ctype_digit($description)) {
               $errors[] = "Описание для языка `{$lang}` не может состоять только из цифр";
            } elseif (mb_strlen($description) < 20) {
                $errors[] = "Описание для языка `{$lang}` должно быть не менее 20 символов";
            } elseif (mb_strlen($description) > 1000) {
               $errors[] = "Описание слишком для языка `{$lang}` длинное (максимум 1000 символов)";
            } elseif (!preg_match('/^[\p{L}\d\s.,!?()-]+$/u', $description)) {
               $errors[] = "Описание для языка `{$lang}` содержит недопустимые символы";
            }
            if (empty( $errors)) {
                unset( $errors);
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

   
    private function validatePrice(?string $priceData): void
    {
        $this->errors['price'] = [];
        if (!isset($priceData) || !is_numeric($priceData)) {
          $this->errors[] = 'Поле цены должно быть числом';
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
            $this->errors[] = 'Поле SKU обязательно для заполнения';
        } elseif (!is_string($sku)) {
            $this->errors[] = 'SKU должно быть строкой';
        }
        if (empty($this->errors['sku'])) {
            unset($this->errors['sku']);
        }

    }

    private function validateStock(?string $stockData): void 
    {
      $this->errors['stock'] = [];
      if (!isset($stockData) || !is_numeric($stockData)) {
          $this->errors[] = 'Поле stock должно быть числом';
      }
      if (empty($this->errors['stock'])) {
          unset($this->errors['stock']);
      }
    }

    private function validateCategory(?string $categoryData): void 
    {
      $this->errors['category_id'] = [];
      if (!isset($categoryData) || !is_numeric($categoryData)) {
          $this->errors[] = 'Выберите категорию товара';
      }
      if (empty($this->errors['category_id'])) {
          unset($this->errors['category_id']);
      }

    }


    private function validateBrand(?string $brandData): void 
    {
        $this->errors['brand_id'] = [];
        if (!isset($brandData) || !is_numeric($brandData)) {
            $this->errors[] = 'Выберите бренд товара';
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
            $this->errors[] = 'Поле URL невалидно';
        }
        if (empty($this->errors['url'])) {
            unset($this->errors['url']);
        }

    }

    private function validateStatus (?string $statusData): void 
    {
        $this->errors['status'] = [];
        if (!isset($statusData) || !in_array($statusData, ['active','hidden', 'archived'], true)) {
            $this->errors[] = 'Поле статус должно быть "Активный", "Невидимый" или "В архиве';
        }
        if (empty($this->errors['status'])) {
            unset($this->errors['status']);
        }
    }
}
