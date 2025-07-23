<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Blog;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

use Vvintage\Repositories\PostRepository;
use Vvintage\Models\Blog\Post;
use Vvintage\Routing\RouteData;
use Vvintage\Services\Page\Breadcrumbs;


final class PostController extends BaseController
{
    private Breadcrumbs $breadcrumbsService;

    public function __construct(Breadcrumbs $breadcrumbs)
    {
        parent::__construct(); // Важно!
        $this->breadcrumbsService = $breadcrumbs;
    }

    public function index(RouteData $routeData): void
    {   
      dd('одиночный пост');
        $id = (int) $routeData->uriGet; // получаем id товара из URL
        $post = PostRepository::findById($id);

        if (!$post) {
            http_response_code(404);
            echo 'Пост не найден';
            return;
        }

        $relatedPosts = $post->getRelated();

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
              'relatedProducts' => $relatedProducts,
              'content' => $content
        ]);
    }
}
