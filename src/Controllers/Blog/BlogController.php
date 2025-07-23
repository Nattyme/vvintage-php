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
    private BlogService $blogService;
    private FlashMessage $notes;
    private Breadcrumbs $breadcrumbsService;

    public function __construct(
        BlogService $blogService,
        FlashMessage $notes,
        Breadcrumbs $breadcrumbs
    ) {
        parent::__construct(); // Важно!
        $this->blogService = $blogService;
        $this->notes = $notes;
        $this->breadcrumbsService = $breadcrumbs;
    }

    public function index(RouteData $routeData): void
    {
        $pageTitle = 'Блог';
        $postsPerPage = 9;

        $pagination = pagination($postsPerPage, 'posts');
        $posts = $this->blogService->getAll($pagination);
        $totalPosts = $this->blogService->getTotalCount();

        $shownPosts = (($pagination['page_number'] - 1) * $postsPerPage) + count($posts);
        $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

        // Вывод похожих постов
        // $relatedPosts = get_related_posts($post->getTitle());
        $relatedPosts = $posts;

        //Сохраняем код ниже в буфер
        ob_start();
        include ROOT . 'views/blog/blog.tpl';
        //Записываем вывод из буфера в пепеменную
        $content = ob_get_contents();
        //Окончание буфера, очищаем вывод
        ob_end_clean();
        
        $this->renderLayout('blog/template', [
            'pagination' => $pagination,
            'pageTitle' => $pageTitle,
            'routeData' => $routeData,
            'breadcrumbs' => $breadcrumbs,
            'posts' => $posts,
            'totalPosts' => $totalPosts,
            'shownPosts' => $shownPosts,
            'content' => $content,
            'relatedPosts' => $relatedPosts
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
