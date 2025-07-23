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

    private function renderPosts(RouteData $routeData)
    {
        $data = $this->prepareDataForRender($routeData);
        
        $this->renderLayout('blog/blog', [
            'pagination' => $data['pagination'],
            'pageTitle' => $data['pageTitle'],
            'routeData' => $data['routeData'],
            'breadcrumbs' => $data['breadcrumbs'],
            'posts' => $data['posts'],
            'totalPosts' => $data['totalPosts'],
            'shownPosts' => $data['shownPosts'],
            'relatedPosts' => $data['relatedPosts']
        ]);

    }

    /**
     * @return array{
     *   pagination: array,
     *   pageTitle: string,
     *   routeData: RouteData,
     *   breadcrumbs: array,
     *   posts: array,
     *   totalPosts: int,
     *   shownPosts: int,
     *   relatedPosts: array
     * }
     */
    private function prepareDataForRender(RouteData $routeData): array
    {
        $pageTitle = 'Блог';
        $postsPerPage = (int)($this->settings['card_on_page_blog'] ?? 9);
        $pagination = pagination($postsPerPage, 'posts');
        $posts = $this->blogService->getAll($pagination);
        $totalPosts = $this->blogService->getTotalCount();

        $shownPosts = (($pagination['page_number'] - 1) * $postsPerPage) + count($posts);
        $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

        // Вывод похожих постов
        // $relatedPosts = get_related_posts($post->getTitle());
        $relatedPosts = $posts;

        return [
            'pagination' => $pagination,
            'pageTitle' => $pageTitle,
            'routeData' => $routeData,
            'breadcrumbs' => $breadcrumbs,
            'posts' => $posts,
            'totalPosts' => $totalPosts,
            'shownPosts' => $shownPosts,
            'relatedPosts' => $relatedPosts
        ];
    }

    public function index(RouteData $routeData): void
    {
      $this->renderPosts($routeData);
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
