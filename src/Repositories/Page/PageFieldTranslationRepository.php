<?php
declare(strict_types=1);

namespace Vvintage\Repositories\Page;

use RedBeanPHP\R; // Подключаем readbean
use RedBeanPHP\OODBBean; // для обозначения типа даннных


/** Контракты */
// use Vvintage\Contracts\Page\PageRepositoryInterface;

/** Абстрактный репозиторий */
use Vvintage\Repositories\AbstractRepository;

/** Модели */
// use Vvintage\Models\Page\Page;


// final class PageTranslationRepository extends AbstractRepository implements PageRepositoryInterface
final class PageFieldTranslationRepository extends AbstractRepository 
{
    private const TABLE = 'pagefieldstranslation';

    public function loadTranslations(int $id): array
    {
        $sql = 'SELECT locale, title, description, meta_title, meta_description FROM ' . self::TABLE .' WHERE page_id = ?';
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
}