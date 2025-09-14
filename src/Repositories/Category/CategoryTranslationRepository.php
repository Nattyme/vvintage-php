<?php

declare(strict_types=1);

namespace Vvintage\Repositories\Category;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

use Vvintage\Repositories\AbstractRepository;


final class CategoryTranslationRepository extends AbstractRepository implements CategoryTranslationRepositoryInterface
{
    private const TABLE = 'categoriestranslation';
    private const DEFAULT_LOCALE = 'ru';
    private string $currentLocale;

    public function __construct(string $currentLocale = self::DEFAULT_LOCALE)
    {
        $this->currentLocale = $currentLocale;
    }

      
     /** Создаёт новый OODBBean для перевода продукта */
    public function createCategoryTranslateBean(): OODBBean 
    {
      return $this->createBean(self::TABLE);
    }

    public function loadTranslations(int $categoryId): array
    {
        $sql = 'SELECT locale, title, description, meta_title, meta_description FROM ' . self::TABLE .' WHERE category_id = ?';
        $rows = $this->getAll($sql, [$categoryId]);

        $translations = [];
        foreach ($rows as $row) {
            $translations[$row['locale']] = [
                'title' => $row['title'],
                'description' => $row['description'],
                'meta_title' => $row['meta_title'],
                'meta_description' => $row['meta_description'],
            ];
        }

        return $translations;
    }

    public function saveProductTranslation(array $translateDto): ?array
    {
        $ids = [];

        foreach ($translateDto as $dto) {
            if (!$dto) {
                return null;
            }

            // ищем существующий перевод
            $bean = $this->findOneBy(self::TABLE, ' product_id = ? AND locale = ? ', [$dto->product_id, $dto->locale]);

            if (!$bean) {
                // если нет → создаём новый
                $bean = $this->createProductTranslateBean();
                $bean->product_id = $dto->product_id;
                $bean->locale = $dto->locale;
            }

            // обновляем данные
            $bean->slug = $dto->slug;
            $bean->title = $dto->title;
            $bean->description = $dto->description;
            $bean->meta_title = $dto->meta_title;
            $bean->meta_description = $dto->meta_description;

            $this->saveBean($bean);

            $ids[] = (int) $bean->id;
        }

        return $ids;
    }

    public function getTranslationsArray($id): array 
    {
      $translations = $this->loadTranslations($id);

      return $translations[$this->currentLang] ?? $translations[self::DEFAULT_LANG] ?? [
            'title' => '',
            'description' => '',
            'meta_title' => '',
            'meta_description' => ''
        ];

    }

    public function findTranslations(int $id, string $locale) 
    {
      return  $this->findOneBy(
                  self::TABLE,
                  'category_id = ? AND locale = ?',
                  [$id, $locale]
              );
    }

    public function createTranslation(int $id, string $locale): void 
    {
      $transBean = $this->createBean(self::TABLE);
      $transBean->category_id = $id;
      $transBean->locale = $locale;
    }

    public function updateTranslations( OODBBean $transBean, array $translation): void 
    {
      // Обновляем только те поля, что реально пришли
      if (array_key_exists('title', $translation)) {
          $transBean->title = $translation['title'];
      }
      if (array_key_exists('description', $translation)) {
          $transBean->description = $translation['description'];
      }
      if (array_key_exists('meta_title', $translation)) {
          $transBean->meta_title = $translation['meta_title'];
      }
      if (array_key_exists('meta_description', $translation)) {
          $transBean->meta_description = $translation['meta_description'];
      }

      $this->saveBean($transBean);

    }
    

 


    
}
