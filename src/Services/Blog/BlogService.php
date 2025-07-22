<?php 
declare(strict_types=1);

namespace Vvintage\Services\Blog;

use Vvintage\Repositories\PostRepository;
use Vvintage\Models\Blog;

final class BlogService
{
  private PostRepository $postRepository;
  private Blog $blogModel;

  public function __construct( PostRepository $postRepository)
  {
    $this->postRepository = $postRepository;
    $this->blogModel = new Blog();
  }
// $productsPerPage = 9;
      // Получаем параметры пагинации
      // $pagination = pagination($productsPerPage, 'products');
  public function getAll(array $pagination): array
  {
   $beans = $this->postRepository->findAll($pagination);
   return $this->blogModel->getAll($beans);
  }



}