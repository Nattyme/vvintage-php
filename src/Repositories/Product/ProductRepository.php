<?php

declare(strict_types=1);

namespace Vvintage\Repositories\Product;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;
use RuntimeException;

/** Контракты */
use Vvintage\Contracts\Product\ProductRepositoryInterface;
use Vvintage\Repositories\AbstractRepository;

/** Модели */
use Vvintage\Models\Product\Product;
use Vvintage\Models\Category\Category;
use Vvintage\Models\Brand\Brand;

/** DTO */
use Vvintage\DTO\Product\ProductDTO;
use Vvintage\DTO\Product\ProductInputDTO;
use Vvintage\DTO\Product\ProductImageDTO;
use Vvintage\DTO\Product\ProductImageInputDTO;
use Vvintage\DTO\Category\CategoryDTO;
use Vvintage\DTO\Category\CategoryOutputDTO;
use Vvintage\DTO\Brand\BrandDTO;
use Vvintage\DTO\Product\ProductFilterDTO;
use Vvintage\DTO\Product\ProductTranslationInputDTO;
use Vvintage\Services\Admin\Product\AdminProductImageService;

final class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{
    private const TABLE_PRODUCTS = 'products';
    private const TABLE_PRODUCTS_TRANSLATION = 'productstranslation';
    private const TABLE_PRODUCT_IMAGES = 'productimages';

    private const TABLE_BRANDS = 'brands';
    private const TABLE_BRANDS_TRANSLATION = 'brandstranslation';

    private const TABLE_CATEGORIES = 'categories';
    private const TABLE_CATEGORIES_TRANSLATION = 'categoriestranslation';

    private const DEFAULT_LOCALE = 'ru';
    private string $currentLocale;

    public function __construct(string $currentLocale = self::DEFAULT_LOCALE)
    {
        $this->currentLocale = $currentLocale;
    }

    /** Создаёт новый OODBBean для продукта */
    private function createProductBean(): OODBBean 
    {
        return $this->createBean(self::TABLE_PRODUCTS);
    }

     /** Создаёт новый OODBBean для перевода продукта */
    private function createProductTranslateBean(): OODBBean 
    {
        return $this->createBean(self::TABLE_PRODUCTS_TRANSLATION);
    }

    /** Создаёт новый OODBBean для изображения продукта */
    private function createProductImageBean(): OODBBean 
    {
        return $this->createBean(self::TABLE_PRODUCT_IMAGES);
    }

    /** create DTO */
    private function createTranslateInputDto(array $data, int $productId): array
    {
      $productTranslationsDto = [];
  
      foreach($data as $locale => $translate) {
          $productTranslationsDto[] = new ProductTranslationInputDTO([
              'product_id' => (int) $productId,
              'slug' => (string) ($data['slug'] ?? ''),
              'locale' => (string) $locale, 
              'title' => (string) ($translate['title'] ?? ''),
              'description' => (string) ($translate['description'] ?? ''),
              'meta_title' => (string) ($translate['meta_title'] ?? $translate['title'] ?? ''),
              'meta_description' => (string) ($translate['meta_description'] ?? $translate['description'] ?? '')
          ]);
      }
         
      return  $productTranslationsDto;

    }

    private function createImagesInputDto (array $images, array $finalImages, int $productId): array
    {
      $imagesDto = [];

      $count = min(count($images), count($finalImages)); // чтобы не выйти за пределы массивов

        for ($i = 0; $i < $count; $i++) {
            $image = $images[$i];
            $finalImage = $finalImages[$i];

            $imagesDto[] = new ProductImageInputDTO([
                'product_id' => (int) $productId,
                'cover' => (string) ($finalImage['cover'] ?? ''),
                'image_order' => (int) ($image['image_order'] ?? 1),
                'alt' => $image['alt'] ?? ''
            ]);
        }

      return $imagesDto;
    }

    // private function createCategoryDTOFromArray(array $row): CategoryDTO
    // {
    //     $locale = $this->currentLocale ?? self::DEFAULT_LOCALE;
    //     return new CategoryDTO([
    //         'id' => (int) $row['category_id'],
    //         'title' => (string) ($row['category_title_translation'] ?: $row['category_title']),
    //         'parent_id' => (int) ($row['category_parent_id'] ?? 0),
    //         'image' => (string) ($row['category_image'] ?? ''),
    //         'translations' => [
    //             $locale => [
    //                 'title' => $row['category_title_translation'] ?? '',
    //                 'description' => $row['category_description'] ?? '',
    //                 'seo_title' => $row['category_meta_title'] ?? '',
    //                 'seo_description' => $row['category_meta_description'] ?? '',
    //             ]
    //         ],
    //         'locale' => $locale,
    //     ]);
    // }

