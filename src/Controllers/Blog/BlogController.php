<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Blog;


use Vvintage\Routing\RouteData;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

use Vvintage\Services\Page\Breadcrumbs;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Blog\BlogService;

use Vvintage\Models\Blog\Blog;
use Vvintage\Repositories\PostRepository;

require_once ROOT . './libs/functions.php';

final class BlogController extends BaseController
{
  private PostRepository $postRepository;
  private BlogService $blogService;
  private Blog $blogModel;
  // private array $posts;
  private FlashMessage $notes;
  private Breadcrumbs $breadcrumbsService;
  
  public function __construct(
    FlashMessage $notes,
    Breadcrumbs $breadcrumbs
  )
  {
    $this->postRepository = new PostRepository();
    $this->blogService = new BlogService($this->postRepository);
    $this->blogModel = new Blog();
    $this->notes = $notes;
    $this->breadcrumbsService = $breadcrumbs;
  }

  public function index(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = 'Блог';

    $postsPerPage = 9;
    // Получаем параметры пагинации
    $pagination = pagination($postsPerPage, 'posts');

    // Получаем продукты с учётом пагинации
    $posts =  $this->blogService->getAll($pagination);
    
    // Считаем, сколько всего товаров в базе (для отображения "Показано N из M")
    $totalPosts = $this->blogModel->getTotalPostsCount();
    
    // Это кол-во товаров, показанных на этой странице
    // $shownProducts = $totalProducts - count($products);
    $shownPosts = (($pagination['page_number'] - 1) * 9) + count($posts);

    // Хлебные крошки
    $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

    // Подключение шаблонов страницы
    $this->renderLayout('blog/blog', [
          'pagination' => $pagination,
          'pageTitle' => $pageTitle,
          'routeData' => $routeData,
          'breadcrumbs' => $breadcrumbs,
          'posts' => $posts,
          'totalPosts' => $totalPosts,
          'shownPosts' => $shownPosts,
    ]);
  }

}
