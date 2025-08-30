<?php
declare(strict_types=1);

namespace Vvintage\Contracts\PostCategory;

use Vvintage\Models\PostCategory\PostCategory;

interface PostCategoryRepositoryInterface
 {    
    public function getCategoryById(int $id): ?PostCategory;
    public function getAllCategories(): array; 
    public function getCategoriesByIds(array $ids): array;
    public function getMainCats(): array;
    public function getSubCats(): array;
    public function getPostCatsByParentId(?int $id = null): array;
    public function getParentCategory(PostCategory $childCategrory): ?PostCategory;
    public function savePostCat(PostCategory $cat): int;
    public function updateCategory(PostCategory $cat): int;
    public function deleteCategory(int $id): void;
  }
