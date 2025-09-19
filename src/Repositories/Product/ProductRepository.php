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
    public function getProductById(int $id): array
    {
      $data = $this->getProducts(['id' => $id])[0];
 
      return $data;
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
    
    }

    /** Обновляет существующий продукт через DTO */
    public function updateProductData(int $productId, ProductInputDTO $dto): bool
    {
        $bean = $this->loadBean(self::TABLE, $productId);

        if (!$bean->id) {
            throw new RuntimeException("Продукт {$productId} не найден");
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

        $result = $this->saveBean($bean);

        
        if (!$result) {
          throw new \RuntimeException("Не удалось обновить данные продукта");
        }

        return true;
    }


    public function getProducts(array $filters = []): array
    {
        $sql = 'SELECT id, category_id, brand_id, slug, title, description, price, url, sku, stock, datetime, status, edit_time
                FROM ' . self::TABLE . ' WHERE 1=1';

        $params = [];

        if (isset($filters['id'])) {
            $sql .= ' AND id = ?';
            $params[] = $filters['id'];
        }

        if (isset($filters['status'])) {
            $sql .= ' AND status = ?';
            $params[] = $filters['status'];
        }

        if (isset($filters['category_id'])) {
            $sql .= ' AND category_id = ?';
            $params[] = $filters['category_id'];
        }

        $sql .= ' ORDER BY datetime DESC';

        if (isset($filters['limit']) && (int)$filters['limit'] > 0) {
            $sql .= ' LIMIT ' . (int)$filters['limit'];
        }

        $rows = $this->getAll($sql, $params);

        // тут нормализуем
        return array_map(function(array $row) {
            if (!empty($row['datetime'])) {
                // поддержка timestamp и строк
                $row['datetime'] = is_numeric($row['datetime'])
                    ? (new \DateTime())->setTimestamp((int)$row['datetime'])
                    : new \DateTime($row['datetime']);
            } else {
                $row['datetime'] = new \DateTime(); // fallback
            }
            
            return $row;
        }, $rows);
    }
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
