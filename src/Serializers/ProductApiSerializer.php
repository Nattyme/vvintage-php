<?php
declare(strict_types=1);

namespace Vvintage\Serializers;

use Vvintage\Models\Product\Product;

final class ProductApiSerializer
{
    /**
     * Один продукт → API массив
     */
    public static function toArray(Product $product): array
    {
        return [
            'id'          => $product->getId(),
            'title'       => $product->getTitle(),
            'description' => $product->getContent(),
            'price'       => $product->getPrice(),
            'url'         => $product->getUrl(),
            'status'      => $product->getStatus(),
            'sku'         => $product->getSku(),
            'slug'        => $product->getSlug(),
            'stock'       => $product->getStock(),

            'category'    => [
                'id'    => $product->getCategory()->getId(),
                'title' => $product->getCategoryTitle(),
            ],

            'brand'       => [
                'id'    => $product->getBrandId(),
                'title' => $product->getBrandTitle(),
            ],

            'images'      => $product->getImages(),
            'translations'=> $product->getTranslations(),
            'locale'      => $product->getCurrentLocale(),

            'datetime'    => $product->getDatetime()->format('Y-m-d H:i:s'),
            'edit_time'   => $product->getEditTime(),
        ];
    }

    /**
     * Массив продуктов → массив API объектов
     */
    public static function toList(array $products): array
    {
        return array_map(
            fn(Product $product) => self::toArray($product),
            $products
        );
    }
}
