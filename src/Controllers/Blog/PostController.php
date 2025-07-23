<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Blog;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

use Vvintage\Repositories\PostRepository;
use Vvintage\Models\Blog\Post;
use Vvintage\Routing\RouteData;
use Vvintage\Services\Page\Breadcrumbs;
use Vvintage\Services\Blog\BlogService;


final class PostController extends BaseController
{
    private BlogService $blogService;
    private Breadcrumbs $breadcrumbsService;

    public function __construct(BlogService $blogService, Breadcrumbs $breadcrumbs)
    {
        parent::__construct(); // Важно!
        $this->blogService = $blogService;
        $this->breadcrumbsService = $breadcrumbs;
    }

    private function getPost(RouteData $routeData)
    {
      $id = (int) $routeData->uriGet; // получаем id товара из URL
      return $this->blogService->getPost($id);
    }

    public function index(RouteData $routeData): void
    {   
        $post = $this->getPost($routeData);

        if (!$post) {
            http_response_code(404);
            echo 'Пост не найден';
            return;
        }

        // Получаем похожие посты
        $postsPerPage = $postsPerPage = (int)($this->settings['card_on_page_blog'] ?? 9);;
        $pagination = pagination($postsPerPage, 'posts');
        $relatedPosts = $this->blogService->getAll($pagination);
        // $relatedPosts = $post->getRelated();

        // Название страницы
        $pageTitle = $post->getTitle();

        // Хлебные крошки
        $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

        // Подключение шаблонов страницы
        $this->renderLayout('blog/post', [
              'pageTitle' => $pageTitle,
              'routeData' => $routeData,
              'breadcrumbs' => $breadcrumbs,
              'post' => $post,
              'relatedPosts' => $relatedPosts
        ]);
    }
}
