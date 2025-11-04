<?php
declare(strict_types=1);

namespace Vvintage\public\Controllers\Blog;

use Vvintage\Routing\RouteData;

use Vvintage\public\Controllers\Base\BaseController;
use Vvintage\Services\Navigation\NavigationService;
use Vvintage\Services\Page\Breadcrumbs;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Session\SessionService;
use Vvintage\Services\Post\PostService;
use Vvintage\DTO\Post\PostFilterDTO;


require_once ROOT . './libs/functions.php';

final class BlogController extends BaseController
{
  private Breadcrumbs $breadcrumbsService;
  private PostService $postService;
  private NavigationService $navigationService;
  

    public function __construct(
        FlashMessage $flash,
        SessionService $sessionService,
        Breadcrumbs $breadcrumbs
    ) 
    {
        $this->breadcrumbsService = $breadcrumbs;
        $this->postService = new PostService();
        $this->navigationService = new NavigationService();
        parent::__construct($flash, $sessionService, $this->pageService, $this->seoService); // Важно!
        
    }
    
    public function index(RouteData $routeData): void
    {
   
      $this->setRouteData($routeData); // <-- передаём routeData

      $pageTitle = 'Блог';
      // $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);
    
      // Кол-во постов перенести в сервис настроек
      $postsPerPage = (int)($this->settings['card_on_page_blog'] ?? 9);

      // Получаем посты и категории
      $slug = $routeData->uriGet ?? null;
 
      $blogData = $this->postService->getBlogData(array_merge($routeData->uriGetParams, ['slug' => $slug]), $postsPerPage);
      // $shownPosts = (($pagination['page_number'] - 1) * $postsPerPage) + count($posts);

      // Получаем данные навигации
      $navigation = [
        'header' => $this->navigationService->getMainCategoriesWithContent($blogData['mainCategories'], $blogData['subCategories'],  $blogData['categoryIds']),
        'footer' => $this->navigationService->getSubCategoriesWithContent($blogData['subCategories'],  $blogData['categoryIds'])
      ];
  
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
          'navigation' => $navigation,
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
