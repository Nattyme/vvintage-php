<?php

declare(strict_types=1);

namespace Vvintage\Repositories\Product;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

use Vvintage\Contracts\Product\ProductTranslationRepositoryInterface;
use Vvintage\DTO\Product\ProductTranslationInputDTO;
use Vvintage\Repositories\AbstractRepository;


final class ProductTranslationRepository extends AbstractRepository implements ProductTranslationRepositoryInterface
{
    private const TABLE = 'productstranslation';
    private const DEFAULT_LOCALE = 'ru';
    private string $currentLocale;

    public function __construct(string $currentLocale = self::DEFAULT_LOCALE)
    {
        $this->currentLocale = $currentLocale;
    }

    
     /** Создаёт новый OODBBean для перевода продукта */
    public function createProductTranslateBean(): OODBBean 
    {
      return $this->createBean(self::TABLE);
    }

    public function createTranslateInputDto(array $data, int $productId): array
    {
      $productTranslationsDto = [];
  
      foreach($data as $locale => $translate) {
          $productTranslationsDto[] = new ProductTranslationInputDTO([
              'product_id' => (int) $productId,
              'slug' => (string) ($translate['slug'] ?? ''),
              'locale' => (string) $locale, 
              'title' => (string) ($translate['title'] ?? ''),
              'description' => (string) ($translate['description'] ?? ''),
              'meta_title' => (string) ($translate['meta_title'] ?? $translate['title'] ?? ''),
              'meta_description' => (string) ($translate['meta_description'] ?? $translate['description'] ?? '')
          ]);
      }
         
      return  $productTranslationsDto;

    }

    public function loadTranslations(int $productId): array
    {
        $sql = 'SELECT *
                FROM ' . self::TABLE .' 
                WHERE product_id = ?';
        $rows = $this->getAll($sql, [$productId]);


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

    public function saveProductTranslation(array $translateDto): ?array
    {
        $ids = [];

        foreach ($translateDto as $dto) {
            if (!$dto) {
                return null;
            }

            // ищем существующий перевод
            $bean = $this->findOneBy(self::TABLE_PRODUCTS_TRANSLATION, ' product_id = ? AND locale = ? ', [$dto->product_id, $dto->locale]);

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

}
