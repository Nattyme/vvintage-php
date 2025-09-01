<?php
declare(strict_types=1);

namespace Vvintage\Serializers;

use Vvintage\Models\Category\Category;

final class CategoryApiSerializer
{
    /**
     * Одну категорию → API массив
     */
    public static function toArray(Category $category): array
    {
        return [
            'id'          => $category->getId(),
            'title'       => $category->getTitle(),
            'parent_id'   => $category->getParentId(),
            'slug'        => $category->getSlug(),
            'image'       => $category->getImage(),

            'translations'=> $category->getTranslations(),
            'locale'      => $category->getCurrentLocale(),
        ];
    }

    /**
     * Массив категорий → массив API объектов
     */
    public static function toList(array $categories): array
    {
        return array_map(
            fn(Category $category) => self::toArray($category),
            $categories
        );
    }

    /**
     * Для getOne/getBySlug (если нужно обернуть в объект)
     */
    public static function toItem(Category $category): array
    {
        return ['category' => self::toArray($category)];
    }
}