    private function createCategoryOutputDTO (array $row): CategoryOutputDTO
    {
        $locale = $this->currentLocale ?? self::DEFAULT_LOCALE;
        return new CategoryOutputDTO([
            'id' => (int) $row['category_id'],
            'title' => (string) ($row['category_title_translation'] ?: $row['category_title']),
            'parent_id' => (int) ($row['category_parent_id'] ?? 0),
            'image' => (string) ($row['category_image'] ?? ''),
            'translations' => [
                $locale => [
                    'title' => $row['category_title_translation'] ?? '',
                    'description' => $row['category_description'] ?? '',
                    'seo_title' => $row['category_meta_title'] ?? '',
                    'seo_description' => $row['category_meta_description'] ?? '',
                ]
            ],
            'locale' => $locale,
        ]);
    }

    private function createBrandDTOFromArray(array $row): BrandDTO
    {
        $locale = $this->currentLocale ?? self::DEFAULT_LOCALE;
        return new BrandDTO([
            'id' => (int) $row['brand_id'],
            'title' => (string) ($row['brand_title_translation'] ?: $row['brand_title']),
            'image' => (string) ($row['brand_image'] ?? ''),
            'translations' => [
                $locale => [
                    'title' => $row['brand_title_translation'] ?? '',
                    'description' => $row['brand_description'] ?? '',
                    'seo_title' => $row['brand_meta_title'] ?? '',
                    'seo_description' => $row['brand_meta_description'] ?? '',
                ]
            ],
            'locale' => $locale,
        ]);
    }


    /***** GET ****/
    public function getProductById(int $id): ?Product
    {
        $rows = $this->uniteProductRawData(['productId' => $id]);
        return $rows ? $this->fetchProductWithJoins($rows[0]) : null;
    }

    public function getProductsByParam(string $sql ='', array $params = []): array
    {
        // Получаем все продукты по условию
        $rows = $this->findAll(self::TABLE_PRODUCTS, $sql, $params);
        if(!$rows) return [];
 
        $fetchedProducts = $this->uniteProductRawData($rows);
        // Применяем fetchProductWithJoins к каждому объекту OODBBean
        $products = array_map([$this, 'fetchProductWithJoins'], $fetchedProducts);

        return $products;
    }

    
    public function getAllProducts(array $data = []): array
    {
     
        $rows = $this->uniteProductRawData($data);
        return array_map([$this, 'fetchProductWithJoins'], $rows);
    }

