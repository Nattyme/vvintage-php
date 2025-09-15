<?php

declare(strict_types=1);

namespace Vvintage\Repositories\Product;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;
use RuntimeException;

/** Контракты */
use Vvintage\Contracts\Product\ProductRepositoryInterface;
use Vvintage\Repositories\AbstractRepository;
use Vvintage\Repositories\Product\ProductImageRepository;

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
// use Vvintage\DTO\Product\ProductTranslationInputDTO;
use Vvintage\Services\Admin\Product\AdminProductImageService;

final class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{
    private const TABLE = 'products';
    private const TABLE_PRODUCTS_TRANSLATION = 'productstranslation';
    private const TABLE_PRODUCT_IMAGES = 'productimages';

    private const TABLE_BRANDS = 'brands';
    private const TABLE_BRANDS_TRANSLATION = 'brandstranslation';

    private const TABLE_CATEGORIES = 'categories';
    private const TABLE_CATEGORIES_TRANSLATION = 'categoriestranslation';

    private ProductImageRepository $imageRepo;

    // public function __construct(string $currentLocale = self::DEFAULT_LOCALE)
    public function __construct()
    {
        $this->imageRepo = new ProductImageRepository();
    }

    /**
      ********** ::: CREATE ::: **********
    */


    /************ CRETE BEAN ********/
    /** Создаёт новый OODBBean для продукта */
    private function createProductBean(): OODBBean 
    {
        return $this->createBean(self::TABLE_PRODUCTS);
    }

  

    /**
      ********** ::: GET ::: **********
    */
    public function getProductById(int $id): ?Product
    {
        return $this->getProducts(['id' => $id]);
        // return $rows ? $this->fetchProductWithJoins($rows[0]) : null;
    }

    public function getProductsByParam(string $sql ='', array $params = []): array
    {
        // напрямую получаем продукты через getAll
        return $this->getAll("{$sql}", $params);
    }

    
    public function getAllProducts(array $filters = []): array
    {
     
        return $this->getProducts($filters);
        // return array_map([$this, 'fetchProductWithJoins'], $rows);
    }


    public function getAllProductsCount(?string $sql = null, array $params = []): int
    {
        return $this->countAll(self::TABLE, $sql, $params);
    }

    public function getLastProducts(int $count): array
    {
        return $this->getProducts(['limit' => $count]);
        // return $this->uniteProductRawData(['limit' => $count]);
        // return array_map([$this, 'fetchProductWithJoins'], $rows);
    }

    

    /**
      ********** ::: // GET ::: **********
    */




    /**
      ********** ::: UPDATE ::: **********
    */
    // private function uniteProductRawData(array $data): array
    // {
    //     // $locale = $this->currentLocale ?? self::DEFAULT_LOCALE;

    //     $sql = '
    //         SELECT 
    //             p.*,
    //             pt.locale,
    //             COALESCE(pt.title, p.title) AS title,
    //             COALESCE(pt.description, p.description) AS description,
    //             pt.meta_title,
    //             pt.meta_description,
    //             c.id AS category_id,
    //             c.title AS category_title,
    //             c.parent_id AS category_parent_id,
    //             c.image AS category_image,
    //             ct.title AS category_title_translation,
    //             ct.description AS category_description,
    //             ct.meta_title AS category_meta_title,
    //             ct.meta_description AS category_meta_description,
    //             b.id AS brand_id,
    //             b.title AS brand_title,
    //             b.image AS brand_image,
    //             bt.title AS brand_title_translation,
    //             bt.description AS brand_description,
    //             bt.meta_title AS brand_meta_title,
    //             bt.meta_description AS brand_meta_description,
    //             GROUP_CONCAT(DISTINCT pi.filename ORDER BY pi.image_order) AS images
    //         FROM ' . self::TABLE .' p
    //         LEFT JOIN ' . self::TABLE_PRODUCTS_TRANSLATION .' pt 
    //             ON pt.product_id = p.id AND pt.locale = ?
    //         LEFT JOIN ' . self::TABLE_PRODUCT_IMAGES .' pi 
    //             ON pi.product_id = p.id
    //         LEFT JOIN ' . self::TABLE_CATEGORIES .' c 
    //             ON p.category_id = c.id
    //         LEFT JOIN ' . self::TABLE_CATEGORIES_TRANSLATION . ' ct 
    //             ON ct.category_id = c.id AND ct.locale = ?
    //         LEFT JOIN ' . self::TABLE_BRANDS . ' b 
    //             ON p.brand_id = b.id
    //         LEFT JOIN ' . self::TABLE_BRANDS_TRANSLATION . ' bt 
    //             ON bt.brand_id = b.id AND bt.locale = ?
    //     ';

