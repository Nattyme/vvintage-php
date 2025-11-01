<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Blog;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

// use Vvintage\Repositories\Post\PostRepository;
use Vvintage\Models\Post\Post;
use Vvintage\Routing\RouteData;

/** Сервисы */
use Vvintage\Services\Page\Breadcrumbs;
use Vvintage\Services\Post\PostService;
use Vvintage\Services\SEO\SeoService;
use Vvintage\Services\Navigation\NavigationService;
use Vvintage\Services\Session\SessionService;
use Vvintage\Services\AdminPanel\AdminPanelService;
use Vvintage\Services\Page\PageService;
use Vvintage\Services\Messages\FlashMessage;


final class PostController extends BaseController
{
    public function __construct(
      protected SessionService $sessionService, 
      protected AdminPanelService $adminPanelService,
      protected PageService $pageService,
      protected FlashMessage $flash,
      private PostService $postService, 
      private NavigationService $navigationService, 
      private SeoService $seoService,
      private Breadcrumbs $breadcrumbsService,
    )
    {
        parent::__construct($sessionService, $adminPanelService, $pageService, $flash); // Важно!
    }


    public function index(RouteData $routeData): void
    {   
    
        $this->setRouteData($routeData); // <-- передаём routeData

        $id = (int) $routeData->uriGet ?? null; // получаем id поста из URL
        $postData = $this->postService->getPostData($id); 
    
        if (!$postData) {
            http_response_code(404);
            echo 'Пост не найден';
            return;
        }

        // Получаем данные навигации
        $navigation = [
          'header' => $this->navigationService->getMainCategoriesWithContent($postData['mainCategories'], $postData['subCategories'], $postData['categoryIds']),
          'footer' => $this->navigationService->getSubCategoriesWithContent($postData['subCategories'],  $postData['categoryIds'])
        ];

        // Формируем единую модель для передачи в шаблон
        $viewModel = [
            'mainCategories' => $postData['mainCategories'],
            'subCategories' => $postData['subCategories'],
        ];

        // Подключение шаблонов страницы
        $this->renderLayout('blog/post', [
              'post' => $postData['post'],
              'navigation' => $navigation,
              // 'seo' => $seo,
              'routeData' => $routeData,
              'viewModel' => $viewModel
        ]);
    }
}