    public function getProductsByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }
        $rows = $this->uniteProductRawData(['productIds' => $ids]);
        return array_map([$this, 'fetchProductWithJoins'], $rows);
    }

    public function getAllProductsCount(?string $sql = null, array $params = []): int
    {
        return $this->countAll(self::TABLE_PRODUCTS, $sql, $params);
    }

    public function getLastProducts(int $count): array
    {
        $rows = $this->uniteProductRawData(['limit' => $count]);
        return array_map([$this, 'fetchProductWithJoins'], $rows);
    }

    public function getFilteredProducts(ProductFilterDTO $filterDto): array
    {
        $conditions = [];
        $params = [];

        // статус первым
        $conditions[] = "status = ?";
        $params[] = 'active';

        // фильтрация по брендам
        if (!empty($filterDto->brands)) {
            $placeholders = implode(',', array_fill(0, count($filterDto->brands), '?'));
            $conditions[] = "brand_id IN ($placeholders)";
            $params = array_merge($params, $filterDto->brands);
        }

        // фильтрация по категориям
        if (!empty($filterDto->categories)) {
            $placeholders = implode(',', array_fill(0, count($filterDto->categories), '?'));
            $conditions[] = "category_id IN ($placeholders)";
            $params = array_merge($params, $filterDto->categories);
        }

        // фильтрация по цене
        if ($filterDto->priceMin !== null) {
            $conditions[] = "price >= ?";
            $params[] = $filterDto->priceMin;
        }
        if ($filterDto->priceMax !== null) {
            $conditions[] = "price <= ?";
            $params[] = $filterDto->priceMax;
        }


        // сортировка
        $orderBy = "id DESC"; // дефолт
        switch ($filterDto->sort) {
            case 'price_asc':
                $orderBy = "price ASC";
                break;
            case 'price_desc':
                $orderBy = "price DESC";
                break;
        }

        // // базовый запрос
        // $sql = "status = ?";
        // $params[] = 'active';
        // объединяем условия

        if ($conditions) {
            $sql = implode(" AND ", $conditions);
        }

        // финальный запрос
        $beans = $this->findAll('products', $sql . " ORDER BY " . $orderBy, $params);

        if(!$beans) {
          return [];
        }

        $rows = $this->uniteProductRawData(['limit' => $beans]);

        return array_map([$this, 'fetchProductWithJoins'], $rows);
    }


    private function fetchProductWithJoins(array $row): Product
    {

        $productId = (int) $row['id'];
        $translations = $this->loadTranslations($productId);
        $categoryDTO = $this->createCategoryOutputDTO($row);
        $brandDTO = $this->createBrandDTOFromArray($row);
        $imagesDTO = $this->fetchImageDTOs($row);

        $dto = new ProductDTO([
            'id' => $productId,
            'categoryDTO' => $categoryDTO,
            'brandDTO' => $brandDTO,
            'slug' => (string) $row['slug'],
            'title' => (string) $row['title'],
            'description' => (string) $row['description'],
            'price' => (string) $row['price'],
            'url' => (string) $row['url'],
            'status' => (string) $row['status'],
            'sku' => (string) $row['sku'],
            'stock' => (int) $row['stock'],
            'datetime' => (string) $row['datetime'],
            'edit_time' => (string) $row['edit_time'],
            'images_total' => count($imagesDTO),
            'translations' => $translations,
            'locale' => $this->currentLocale ?? self::DEFAULT_LOCALE,
            'images' => $imagesDTO,
        ]);
        return Product::fromDTO($dto);
    }

    private function fetchImageDTOs(array $row): array
    {
        $imagesRows = R::getAll(
            'SELECT id, product_id, filename, image_order 
             FROM ' . self::TABLE_PRODUCT_IMAGES . '
             WHERE product_id = ? 
             ORDER BY image_order',
            [$row['id']]
        );
        return array_map(fn($imageRow) => new ProductImageDTO($imageRow), $imagesRows);
    }



    private function uniteProductRawData(array $data): array
    {
        $locale = $this->currentLocale ?? self::DEFAULT_LOCALE;

        $sql = '
            SELECT 
                p.*,
                pt.locale,
                COALESCE(pt.title, p.title) AS title,
                COALESCE(pt.description, p.description) AS description,
                pt.meta_title,
                pt.meta_description,
                c.id AS category_id,
                c.title AS category_title,
                c.parent_id AS category_parent_id,
                c.image AS category_image,
                ct.title AS category_title_translation,
                ct.description AS category_description,
                ct.meta_title AS category_meta_title,
                ct.meta_description AS category_meta_description,
                b.id AS brand_id,
                b.title AS brand_title,
                b.image AS brand_image,
                bt.title AS brand_title_translation,
                bt.description AS brand_description,
                bt.meta_title AS brand_meta_title,
                bt.meta_description AS brand_meta_description,
                GROUP_CONCAT(DISTINCT pi.filename ORDER BY pi.image_order) AS images
            FROM ' . self::TABLE_PRODUCTS .' p
            LEFT JOIN ' . self::TABLE_PRODUCTS_TRANSLATION .' pt 
                ON pt.product_id = p.id AND pt.locale = ?
            LEFT JOIN ' . self::TABLE_PRODUCT_IMAGES .' pi 
                ON pi.product_id = p.id
            LEFT JOIN ' . self::TABLE_CATEGORIES .' c 
                ON p.category_id = c.id
            LEFT JOIN ' . self::TABLE_CATEGORIES_TRANSLATION . ' ct 
                ON ct.category_id = c.id AND ct.locale = ?
            LEFT JOIN ' . self::TABLE_BRANDS . ' b 
                ON p.brand_id = b.id
            LEFT JOIN ' . self::TABLE_BRANDS_TRANSLATION . ' bt 
                ON bt.brand_id = b.id AND bt.locale = ?
        ';

        $bindings = [$locale, $locale, $locale];

        // фильтры
        if (!empty($data['productId'])) {
            $sql .= ' WHERE p.id = ?';
            $bindings[] = $data['productId'];
        } elseif (!empty($data['productIds']) && is_array($data['productIds'])) {
            $placeholders = implode(',', array_fill(0, count($data['productIds']), '?'));
            $sql .= " WHERE p.id IN ($placeholders)";
            $bindings = array_merge($bindings, $data['productIds']);
        } elseif (!empty($data['customWhere'])) {
            // кастомное WHERE
            $sql .= ' WHERE ' . $data['customWhere'];
            if (!empty($data['params'])) {
                $bindings = array_merge($bindings, $data['params']);
            }
        }

        $sql .= ' GROUP BY p.id';

        // сортировка уже может быть в customWhere, но оставим safeguard
        if (!empty($data['order'])) {
            $sql .= ' ' . $data['order'];
        } else {
            $sql .= ' ORDER BY p.id DESC';
        }

        if (isset($data['limit'])) {
            if (is_numeric($data['limit']) && (int)$data['limit'] > 0) {
                $sql .= ' LIMIT ' . (int)$data['limit'];
            } elseif (is_string($data['limit'])) {
                $sql .= ' ' . $data['limit'];
            }
        }

        return R::getAll($sql, $bindings);
    }

    public function updateStatus(int $productId, string $status): bool
    {
        return $this->updatePartial($productId, ['status' => $status], ['id' => $productId]);
    }

    private function updatePartial(int $id, array $data): bool
    {     
      
        $productBean = $this->loadBean(self::TABLE_PRODUCTS, $id);
     
        if (!$productBean->id) {
            throw new RuntimeException("Product with ID {$id} not found");
        }
        foreach ($data as $field => $value) {
            $productBean->{$field} = $value;
        }
  

        return !!$this->saveBean($productBean);
      
        // return $productBean->export();
    }

    // public function updateFull(ProductDTO $dto): ?array
    // {
    //     return $this->updatePartial($dto->getId(), $dto->toArray());
    // }

    /** Обновляет существующий продукт через DTO */
  public function updateProductData(int $productId, ProductInputDTO $dto, array $translations = []): bool
  {
      $bean = $this->loadBean(self::TABLE_PRODUCTS, $productId);

      if (!$bean->id) {
          throw new RuntimeException("Product with ID {$productId} not found");
      }

      $bean->category_id = $dto->category_id;
      $bean->brand_id = $dto->brand_id;
      $bean->slug = $dto->slug;
      $bean->title = $dto->title;
      $bean->description = $dto->description;
      $bean->price = $dto->price;
      $bean->url = $dto->url;
      $bean->sku = $dto->sku;
      $bean->stock = $dto->stock;
      $bean->status = $dto->status;
      $bean->edit_time = $dto->edit_time;

      $this->saveBean($bean);

      // если пришли новые переводы → пересохраняем
      if (!empty($translations)) {
          $translateDto = $this->createTranslateInputDto($translations, $productId);
          $this->saveProductTranslation($translateDto);
      }

      return true;
  }




    public function deleteExtraImagesExceptMain(int $productId): void
    {
        $mainExists = R::getCell(
            'SELECT COUNT(*) FROM ' . self::TABLE_PRODUCT_IMAGES . ' 
             WHERE product_id = ? AND is_main = 1',
            [$productId]
        );
        if ($mainExists) {
            R::exec(
                'DELETE FROM ' . self::TABLE_PRODUCT_IMAGES . ' 
                 WHERE product_id = ? 
                   AND id NOT IN (
                       SELECT id FROM ' . self::TABLE_PRODUCT_IMAGES . ' 
                       WHERE product_id = ? AND is_main = 1
                   )',
                [$productId, $productId]
            );
        }
    }

    private function loadTranslations(int $productId): array
    {
        $rows = R::getAll(
            'SELECT locale, title, description, meta_title, meta_description 
             FROM ' . self::TABLE_PRODUCTS_TRANSLATION .' 
             WHERE product_id = ?',
            [$productId]
        );

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


    public function bulkUpdate(array $ids, array $data): void
    {
        foreach ($ids as $id) {
            $this->updatePartial((int)$id, $data);
        }
    }

    

    /** SAVE */
    /** Создаёт новый продукт через DTO */
    public function saveProduct(ProductInputDTO $dto, array $translations, array $images, array  $processedImages): ?int
    {
        if (!$dto) {
            return null;
        }
     
        // Транзакция сохранения продукта
        try {
          
          // Открывает транзакцию 
          $this->begin();

          // 1. сохраняем продукт
          // 2. сохраняем переводы
          // 3. сохраняем изображения

          // Создаем или загружаем продукт
          $bean = $dto->id 
              ? $this->findById(self::TABLE_PRODUCTS, $dto->id)
              : $this->createProductBean();

          $bean->category_id = $dto->category_id;
          $bean->brand_id = $dto->brand_id;
          $bean->slug = $dto->slug;
          $bean->title = $dto->title;
          $bean->description = $dto->description;
          $bean->price = $dto->price;
          $bean->url = $dto->url;
          $bean->sku = $dto->sku;
          $bean->stock = $dto->stock;
          $bean->datetime = $dto->datetime;
          $bean->status = $dto->status;
          $bean->edit_time = $dto->edit_time;

          $this->saveBean($bean);

          // ID продукта
          $productId = (int)$bean->id;

          if (!$productId) {
            throw new RuntimeException("Не удалось сохранить продукт");
          }
   
          // Создаем DTO для переводов и сохраняем в БД
          $translateDto = $this->createTranslateInputDto($translations, $productId);
          $translateIds = $this->saveProductTranslation($translateDto);

          $imageService = new AdminProductImageService();
          // 3. Финализируем файлы после проверки
          $finalImages = $imageService->finalizeImages($processedImages);
          // Создаём DTO для изображений 
          $imagesDto = $this->createImagesInputDto($images, $finalImages, $productId);
          

          // 2. Проверяем что все filename есть
          foreach ($imagesDto as $dto) {
              if (!$dto->filename) {
                  throw new RuntimeException("Пустое имя файла для изображения");
              }
          }

         
          $imagesIds = $this->saveProductImages($imagesDto);

 
          if (!$productId || !$translateIds || !$imagesIds) {
              throw new RuntimeException("Не удалось сохранить продукт");
          }

          $this->commit();
          return $productId;

        
      }
      catch (\Throwable $e) {
        $this->rollback(); // откатываем изменения

         // удаляем все возможные файлы
        $imageService->cleanup($processedImages);
        if (!empty($finalImages)) {
            $imageService->cleanupFinal($finalImages);
        }

        // $imageService->cleanup($processedImages);
        throw $e;      // пробрасываем ошибку выше
      }
  
    }

    public function saveProductTranslation(array $translateDto): ?array
    {
      foreach( $translateDto as $dto) {
        if (!$dto) {
            return null;
        }
      }

      $ids = [];

      foreach($translateDto as $dto) {
          // Создаем или загружаем перевод
          $bean = $this->createProductTranslateBean();

          $bean->product_id = $dto->product_id;
          $bean->slug = $dto->slug;
          $bean->locale = $dto->locale;
          $bean->title = $dto->title;
          $bean->description = $dto->description;
          $bean->meta_title = $dto->meta_title;
          $bean->meta_description = $dto->meta_description;

          $this->saveBean($bean);
          
          $id = (int) $bean->id;

          if (!$id) {
            return null;
          }

          $ids[] = $id;
      }

      return $ids;
    }

    public function saveProductImages(array $imagesDto): ?array
    {
      foreach( $imagesDto as $dto) {
        if (!$dto) {
            return null;
        }
      }

      $ids = [];

      foreach($imagesDto as $dto) {
          // Создаем или загружаем изображения 
          $bean = $this->createProductImageBean();

          $bean->product_id = $dto->product_id;
          $bean->filename = $dto->filename;
          $bean->image_order = $dto->image_order;
          $bean->alt = $dto->alt;
          

          $this->saveBean($bean);
          
          $id = (int) $bean->id;

          if (!$id) {
            return null;
          }

          $ids[] = $id;
      }

      return $ids;
    }

    /**
     * Добавляет новые изображения для продукта
     * 
     * @param int $productId
     * @param ProductImageInputDTO[] $imagesDto
     * @return array|null  Массив ID добавленных изображений или null при ошибке
    */
    public function addProductImages(int $productId, array $imagesDto): ?array
    {
        if (empty($imagesDto)) {
            return [];
        }

        $ids = [];

        foreach ($imagesDto as $dto) {
            if (!$dto) {
                return null;
            }

            $bean = $this->createProductImageBean();

            $bean->product_id = $productId;
            $bean->filename = $dto->filename;
            $bean->image_order = $dto->image_order;
            $bean->alt = $dto->alt;

            $this->saveBean($bean);

            $id = (int) $bean->id;
            if (!$id) {
                return null;
            }

            $ids[] = $id;
        }

        return $ids;
    }

}
