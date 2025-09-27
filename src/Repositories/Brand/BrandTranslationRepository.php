<?php

declare(strict_types=1);

namespace Vvintage\Repositories\Brand;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

use Vvintage\Repositories\AbstractRepository;

/** Контракты */
use Vvintage\Contracts\Brand\BrandTranslationRepositoryInterface;


final class BrandTranslationRepository extends AbstractRepository implements BrandTranslationRepositoryInterface
{
    private const TABLE = 'brandstranslation';
  

    public function createTranslationsBean(): OODBBean 
    {
      return $this->createBean(self::TABLE);
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

    public function getTranslationsArray(int $id, string $locale): array 
    {
   
      $translations = $this->loadTranslations($id);

      return $translations[$locale] ?? [
            'title' => '',
            'description' => '',
            'meta_title' => '',
            'meta_description' => ''
        ];

    }

    // public function findTranslations(int $id, string $locale): array
    // {
    //     $bean = $this->findOneBy(self::TABLE, 'brand_id = ? AND locale = ?', [$id, $locale]);
   
    //     if (!$bean) {
    //         return [];
    //     }

    //     return [
    //         'id' => $bean->id,
    //         'brand_id' => $bean->brand_id,
    //         'locale' => $bean->locale,
    //         'title' => $bean->title,
    //         'description' => $bean->description,
    //         'meta_title' => $bean->meta_title,
    //         'meta_description' => $bean->meta_description
    //     ];
    // }

 

   

    public function saveTranslations($brandId, $locale, $fields): void
    {
        $translationBean = $this->findOneBy(self::TABLE, 'brand_id = ? AND locale = ?', [$brandId, $locale]) 
                      ?? $this->createTranslationsBean();

        $translationBean->brand_id = $brandId;
        $translationBean->locale = $locale;
        $translationBean->title = $fields->title ?? null;
        $translationBean->description = $fields->description ?? null;
        $translationBean->meta_title = $fields->meta_title ?? null;
        $translationBean->meta_description = $fields->meta_description ?? null;

        $result = $this->saveBean($translationBean);

        if (!$result) {
          throw new RuntimeException("Не удалось сохранить перевод бренда");
        }
    }

  

     
}
