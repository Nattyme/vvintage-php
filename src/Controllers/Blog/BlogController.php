<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Blog;

use Vvintage\Routing\RouteData;
use Vvintage\Controllers\Base\BaseController;
use Vvintage\Services\Page\Breadcrumbs;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Post\PostService;
use Vvintage\DTO\Post\PostDTO;


require_once ROOT . './libs/functions.php';

final class BlogController extends BaseController
{
  private FlashMessage $notes;
  private Breadcrumbs $breadcrumbsService;
  private PostService $postService;

    public function __construct(
        FlashMessage $notes,
        Breadcrumbs $breadcrumbs
    ) {
        parent::__construct(); // Важно!
        $this->notes = $notes;
        $this->breadcrumbsService = $breadcrumbs;
        $this->postService = new PostService( $this->languages, $this->currentLang );
    }

    
    public function index(RouteData $routeData): void
    {
      $this->setRouteData($routeData); // <-- передаём routeData

      $pageTitle = 'Блог';
      $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);
      $postsPerPage = (int)($this->settings['card_on_page_blog'] ?? 9);
      $pagination = pagination($postsPerPage, 'posts');


      // Получаем посты и категории
      $blogData = $this->postService->getBlogData( $pagination);
      $shownPosts = (($pagination['page_number'] - 1) * $postsPerPage) + count($blogData['posts']);
      $relatedPosts = $blogData['posts'];


      // Формируем единую модель для передачи в шаблон
      $viewModel = [
          'posts' =>  $blogData['posts'],
          'mainCategories' => $blogData['mainCategories'],
          'subCategories' => $blogData['subCategories'],
          'totalPosts' =>  $blogData['totalPosts'],
          'shownPosts' => $shownPosts,
          'relatedPosts' => $relatedPosts
      ];


      $this->renderLayout('blog/blog', [
          'pagination' => $pagination,
          'pageTitle' => $pageTitle,
          'routeData' => $routeData,
          'breadcrumbs' => $breadcrumbs,
          'viewModel' => $viewModel
        
      ]);
    }
}
