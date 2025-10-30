<?php

declare(strict_types=1);

namespace Vvintage\Repositories\Brand;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

use Vvintage\Repositories\AbstractRepository;

/** Контракты */
use Vvintage\Contracts\Brand\BrandTranslationRepositoryInterface;


// final class BrandTranslationRepository extends AbstractRepository implements BrandTranslationRepositoryInterface
final class BrandTranslationRepository extends AbstractRepository 
{
    private const TABLE = 'brandstranslation';
  

    public function createTranslationsBean(): OODBBean 
    {
      return $this->createBean(self::TABLE);
    }

    public function saveBrandTranslation(array $translations): array
    {
        $ids = [];

        foreach ($translations as $translate) {
          // ищем существующий перевод
          $bean = $this->findOneBy(self::TABLE, ' brand_id = ? AND locale = ? ', [ $translate['brand_id'], $translate['locale'] ]);

          if (!$bean) {
              // если нет → создаём новый
              $bean = $this->createTranslationsBean();
              $bean->brand_id = $translate['brand_id'];
              $bean->locale = $translate['locale'];
          }

          // обновляем данные
          $bean->title = $translate['title'];
          $bean->description = $translate['description'];
          $bean->meta_title = $translate['meta_title'];
          $bean->meta_description = $translate['meta_description'];

          $result = $this->saveBean($bean);

          if (!$result) throw new \RuntimeException("Не удалось сохранить перевод бренда");

          $ids[] = (int) $bean->id;
        }

        return $ids;
    }

    public function loadTranslations(int $id): array
    {
        $sql = 'SELECT locale, title, description, meta_title, meta_description FROM ' . self::TABLE .' WHERE brand_id = ?';
        $rows = $this->getAll($sql, [$id]);

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

   
   

  

  

     
}
