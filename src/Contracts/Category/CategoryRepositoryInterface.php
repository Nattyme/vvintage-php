<?php

declare(strict_types=1);

namespace Vvintage\Contracts\Category;

use Vvintage\Models\Category\Category;

interface CategoryRepositoryInterface
 {
    public function getCategoryById(int $id): ?Category;
    public function getAllCategories(): array;
    
    public function getMainCats(): array;
    public function getParentCategory(int $id): ?Category;    
    public function getSubCats(): array;
    public function createMainCategoriesArray(): array;
    public function createSubCategoriesArray(?int $parent_id = null): array;

    public function saveCategory(array $data): int; 
    public function findCatsByParentId(?int $parentId = null): array;
    public function getAllCategoriesCount(?string $sql = null, array $params = []): int;
    public function deleteCategory(int $id): void;
}
