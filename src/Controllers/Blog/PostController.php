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


final class PostController extends BaseController
{
    private SeoService $seoService;
    private Breadcrumbs $breadcrumbsService;
    private PostService $postService;
    private NavigationService $navigationService;

    public function __construct(
      SessionService $sessionService, 
      AdminPanelService $adminPanelService,
      PostService $postService, 
      NavigationService $navigationService, 
      SeoService $seoService,
      Breadcrumbs $breadcrumbs
    )
    {
        parent::__construct($sessionService, $adminPanelService); // Важно!
        $this->seoService = $seoService;
        $this->breadcrumbsService = $breadcrumbs;
        $this->postService = $postService;
        $this->navigationService = $navigationService;
    }


    public function index(RouteData $routeData): void
    {   
    
        $this->setRouteData($routeData); // <-- передаём routeData

        $id = (int) $routeData->uriGet ?? null; // получаем id поста из URL
        $postData = $this->postService->getPostData($id); 
        // $post = $this->postService->getPostById ($id);
        // $postDto = $this->postService->getPostDto($post);


        if (!$postData) {
            http_response_code(404);
            echo 'Пост не найден';
            return;
        }

        // $mainCategories = $this->postService->getAllMainCategories();
        // $subCategories = $this->postService->getAllSubCategories();

        // Получаем похожие посты
        // $postsPerPage = (int)($this->settings['card_on_page_blog'] ?? 9);;
        // $pagination = pagination($postsPerPage, 'posts');
        // $relatedPosts = $post;
        // $relatedPosts = $post->getRelated();

        // Получаем seo страницы
        // $seo = $this->seoService->getSeoForPage('post',  $postData['post']);

        // Хлебные крошки
        // $breadcrumbs = $this->breadcrumbsService->generate($routeData, $postData['post']->title);


        // Получаем данные навигации
        $navigation = [
          'header' => $this->navigationService->getMainCategoriesWithContent($postData['mainCategories'], $postData['subCategories'], $postData['categoryIds']),
          'footer' => $this->navigationService->getSubCategoriesWithContent($postData['subCategories'],  $postData['categoryIds'])
        ];

        // Формируем единую модель для передачи в шаблон
        $viewModel = [
            'mainCategories' => $postData['mainCategories'],
            'subCategories' => $postData['subCategories'],
            // 'breadcrumbs' => $breadcrumbs
        ];

        // Подключение шаблонов страницы
        $this->renderLayout('blog/post', [
              'post' => $postData['post'],
              'navigation' => $navigation,
              // 'seo' => $seo,
              'routeData' => $routeData,
              'viewModel' => $viewModel,
              'currentLang' =>  $this->postService->currentLang,
              'languages' => $this->postService->languages
        ]);
    }
}
