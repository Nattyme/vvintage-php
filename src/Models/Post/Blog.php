<?php

declare(strict_types=1);

// namespace Vvintage\Models\Blog;

// use RedBeanPHP\R;
// use Vvintage\Repositories\PostRepository;
// use Vvintage\Database\Database;

require_once ROOT . "./libs/functions.php";

final class Blog
{
  private Post $postModel;

  public function __construct()
  {
    $this->postModel = new Post();
  }

  public function getAll($beans): array
  {
      $posts = [];

      foreach ($beans as $row=>$bean) {
        $post =  $this->postModel->fromBean($bean);
        $posts[] = $post;
      }

      return $posts;
  }

  public static function getTotalPostsCount(): int
  {
      return R::count('posts');
  }


}
