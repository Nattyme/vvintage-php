<?php

declare(strict_types=1);

namespace Vvintage\Repositories\Category;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

use Vvintage\Repositories\AbstractRepository;
/** Контракты */
use Vvintage\Contracts\Category\CategoryTranslationRepositoryInterface;


// final class CategoryTranslationRepository extends AbstractRepository implements CategoryTranslationRepositoryInterface
final class CategoryTranslationRepository extends AbstractRepository 
{
    private const TABLE = 'categoriestranslation';
  
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

    public function saveCategoryTranslation(array $translations): ?array
    {
        $ids = [];

        foreach ($translations as $translate) {
            // ищем существующий перевод
            $bean = $this->findOneBy(self::TABLE, ' category_id = ? AND locale = ? ', [ $translate['category_id'], $translate['locale'] ]);

            if (!$bean) {
                // если нет → создаём новый
                $bean = $this->createCategoryTranslateBean();
                $bean->category_id = $translate['category_id'];
                $bean->locale = $translate['locale'];
            }

            // обновляем данные
            $bean->slug = $translate['slug'];
            $bean->title = $translate['title'];
            $bean->description = $translate['description'];
            $bean->meta_title = $translate['meta_title'];
            $bean->meta_description = $translate['meta_description'];

            $result = $this->saveBean($bean);

            if (!$result) throw new \RuntimeException("Не удалось сохранить перевод категории");

            $ids[] = (int) $bean->id;
        }

        return $ids;
    }
    
    // Для api
    public function getLocaleTranslation(int $id, string $locale): array 
    {

      $translations = $this->loadTranslations($id);

      return $translations[$locale] ?? [
            'title' => '',
            'description' => '',
            'meta_title' => '',
            'meta_description' => ''
        ];

    }
    // Для api


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