    //     $bindings = [$this->locale, $this->locale, $this->locale];

    //     // фильтры
    //     if (!empty($data['productId'])) {
    //         $sql .= ' WHERE p.id = ?';
    //         $bindings[] = $data['productId'];
    //     } elseif (!empty($data['productIds']) && is_array($data['productIds'])) {
    //         $placeholders = implode(',', array_fill(0, count($data['productIds']), '?'));
    //         $sql .= " WHERE p.id IN ($placeholders)";
    //         $bindings = array_merge($bindings, $data['productIds']);
    //     } elseif (!empty($data['customWhere'])) {
    //         // кастомное WHERE
    //         $sql .= ' WHERE ' . $data['customWhere'];
    //         if (!empty($data['params'])) {
    //             $bindings = array_merge($bindings, $data['params']);
    //         }
    //     }

    //     $sql .= ' GROUP BY p.id';

    //     // сортировка уже может быть в customWhere, но оставим safeguard
    //     if (!empty($data['order'])) {
    //         $sql .= ' ' . $data['order'];
    //     } else {
    //         $sql .= ' ORDER BY p.id DESC';
    //     }

    //     if (isset($data['limit'])) {
    //         if (is_numeric($data['limit']) && (int)$data['limit'] > 0) {
    //             $sql .= ' LIMIT ' . (int)$data['limit'];
    //         } elseif (is_string($data['limit'])) {
    //             $sql .= ' ' . $data['limit'];
    //         }
    //     }

    //     return $this->getAll($sql, $bindings);
    // }

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

    /** Обновляет существующий продукт через DTO */
    public function updateProductData(
        int $productId,
        ProductInputDTO $dto,
        array $imagesDto,                // новые и обработанные изображения
        array $translations = []
    ): bool {
        $this->begin();
        try {
            // 1. Обновляем продукт
            $bean = $this->loadBean(self::TABLE_PRODUCTS, $productId);
            if (!$bean->id) throw new RuntimeException("Продукт {$productId} не найден");

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

            // 2. Сохраняем переводы
            if (!empty($translations)) {
                $translateDto = $this->createTranslateInputDto($translations, $productId);
                $this->saveProductTranslation($translateDto);
            }

            // 3. Сохраняем изображения через репозиторий изображений
            if (!empty($imagesDto)) {
                $imageRepo = new ProductImageRepository();
                foreach ($imagesDto as $image) {
                    if (!isset($image->id)) {
                        $imageRepo->addImage($image);
                    } else {
                        $imageRepo->updateImage($image->id, $image);
                    }
                }
            }

            $this->commit();
            return true;
        } catch (\Throwable $e) {
            $this->rollback();
            throw $e; // откатит изменения и даст понять, что была ошибка
        }
    }

    public function getProducts(array $filters = []): array
    {
        $sql = 'SELECT id, slug, title, description, price, status, sku, stock, datetime, edit_time, category_id, brand_id
                FROM ' . self::TABLE . ' WHERE 1=1';

        $params = [];

        if (!empty($filters['id'])) {
            $sql .= ' AND id = ?';
            $params[] = $filters['id'];
        }

        if (!empty($filters['status'])) {
            $sql .= ' AND status = ?';
            $params[] = $filters['status'];
        }

        if (!empty($filters['category_id'])) {
            $sql .= ' AND category_id = ?';
            $params[] = $filters['category_id'];
        }

        $sql .= ' ORDER BY datetime DESC';

        if (!empty($filters['limit'])) {
            $sql .= ' LIMIT ' . (int) $filters['limit'];
        }

        return $this->getAll($sql, $params);
    }


