<?php
declare(strict_types=1);

namespace Vvintage\Contracts\PostCategory;

use Vvintage\Models\PostCategory\PostCategory;

interface PostCategoryRepositoryInterface
 {    
    public function getPostCatById(int $id): ?PostCategory;

    public function getAllPostCats(): array;

    public function getPostCatsByIds(array $ids): array;

    public function getMainCats(): array;

    public function getSubCats(): array;

    public function getPostCatsByParentId(?int $id = null): array;


    public function savePostCat(Category $cat): int;

    /**
     * Загружает переводы из categories_translation
     */
    public function loadTranslations(int $categoryId): array;

    public function mapBeanToPostCategory(OODBBean $bean): Category;
  }
