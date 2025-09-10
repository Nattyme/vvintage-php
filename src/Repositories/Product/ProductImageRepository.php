<?php

declare(strict_types=1);

namespace Vvintage\Repositories\Product;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;

use Vvintage\Contracts\Product\ProductImageRepositoryInterface;
use Vvintage\Repositories\AbstractRepository;

use Vvintage\DTO\Product\ProductImageInputDTO;
use Vvintage\DTO\Product\ProductImageOutputDTO;


final class ProductImageRepository extends AbstractRepository implements ProductImageRepositoryInterface
{
    private const TABLE = 'productimages';

    /**
     * Получить все изображения продукта, отсортированные по порядку
     */
    public function getAllImages(int $product_id): array
    {
        $beans = $this->findAll(self::TABLE, 'WHERE product_id = ? ORDER BY image_order ASC', [$product_id]);
        return array_map([$this, 'mapBeanToImageOutputDto'], $beans);
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

        $this->saveBean($bean);

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

        $this->saveBean($bean);

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

    public function removeImagesByIds(array $ids): void
    {
        if (empty($ids)) return;

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $beans = $this->findAll(self::TABLE, "WHERE id IN ($placeholders)", $ids);

        foreach ($beans as $bean) {
            $this->deleteBean($bean);
        }
    }


    /**
     * Удалить все изображения продукта
     */
    public function removeAllImages(int $product_id): void
    {
        $beans = $this->findAll(self::TABLE, 'WHERE product_id = ?', [$product_id]);
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
}
