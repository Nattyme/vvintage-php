<?php

declare(strict_types=1);

namespace Vvintage\Repositories\Product;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

use Vvintage\Contracts\Product\ProductImageRepositoryInterface;
use Vvintage\Repositories\AbstractRepository;

use Vvintage\DTO\Product\ProductImageInputDTO;
use Vvintage\DTO\Product\ProductImageOutputDTO;


// final class ProductImageRepository extends AbstractRepository implements ProductImageRepositoryInterface
final class ProductImageRepository extends AbstractRepository 
{
    private const TABLE = 'productimages';

    /** Создаёт новый OODBBean для изображения продукта */
    private function createProductImageBean(): OODBBean 
    {
        return $this->createBean(self::TABLE);
    }

    /**
     * Получить все изображения продукта, отсортированные по порядку
     */
    public function getAllImages(int $product_id): array
    {
        $beans = $this->findAll(
            table: self::TABLE,
            conditions: ['product_id = ?'],  // массив условий 
            params: [$product_id],           // значения для подстановки
            orderBy: 'image_order ASC'       // сортировка
        );

        // return array_map([$this, 'mapBeanToImageOutputDto'], $beans);
        return array_map(function($bean) {
          return [
            'id' => (int) $bean->id,
            'product_id' => (int) $bean->product_id,
            'filename' => (string) $bean->filename,
            'image_order' => (int) $bean->image_order,
            'alt' => (string) $bean->alt
          ];
        }, $beans);
    }

    /**
     * Получить изображение по id
     */
    public function getImageById(int $id): ?ProductImageOutputDTO
    {
        $bean = $this->loadBean(self::TABLE, $id);
        if (!$bean) {
            return null;
        }
        return $this->mapBeanToImageOutputDto($bean);
    }

    public function getMainImage(int $productId): array
    {
      $bean = $this->findOneBy(self::TABLE, 'WHERE product_id = ? AND image_order = ?', [$productId, 0]);
      return [
        'filename' => $bean->filename,
        'alt' => $bean->alt
      ];
    }

    /**
     * Добавить новое изображение продукта
     */
    public function addImage(ProductImageInputDTO $input): ProductImageOutputDTO
    {
        $bean = $this->createBean(self::TABLE);
        $bean->product_id = $input->product_id;
        $bean->filename = $input->filename;
        $bean->image_order = $input->image_order;
        $bean->alt = $input->alt;

        $result = $this->saveBean($bean);

        if (!$result) {
          throw new \RuntimeException("Не удалось сохранить название изображения {$input->filename}");
        }

        return $this->mapBeanToImageOutputDto($bean);
    }

    /**
     * Обновить существующее изображение
     */
    public function updateImage(int $id, ProductImageInputDTO $input): ProductImageOutputDTO
    {
        $bean = $this->loadBean(self::TABLE, $id);
        $bean->filename = $input->filename;
        $bean->image_order = $input->image_order;
        $bean->alt = $input->alt;

        $result = $this->saveBean($bean);

        if (!$result) {
          throw new \RuntimeException("Не удалось обновить список изображений");
        }

        return $this->mapBeanToImageOutputDto($bean);
    }

    /**
     * Удалить одно изображение
     */
    public function removeImage(int $id): void
    {
        $bean = $this->loadBean(self::TABLE, $id);
        if ($bean) {
            $this->deleteBean($bean);
        }
    }

    /**
     * Удалить все изображения продукта
     */
    public function removeAllImages(int $product_id): void
    {
        $beans = $this->findAll(table: self::TABLE, conditions: ['product_id = ?'], params: [$product_id]);
        foreach ($beans as $bean) {
            $this->deleteBean($bean);
        }
    }

    /**
     * Преобразовать RedBean OODBBean в ProductImageOutputDTO
     */
    private function mapBeanToImageOutputDto(OODBBean $bean): ProductImageOutputDTO
    {
        return new ProductImageOutputDTO([
            'id' => (int) $bean->id,
            'product_id' => (int) $bean->product_id,
            'filename' => (string) $bean->filename,
            'image_order' => (int) $bean->image_order,
            'alt' => (string) $bean->alt,
        ]);
    }

    public function deleteImagesNotInList(int $productId, array $keepIds): void
    {
        if (empty($keepIds)) {
            $beans = $this->findAll(table: self::TABLE, conditions: ['product_id = ?'], params: [$productId]);
        } else {
            $placeholders = implode(',', array_fill(0, count($keepIds), '?'));
            $params = array_merge([$productId], $keepIds);
            $beans = $this->findAll(
                table: self::TABLE,
                conditions: ["product_id = ? AND id NOT IN ($placeholders)"], // массив условий
                params: $params
            );

        }

        foreach ($beans as $bean) {
            $this->deleteBean($bean);
        }
    }


    public function updateImagesOrder(int $productId, array $images): void
    {
        foreach ($images as $index => $img) {
            $bean = $this->loadBean(self::TABLE, (int) $img['id']);
            if ($bean && $bean->product_id == $productId) {
                // Порядок берём из позиции элемента в массиве
                $bean->image_order = $index;
                $this->saveBean($bean);
            }
        }
    }

    public function createImagesInputDto(array $images, array $finalImages, int $productId): array
    {
        $imagesDto = [];

        // перебираем finalImages — это итог с filename
        foreach ($finalImages as $index => $finalImage) {
            $filename = $finalImage['filename'] ?? '';
            if (!$filename) {
                throw new RuntimeException("Пустое имя файла для изображения на позиции {$index}");
            }

            // ищем соответствующий $images[$index] или берём дефолт
            $image = $images[$index] ?? [];
            $imagesDto[] = new ProductImageInputDTO([
                'product_id' => $productId,
                'filename' => (string) $filename,
                'image_order' => (int) ($image['image_order'] ?? $index),
                'alt' => $image['alt'] ?? '',
            ]);
        }

        return $imagesDto;
    }

    public function fetchImageDTOs(int $productId): array
    {
     
      $sql = 'SELECT * 
             FROM ' . self::TABLE . '
             WHERE product_id = ? 
             ORDER BY image_order';

      return $this->getAll($sql, [$productId]);
    }

    public function getImagesByProductId (int $productId): array
    {
     
      $sql = 'SELECT * 
             FROM ' . self::TABLE . '
             WHERE product_id = ? 
             ORDER BY image_order';

      return $this->getAll($sql, [$productId]);
      // return array_map(fn($imageRow) => new ProductImageDTO($imageRow), $imagesRows);
    }
    
    public function saveProductImages(array $imagesDto): ?array
    {
        $ids = [];

        foreach($imagesDto as $dto) {
            if (!$dto) return null;

            // ПРОВЕРКА: существует ли файл
            if (!file_exists(ROOT . 'usercontent/products/' . $dto->filename)) {
                throw new RuntimeException("Файл {$dto->filename} не найден. Сохранение изображения отменено.");
            }

            $bean = $this->createProductImageBean();
            $bean->product_id = $dto->product_id;
            $bean->filename = $dto->filename;
            $bean->image_order = $dto->image_order;
            $bean->alt = $dto->alt;

            $this->saveBean($bean);

            $id = (int) $bean->id;
            if (!$id) return null;

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
