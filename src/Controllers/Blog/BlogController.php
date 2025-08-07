<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Blog;

use Vvintage\Routing\RouteData;
use Vvintage\Controllers\Base\BaseController;
use Vvintage\Services\Page\Breadcrumbs;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Blog\BlogService;
use Vvintage\DTO\Blog\PostDTO;


require_once ROOT . './libs/functions.php';

final class BlogController extends BaseController
{
  private FlashMessage $notes;
  private Breadcrumbs $breadcrumbsService;

  private BlogService $blogService;

    public function __construct(
        FlashMessage $notes,
        Breadcrumbs $breadcrumbs
    ) {
        parent::__construct(); // Важно!
        $this->notes = $notes;
        $this->breadcrumbsService = $breadcrumbs;
        $this->postRepository = new PostRepository( $this->currentLang );
        $this->blogService = new BlogService( $postRepository );
    }

    
    public function index(RouteData $routeData): void
    {
      $this->setRouteData($routeData); // <-- передаём routeData


      $pageTitle = 'Блог';
      $postsPerPage = (int)($this->settings['card_on_page_blog'] ?? 9);

      $pagination = pagination($postsPerPage, 'posts');

      $posts = $this->blogService->getAllPosts($pagination);
      dd($posts);
      $totalPosts = $this->blogService->getTotalCount();

      $shownPosts = (($pagination['page_number'] - 1) * $postsPerPage) + count($posts);
      $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

      // Вывод похожих постов
      // $relatedPosts = get_related_posts($post->getTitle());
      $relatedPosts = $posts;

      // Формируем единую модель для передачи в шаблон
      $productViewModel = [
          'posts' => $posts,
          'totalPosts' => $totalPosts,
          'shownPosts' => $shownPosts,
          'relatedPosts' => $relatedPosts
      ];


      $this->renderLayout('blog/blog', [
          'pagination' => $pagination,
          'pageTitle' => $pageTitle,
          'routeData' => $routeData,
          'breadcrumbs' => $breadcrumbs,
          'productViewModel' => $productViewModel
        
      ]);
    }


    // метод получает $_POST, создаёт DTO, передаёт в сервис
    public function add(RouteData $routeData): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dto = new PostDTO($_POST);
            $this->blogService->add($dto);
            $this->notes->success('Пост добавлен');
            redirect('/admin/blog'); // или куда нужно
        }

        $pageTitle = 'Добавить пост';

        $this->renderLayout('blog/add', [
            'pageTitle' => $pageTitle,
            'routeData' => $routeData,
        ]);
    }

}
