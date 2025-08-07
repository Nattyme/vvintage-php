<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Blog;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

// use Vvintage\Repositories\Post\PostRepository;
use Vvintage\Models\Post\Post;
use Vvintage\Routing\RouteData;
use Vvintage\Services\Page\Breadcrumbs;
use Vvintage\Services\Post\PostService;
use Vvintage\Services\Messages\FlashMessage;


final class PostController extends BaseController
{
    private FlashMessage $notes;
    private Breadcrumbs $breadcrumbsService;
    private PostService $postService;

    public function __construct(FlashMessage $notes, Breadcrumbs $breadcrumbs)
    {
        parent::__construct(); // Важно!
        $this->notes = $notes;
        $this->breadcrumbsService = $breadcrumbs;
        $this->postService = new PostService( $this->currentLang );
    }


    public function index(RouteData $routeData): void
    {   
    
        $this->setRouteData($routeData); // <-- передаём routeData

        $id = (int) $routeData->uriGet; // получаем id плста из URL

        $post = $this->postService->getPost($id);

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

        // Название страницы
        $pageTitle = $post->getTitle();

        // Хлебные крошки
        $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

        // Формируем единую модель для передачи в шаблон
        $postViewModel = [
            'mainCategories' => $mainCategories,
            'subCategories' => $subCategories,
            'breadcrumbs' => $breadcrumbs
        ];

        // Подключение шаблонов страницы
        $this->renderLayout('blog/post', [
              'post' => $post,
              'pageTitle' => $pageTitle,
              'routeData' => $routeData,
              'postViewModel' => $postViewModel,
        ]);
    }
}
