<?php
declare(strict_types=1);

namespace Vvintage\Contracts\Post;

use Vvintage\Models\Blog\Post;

interface PostRepositoryInterface
{    
  public function getPostById(int $id): ?Post;

  public function getAllPosts(array $pagination): array;

  public function getPostsByIds(array $ids): array;

  public function savePost (Post $post): int;
}
