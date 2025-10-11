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


final class PostController extends BaseController
{
    private SeoService $seoService;
    private Breadcrumbs $breadcrumbsService;
    private PostService $postService;

    public function __construct(Breadcrumbs $breadcrumbs)
    {
        parent::__construct(); // Важно!
        $this->seoService = new SeoService();
        $this->breadcrumbsService = $breadcrumbs;
        $this->postService = new PostService();
    }


    public function index(RouteData $routeData): void
    {   
    
        $this->setRouteData($routeData); // <-- передаём routeData

        $id = (int) $routeData->uriGet; // получаем id поста из URL

        $post = $this->postService->getPostById ($id);

        // $post = $this->postService->getPost($id);

        if (!$post) {
            http_response_code(404);
            echo 'Пост не найден';
            return;
        }

        $mainCategories = $this->postService->getAllMainCategories();
        $subCategories = $this->postService->getAllSubCategories();

        // Получаем похожие посты
        $postsPerPage = (int)($this->settings['card_on_page_blog'] ?? 9);;
        $pagination = pagination($postsPerPage, 'posts');
        // $relatedPosts = $post;
        // $relatedPosts = $post->getRelated();

        // Получаем seo страницы
        $seo = $this->seoService->getSeoForPage('post', $post);

        // Хлебные крошки
        $breadcrumbs = $this->breadcrumbsService->generate($routeData, $post->getTitle());

        // Формируем единую модель для передачи в шаблон
        $viewModel = [
            'mainCategories' => $mainCategories,
            'subCategories' => $subCategories,
            'breadcrumbs' => $breadcrumbs
        ];

        // Подключение шаблонов страницы
        $this->renderLayout('blog/post', [
              'post' => $post,
              'seo' => $seo,
              'routeData' => $routeData,
              'viewModel' => $viewModel,
              'flash' => $this->flash,
              'currentLang' =>  $this->postService->currentLang,
              'languages' => $this->postService->languages
        ]);
    }
}
