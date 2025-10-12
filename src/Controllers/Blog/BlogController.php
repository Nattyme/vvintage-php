<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Blog;

use Vvintage\Routing\RouteData;
use Vvintage\Controllers\Base\BaseController;
use Vvintage\Services\Page\Breadcrumbs;
use Vvintage\Services\Post\PostService;
use Vvintage\DTO\Post\PostFilterDTO;


require_once ROOT . './libs/functions.php';

final class BlogController extends BaseController
{
  private Breadcrumbs $breadcrumbsService;
  private PostService $postService;
  

    public function __construct(
        Breadcrumbs $breadcrumbs
    ) {
        parent::__construct(); // Важно!
        $this->breadcrumbsService = $breadcrumbs;
        $this->postService = new PostService();
        
    }

    
    public function index(RouteData $routeData): void
    {
      $this->setRouteData($routeData); // <-- передаём routeData

      $pageTitle = 'Блог';
      // $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);
    
      // Кол-во постов перенести в сервис настроек
      $postsPerPage = (int)($this->settings['card_on_page_blog'] ?? 9);


      // $filterDto = new PostFilterDTO([
      //     'categories'=> $_GET['category'] ?? [],
      //     'sort'      => $_GET['sort'] ?? null,
      //     'search' => $_GET['q'] ?? null,
      //     // 'page' =>  $page,
      //     'perPage' => (int) $postsPerPage ?? 10
      // ]);


      // // Получаем статьи с учётом пагинации
      // $filteredPostsData = $this->postService->getFilteredPosts( filters: $filterDto, perPage: 9);
     
      // $posts =  $filteredPostsData['posts'];
      // $total = $filteredPostsData['total'];
      // $filters = $filteredPostsData['filters'];
      // $pagination = $filters['pagination'];


      // Получаем посты и категории
      $blogData = $this->postService->getBlogData($_GET, $postsPerPage);
      // $shownPosts = (($pagination['page_number'] - 1) * $postsPerPage) + count($posts);
  

      // Формируем единую модель для передачи в шаблон
      $viewModel = [
          'posts' =>  $blogData['posts'],
          'mainCategories' => $blogData['mainCategories'],
          'subCategories' => $blogData['subCategories'],
          'totalPosts' =>  $blogData['totalPosts'],
          // 'shownPosts' => $shownPosts,
          // 'relatedPosts' => $blogData['relatedPosts']
      ];


      $this->renderLayout('blog/blog', [
          // 'pagination' => $pagination,
          'pageTitle' => $pageTitle,
          'routeData' => $routeData,
          // 'breadcrumbs' => $breadcrumbs,
          'viewModel' => $viewModel,
          'flash' => $this->flash,
          'currentLang' =>  $this->postService->currentLang,
          'languages' => $this->postService->languages
      ]);
    }
}
