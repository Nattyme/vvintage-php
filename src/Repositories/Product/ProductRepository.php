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
use Vvintage\DTO\Product\ProductOutputDTO;
use Vvintage\DTO\Product\ProductInputDTO;
use Vvintage\DTO\Product\ProductFilterDTO;


final class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{
    private const TABLE = 'products';


    /**
      ********** ::: CREATE ::: **********
    */

    /************ CRETE BEAN ********/
    /** Создаёт новый OODBBean для продукта */
    private function createProductBean(): OODBBean 
    {
        return $this->createBean(self::TABLE);
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

    public function getProductsByIds(array $ids): array
    {
        $beans = $this->findByIds(self::TABLE, $ids);

        // экспортируем beans в массивы
        $rows = array_map(fn($bean) => $bean->export(), $beans);

        // нормализуем datetime
        return array_map(function(array $row) {
            if (!empty($row['datetime'])) {
                $row['datetime'] = is_numeric($row['datetime'])
                    ? (new \DateTime())->setTimestamp((int)$row['datetime'])
                    : new \DateTime($row['datetime']);
            } else {
                $row['datetime'] = new \DateTime(); // fallback
            }

            return $row;
        }, $rows);
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
      
        $productBean = $this->loadBean(self::TABLE, $id);
     
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
      $conditions = [];
      $params = [];

      // Фильтр по категориям (список)
      if (!empty($filters['categories'])) {
          $placeholders = R::genSlots($filters['categories']); // ?, ?, ?
          $conditions[] = "category_id IN ($placeholders)";
          $params = array_merge($params, $filters['categories']);
      }

      // Фильтр по брендам (список)
      if (!empty($filters['brands'])) {
          $placeholders = R::genSlots($filters['brands']);
          $conditions[] = "brand_id IN ($placeholders)";
          $params = array_merge($params, $filters['brands']);
      }

      // Фильтр по цене
      if (!empty($filters['priceMin'])) {
          $conditions[] = "price >= ?";
          $params[] = (float)$filters['priceMin'];
      }

      if (!empty($filters['priceMax'])) {
          $conditions[] = "price <= ?";
          $params[] = (float)$filters['priceMax'];
      }

      // Сортировка
      $orderBy = 'datetime DESC';
      if (!empty($filters['sort'])) {
          $orderBy = $filters['sort']; // тут лучше whitelist сделать
      }

      // Пагинация
      $limit = 20;
      $offset = 0;
      if (!empty($filters['page']) && $filters['page'] > 1) {
          $offset = ($filters['page'] - 1) * $limit;
      }

      // Универсальный findAll
      $beans = $this->findAll(
          self::TABLE,
          $conditions,
          $params,
          $orderBy,
          $limit,
          $offset
      );

      // Нормализация дат
      return array_map(function(\RedBeanPHP\OODBBean $bean) {
          $row = $bean->export();

          $row['datetime'] = !empty($row['datetime'])
              ? (is_numeric($row['datetime'])
                  ? (new \DateTime())->setTimestamp((int)$row['datetime'])
                  : new \DateTime($row['datetime']))
              : new \DateTime();

          return $row;
      }, $beans);
  }



    // public function getProducts(array $filters = []): array
    // {
    //     $sql = 'SELECT id, category_id, brand_id, slug, title, description, price, url, sku, stock, datetime, status, edit_time
    //             FROM ' . self::TABLE . ' WHERE 1=1';

    //     $params = [];

    //     if (isset($filters['id'])) {
    //         $sql .= ' AND id = ?';
    //         $params[] = $filters['id'];
    //     }

    //     if (isset($filters['status'])) {
    //         $sql .= ' AND status = ?';
    //         $params[] = $filters['status'];
    //     }

    //     if (isset($filters['category_id'])) {
    //         $sql .= ' AND category_id = ?';
    //         $params[] = $filters['category_id'];
    //     }

    //     if (isset($filters['brand_id'])) {
    //         $sql .= ' AND brand_id = ?';
    //         $params[] = $filters['brand_id'];
    //     }

    //     $sql .= ' ORDER BY datetime DESC';

    //     if (isset($filters['limit']) && (int)$filters['limit'] > 0) {
    //         $sql .= ' LIMIT ' . (int)$filters['limit'];
    //     }

    //     $rows = $this->getAll($sql, $params);

    //     //  нормализуем
    //     return array_map(function(array $row) {
    //         if (!empty($row['datetime'])) {
    //             // поддержка timestamp и строк
    //             $row['datetime'] = is_numeric($row['datetime'])
    //                 ? (new \DateTime())->setTimestamp((int)$row['datetime'])
    //                 : new \DateTime($row['datetime']);
    //         } else {
    //             $row['datetime'] = new \DateTime(); // fallback
    //         }
            
    //         return $row;
    //     }, $rows);
    // }
    /**
      ********** ::: // UPDATE ::: **********
    */
    
    /**
      ********** ::: SAVE ::: **********
    */
    /** Создаёт новый продукт через DTO */
    public function saveProduct(ProductInputDTO $dto): ?int
    {
      if (!$dto) {
        throw new RuntimeException("Не получены данные для создания продукта");
        return null;
      }

     
      // Создаем или загружаем продукт
      $bean = $dto->id 
          ? $this->findById(self::TABLE, $dto->id)
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

      return $productId;
    }


    public function bulkUpdate(array $ids, array $data): void
    {
        foreach ($ids as $id) {
            $this->updatePartial((int)$id, $data);
        }
    }


}
