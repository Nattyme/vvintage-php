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
use Vvintage\DTO\Admin\Product\ProductInputDTO;
use Vvintage\DTO\Product\ProductFilterDTO;


// final class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
final class ProductRepository extends AbstractRepository 
{
    private const TABLE = 'products';

    /** Создаёт новый OODBBean для продукта */
    private function createProductBean(): OODBBean 
    {
        return $this->createBean(self::TABLE);
    }

  
    public function getProductById(int $id): array
    {
      $data = array_values($this->getProducts(['id' => $id]));

      return $data[0];
    }

    public function getModelProductById(int $id): ?Product
    {
      return array_values($this->getProductsModels(['id' => $id]))[0];
    }

    public function getProductsModels(array $filters = []): array
    {
        $conditions = [];
        $pagination = [];
        $params = [];

        if(isset($filters['pagination'])) {
           $pagination = $filters['pagination'];
        }

        // применяем простые фильтры
        [$conditions, $params] = $this->applySimpleFilters($filters, $conditions, $params);

        // применяем сложные фильтры
        [$conditions, $params, $orderBy] = $this->applyAdvancedFilters($filters, $conditions, $params);


        // Вызов универсального метода
        $beans = $this->findAll(
            table: self::TABLE,
            conditions: $conditions,
            params: $params,
            orderBy: $orderBy,
            limit:  $pagination['perPage'] ?? null,
            offset: $pagination['offset'] ?? null
        );

   
        return array_map(fn($bean) => Product::fromBean($bean), $beans);
    }

    public function getProductsByIds(array $ids): array
    {
        $beans = $this->findByIds(self::TABLE, $ids);
        return array_map(fn($bean) => Product::fromBean($bean), $beans);
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
        $filter['pagination']['perPage'] = $count;
    
        return $this->getProductsModels( $filter);
    }

    
    /**
      ********** ::: UPDATE ::: **********
    */
    
    public function updateStatus(int $productId, string $status): int
    {
      return $this->updatePartial($productId, ['status' => $status], ['id' => $productId]);
    }

    private function updatePartial(int $id, array $data): int
    {     
   
        $productBean = $this->loadBean(self::TABLE, $id);
     
        if (!$productBean->id) throw new RuntimeException("Product with ID {$id} not found");
        
        foreach ($data as $field => $value) {
            $productBean->{$field} = $value;
        }
  

        return $this->saveBean($productBean);
    
    }

    /** Обновляет существующий продукт через DTO */
    public function updateProductData(int $productId, array $product): bool
    {
        $bean = $this->loadBean(self::TABLE, $productId);

        if (!$bean->id) throw new RuntimeException("Продукт {$productId} не найден");

        $bean->category_id = $product['category_id'];
        $bean->brand_id = $product['brand_id'];
        $bean->slug = $product['slug'];
        $bean->title = $product['title'];
        $bean->description = $product['description'];
        $bean->price = $product['price'];
        $bean->url = $product['url'];
        $bean->sku = $product['sku'];
        $bean->stock = $product['stock'];
        $bean->status = $product['status'];
        $bean->edit_time = $product['edit_time'];

        $result = $this->saveBean($bean);

        
        if (!$result) throw new \RuntimeException("Не удалось обновить данные продукта");
        return true;
    }

    public function getProducts(array $filters = []): array
    {
        $conditions = [];
        $pagination = [];
        $params = [];
        if(isset($filters['pagination'])) {
           $pagination = $filters['pagination'];
        }

        // применяем простые фильтры
        [$conditions, $params] = $this->applySimpleFilters($filters, $conditions, $params);

        // применяем сложные фильтры
        [$conditions, $params, $orderBy] = $this->applyAdvancedFilters($filters, $conditions, $params);


        // Вызов универсального метода
        $beans = $this->findAll(
            table: self::TABLE,
            conditions: $conditions,
            params: $params,
            orderBy: $orderBy,
            limit:  $pagination['perPage'] ?? null,
            offset: $pagination['offset'] ?? null
        );

        // нормализация дат
        return array_map([$this, 'normalizeRow'], $beans);
    }

    private function applySimpleFilters(array $filters, array $conditions, array $params): array
    {
        if (isset($filters['id'])) {
            $conditions[] = "id = ?";
            $params[] = (int)$filters['id'];
        }

        if (isset($filters['status'])) {
            $conditions[] = "status = ?";
            $params[] = $filters['status'];
        }

        if (isset($filters['category_id'])) {
            $conditions[] = "category_id = ?";
            $params[] = (int)$filters['category_id'];
        }

        if (isset($filters['brand_id'])) {
            $conditions[] = "brand_id = ?";
            $params[] = (int)$filters['brand_id'];
        }

        // $limit = !empty($filters['perPage']) ? (int)$filters['perPage'] : 20;

        return [$conditions, $params];
    }

    private function applyAdvancedFilters(array $filters, array $conditions, array $params): array
    {

        // категории
        if (!empty($filters['categories'])) {
            $placeholders = $this->genSlots($filters['categories']);
            $conditions[] = "category_id IN ($placeholders)";
            $params = array_merge($params, $filters['categories']);
        }

        // бренды
        if (!empty($filters['brands'])) {
            $placeholders = $this->genSlots($filters['brands']);
            $conditions[] = "brand_id IN ($placeholders)";
            $params = array_merge($params, $filters['brands']);
        }

        // цена
        if (!empty($filters['priceMin'])) {
            $conditions[] = "price >= ?";
            $params[] = (float)$filters['priceMin'];
        }

        if (!empty($filters['priceMax'])) {
            $conditions[] = "price <= ?";
            $params[] = (float)$filters['priceMax'];
        }

        // сортировка
        $orderBy = 'datetime DESC';
        $allowedSorts = ['price ASC', 'price DESC', 'datetime DESC'];
        if (!empty($filters['sort']) && in_array($filters['sort'], $allowedSorts)) {
            $orderBy = $filters['sort'];
        }


        return [$conditions, $params, $orderBy];
    }

    /** Вынести в фабрику или сервис */
    private function normalizeRow(\RedBeanPHP\OODBBean $bean): array
    {
        $row = $bean->export();
       
        $row['datetime'] = !empty($row['datetime'])
            ? (is_numeric($row['datetime'])
                ? (new \DateTime())->setTimestamp((int)$row['datetime'])
                : new \DateTime($row['datetime']))
            : new \DateTime();
  
        return $row;
    }
    
    /**
      ********** ::: SAVE ::: **********
    */
    /** Создаёт новый продукт через DTO */
    public function saveProduct(ProductInputDTO $dto): ?int
    {
      if (!$dto) throw new RuntimeException("Не получены данные для создания продукта");
 
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

      if (!$productId) throw new RuntimeException("Не удалось сохранить продукт");

      return $productId;
    }


    public function bulkUpdate(array $ids, array $data): void
    {
        foreach ($ids as $id) {
            $this->updatePartial((int)$id, $data);
        }
    }


}
