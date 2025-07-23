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

    public function index(RouteData $routeData): void
    {   
        $id = (int) $routeData->uriGet; // получаем id товара из URL
        // $post = PostRepository::findById($id);
        $post = $this->blogService->getPost($id);

        if (!$post) {
            http_response_code(404);
            echo 'Пост не найден';
            return;
        }

        // Получаем похожие посты
        $postsPerPage = 9;
        $pagination = pagination($postsPerPage, 'posts');
        $relatedPosts = $this->blogService->getAll($pagination);
        // $relatedPosts = $post->getRelated();

        // Название страницы
        $pageTitle = $post->getTitle();

        // Хлебные крошки
        $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

         //Сохраняем код ниже в буфер
        ob_start();
        include ROOT . 'views/blog/post.tpl';
        //Записываем вывод из буфера в пепеменную
        $content = ob_get_contents();
        //Окончание буфера, очищаем вывод
        ob_end_clean();

        // Подключение шаблонов страницы
        $this->renderLayout('blog/template', [
              'pageTitle' => $pageTitle,
              'routeData' => $routeData,
              'breadcrumbs' => $breadcrumbs,
              'post' => $post,
              'relatedPosts' => $relatedPosts,
              'content' => $content
        ]);
    }
}
