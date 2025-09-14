<?php

declare(strict_types=1);

namespace Vvintage\Repositories\Brand;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

use Vvintage\Repositories\AbstractRepository;


final class BrandTranslationRepository extends AbstractRepository implements BrandTranslationRepositoryInterface
{
    private const TABLE = 'brandstranslation';
    // private const DEFAULT_LOCALE = 'ru';
    // private string $defaultLocale;
    // private string $currentLocale;

    // public function __construct(string $currentLocale = self::DEFAULT_LOCALE)
    // public function __construct()
    // {
    //     $this->currentLocale = $currentLocale;
    // }

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

    public function findTranslations(int $id, string $locale) 
    {
        return  $this->findOneBy(
                  self::TABLE,
                  'brand_id = ? AND locale = ?',
                  [$id, $locale]
              );
    }

    public function saveTranslations($brandId, $locale, $fields): void
    {
        $translationBean = $this->findTranslations($brandId, $locale) ?? $this->createTranslationsBean();

        $translationBean->brand_id = $brandId;
        $translationBean->locale = $locale;
        $translationBean->title = $fields['title'] ?? '';
        $translationBean->description = $fields['description'] ?? '';
        $translationBean->meta_title = $fields['meta_title'] ?? '';
        $translationBean->meta_description = $fields['meta_description'] ?? '';

        $this->saveBean($translationBean);
    }

  

     
}