    // public function getProducts(array $filters = []): array
    // {
    //     $sql = 'SELECT id, slug, title, description, price, status, sku, stock, datetime, edit_time, category_id, brand_id
    //             FROM ' . self::TABLE . ' WHERE 1=1';

    //     $params = [];

    //     if (!empty($filters['id'])) {
    //         $sql .= ' AND id = ?';
    //         $params[] = $filters['id'];
    //     }

    //     if (!empty($filters['status'])) {
    //         $sql .= ' AND status = ?';
    //         $params[] = $filters['status'];
    //     }

    //     if (!empty($filters['category_id'])) {
    //         $sql .= ' AND category_id = ?';
    //         $params[] = $filters['category_id'];
    //     }

    //     $sql .= ' ORDER BY datetime DESC';

    //     return $this->getAll($sql, $params);
    // }

    // public function updateProductData(int $productId, ProductInputDTO $dto, array $processedImages, $dtoImagesFromRequest, array $translations = []): bool
    // {
    //     $this->begin();
    //     try 
    //     {
    //       $bean = $this->loadBean(self::TABLE_PRODUCTS, $productId);

    //       if (!$bean->id) {
    //           throw new RuntimeException("Продукт с ID {$productId} не найден");
    //       }

    //       $bean->category_id = $dto->category_id;
    //       $bean->brand_id = $dto->brand_id;
    //       $bean->slug = $dto->slug;
    //       $bean->title = $dto->title;
    //       $bean->description = $dto->description;
    //       $bean->price = $dto->price;
    //       $bean->url = $dto->url;
    //       $bean->sku = $dto->sku;
    //       $bean->stock = $dto->stock;
    //       $bean->status = $dto->status;
    //       $bean->edit_time = $dto->edit_time;

          
    //       $this->saveBean($bean);

    //       // если пришли новые переводы → пересохраняем
    //       if (!empty($translations)) {
    //           $translateDto = $this->createTranslateInputDto($translations, $productId);
    //           $this->saveProductTranslation($translateDto);
    //       }

    //       // если есть обработка изображений — делать её внутри той же транзакции:
    //       if (!empty($processedImages)) {
    //           $imageService = new AdminProductImageService();
    //           $finalImages = $imageService->finalizeImages($processedImages);
    //           $imagesDto = $this->createImagesInputDto($dtoImagesFromRequest??[], $finalImages, $productId);
    //           $imagesIds = $this->saveProductImages($imagesDto);
    //           if ($imagesIds === null || count($imagesIds) === 0) {
    //               throw new RuntimeException("Не удалось сохранить изображения при редактировании");
    //           }
    //       }

    //       $this->commit();
    //       return true;
    //     }
    //     catch (\Throwable $e)
    //     {
    //       $this->rollback();
    //       // безопасно чистим файлы только если $imageService определён
    //       if (isset($imageService)) {
    //           $imageService->cleanup($processedImages);
    //           if (!empty($finalImages)) {
    //               $imageService->cleanupFinal($finalImages);
    //           }
    //       }
    //       throw $e;
    //     }

    // }

    /**
      ********** ::: // UPDATE ::: **********
    */
    
    /**
      ********** ::: SAVE ::: **********
    */
    /** Создаёт новый продукт через DTO */
    public function saveProduct(ProductInputDTO $dto, array $translations, array $images, array  $processedImages): ?int
    {
      if (!$dto) {
          return null;
      }

      $imageService = new AdminProductImageService();
   
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
          if ($translateIds === null || count($translateIds) === 0) {
              throw new RuntimeException("Не удалось сохранить переводы");
          }

       
          // 3. Финализируем файлы после проверки
          $finalImages = $imageService->finalizeImages($processedImages);
      
          // Создаём DTO для изображений 
          $imagesDto = $this->imageRepo->createImagesInputDto($images, $finalImages, $productId);
          
          error_log(print_r(  $imagesDto, true));
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
        if (!empty($finalImages)) $imageService->cleanupFinal($finalImages);

        // $imageService->cleanup($processedImages);
        throw $e;      // пробрасываем ошибку выше
      }
  
    }


    public function bulkUpdate(array $ids, array $data): void
    {
        foreach ($ids as $id) {
            $this->updatePartial((int)$id, $data);
        }
    }


}
