<?php

declare(strict_types=1);

namespace Vvintage\Contracts\Category;

use Vvintage\Models\Category\Category;

interface CategoryRepositoryInterface
 {
    public function getCategoryById(int $id): ?Category;
    public function getAllCategories(): array;
    // public function getCategoriesByIds(array $ids): array;
    public function getMainCats(): array;
    public function getCategoryWithChildren(int $id): array;
    public function getParentCategory(Category $category): ?Category;
    public function getSubCats(): array;
    public function createMainCategoriesArray(): array;
    public function createSubCategoriesArray(?int $parent_id = null): array;

    public function saveCategory(Category $cat): int;
    public function findCatsByParentId(?int $parentId = null): array;
    public function hasChildren(int $id): bool;
    public function getAllCategoriesCount(?string $sql = null, array $params = []): int;
    public function deleteCategory(int $id): void;
}
