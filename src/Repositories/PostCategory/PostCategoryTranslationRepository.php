<?php
declare(strict_types=1);

namespace Vvintage\Repositories\PostCategory;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

/** Контракты */
// use Vvintage\Contracts\Post\PostTranslationRepositoryInterface;
use Vvintage\DTO\Admin\Post\PostCategoryTranslationInputDTO;

/** Абстрактный репозиторий */
use Vvintage\Repositories\AbstractRepository;



// final class PostCategoryTranslationRepository extends AbstractRepository implements PostCategoryRepositoryInterface
final class PostCategoryTranslationRepository extends AbstractRepository 
{
    private const TABLE = 'postscategoriestranslation';

    /** Создаёт новый OODBBean для перевода продукта */
    public function createPostCategoryTranslateBean(): OODBBean 
    {
      return $this->createBean(self::TABLE);
    }

    public function createTranslateInputDto(array $data, int $categoryId): array
    {
      $postCategoryTranslationsDto = [];
  
      foreach($data as $locale => $translate) {
          $postCategoryTranslationsDto[] = new PostCategoryTranslationInputDTO([
              'category_id' => (int) $categoryId,
              'slug' => (string) ($translate['slug'] ?? ''),
              'locale' => (string) $locale, 
              'title' => (string) ($translate['title'] ?? ''),
              'description' => (string) ($translate['description'] ?? ''),
              'meta_title' => (string) ($translate['meta_title'] ?? $translate['title'] ?? ''),
              'meta_description' => (string) ($translate['meta_description'] ?? $translate['description'] ?? '')
          ]);
      }
         
      return  $postCategoryTranslationsDto;

    }

    public function loadTranslations(int $categoryId): array
    {
        $sql = 'SELECT *
                FROM ' . self::TABLE .' 
                WHERE category_id = ?';
        $rows = $this->getAll($sql, [$categoryId]);


        $translations = [];
        foreach ($rows as $row) {
            $translations[$row['locale']] = [
                'title' => $row['title'] ?? '',
                'description' => $row['description'] ?? '',
                'meta_title' => $row['meta_title'] ?? '',
                'meta_description' => $row['meta_description'] ?? '',
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

    public function savePostTranslation(array $translateDto): ?array
    {
        $ids = [];

        foreach ($translateDto as $dto) {
            // if (!$dto) {
            //     return null;
            // }
            if (!$dto) {
              throw new \RuntimeException("Не удалось обновить переводы категории статьи");
            }


            // ищем существующий перевод
            $bean = $this->findOneBy(self::TABLE, ' category_id = ? AND locale = ? ', [$dto->category_id, $dto->locale]);

            if (!$bean) {
                // если нет → создаём новый
                $bean = $this->createPostTranslateBean();
                $bean->category_id = $dto->category_id;
                $bean->locale = $dto->locale;
            }

            // обновляем данные
            $bean->slug = $dto->slug;
            $bean->title = $dto->title;
            $bean->description = $dto->description;
            $bean->meta_title = $dto->meta_title;
            $bean->meta_description = $dto->meta_description;

            $result = $this->saveBean($bean);

            if (!$result) {
              throw new \RuntimeException("Не удалось обновить переводы категории статьи");
            }

            $ids[] = (int) $bean->id;
        }

        return $ids;
    }


}