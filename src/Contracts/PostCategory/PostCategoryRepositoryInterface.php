<?php
declare(strict_types=1);

namespace Vvintage\Contracts\PostCategory;

use Vvintage\Models\PostCategory\PostCategory;

interface PostCategoryRepositoryInterface
 {    
    public function getPostCatById(int $id): ?PostCategory;
    public function getAllCategories(): array; 
    public function getPostCatsByIds(array $ids): array;
    public function getMainCats(): array;
    public function getSubCats(): array;
    public function getPostCatsByParentId(?int $id = null): array;
  }
