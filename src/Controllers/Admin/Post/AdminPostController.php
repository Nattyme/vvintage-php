<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin\Post;

use Vvintage\Routing\RouteData;
use Vvintage\Services\Page\Breadcrumbs;
use Vvintage\Services\Admin\Post\AdminPostService;

/** Контракты */
use Vvintage\Contracts\Post\PostRepositoryInterface;
use Vvintage\Contracts\PostCategory\PostCategoryRepositoryInterface;

/** Контроллеры */
use Vvintage\Controllers\Admin\BaseAdminController;

class AdminPostController extends BaseAdminController
{
  private AdminPostService $service;
  private Breadcrumbs $breadcrumbs;

  public function __construct(Breadcrumbs $breadcrumbs)
  {
    parent::__construct();
    $this->service = new AdminPostService($this->languages, $this->currentLang);
    $this->breadcrumbs = $breadcrumbs;
  }

  public function all (RouteData $routeData)
  {
    $this->isAdmin();
    $this->setRouteData($routeData);
    $this->service->handleStatusAction($_POST);
    $this->renderAllPosts($routeData);
  }

  public function new (RouteData $routeData)
  {
    $this->isAdmin();
    $this->setRouteData($routeData);
    $this->renderAddPost($routeData);
  }

  public function edit(RouteData $routeData)
  {
    $this->isAdmin();
    $this->setRouteData($routeData);
    $this->service->handleStatusAction($_POST);
    $this->renderEditPost($this->routeData);
  }
  
  private function renderAllPosts(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = 'Блог - все записи';
    $postsPerPage = 9;

    // Устанавливаем пагинацию
    $pagination = pagination($postsPerPage, 'posts');
    $blogData = $this->service->getBlogData($_GET, $postsPerPage);

    $total = $this->service->getTotalCount();
    $actions = $this->service->getActions();

    // Формируем единую модель для передачи в шаблон
    $pageViewModel = [
        'posts' => $blogData['posts'],
        'total' => $total,
        'actions'=> $actions
    ];
        

    $this->renderLayout('blog/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $this->routeData,
      'pageViewModel' => $pageViewModel,
      'pagination' => $pagination,
      'flash' => $this->flash
    ]);
  }

  private function renderNewPost(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = "Добавить новую статью";
    // $pageClass = "admin-page";

    $this->renderLayout('blog/new',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'flash' => $this->flash
    ]);
  }

  private function renderEditPost(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = "Редактирование статьи";
    // $pageClass = "admin-page";

    // Получаем пост по Id 
    $postId = $routeData->uriGet;
    // $post = $this->service->getPost((int) $postId);
    $post =  $this->service->getPostEditData((int) $postId);

    $this->renderLayout('blog/edit',  [
      'post' => $post,
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'flash' => $this->flash
    ]);
  }

}