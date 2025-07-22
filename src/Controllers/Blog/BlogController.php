<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Blog;


/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

use Vvintage\Services\Page\Breadcrumbs;
use Vvintage\Services\Messages\FlashMessage;

require_once ROOT . './libs/functions.php';

final class BlogController extends BaseController
{
  private BlogService $blogService;
  private Blog $blogModel;
  private array $posts;
  private FlashMessage $notes;
  private Breadcrumbs $breadcrumbsService;
  
  public function __construct(
    BlogService $blogService, 
    Blog $blogModel,
    array $posts,
    FlashMessage $notes,
    Breadcrumbs $breadcrumbs
  )
  {
    $this->blogService = $blogService;
    $this->blogModel = $blogModel;
    $this->posts = $posts;
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
    $posts = Blog::getAll($pagination);
    
    // Считаем, сколько всего товаров в базе (для отображения "Показано N из M")
    $totalPosts = Blog::getTotalProductsCount();
    
    // Это кол-во товаров, показанных на этой странице
    // $shownProducts = $totalProducts - count($products);
    $shownPosts = (($pagination['page_number'] - 1) * 9) + count($prosts);

    // Хлебные крошки
    $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

    // Подключение шаблонов страницы
    $this->renderLayout('shop/catalog', [
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
