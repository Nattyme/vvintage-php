<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Home;

use RedBeanPHP\R; // Подключаем readbean
use Vvintage\Routing\Router;
use Vvintage\Routing\RouteData;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

/** Репозитории */
use Vvintage\Services\Category\CategoryService;
use Vvintage\Services\Product\ProductService;
use Vvintage\Services\Post\PostService;
use Vvintage\Services\Page\PageService;

use Vvintage\Models\Category\Category;
use Vvintage\Models\Blog\Post;

require_once ROOT . './libs/functions.php';

final class HomeController extends BaseController
{
    private CategoryService $categoryService;
    private ProductService $productService;
    private PostService $postService;
    private PageService $pageService;


    public function __construct(
    )
    {
      parent::__construct(); // Важно!
      $this->categoryService = new CategoryService($this->languages, $this->currentLang);
      $this->productService = new ProductService($this->currentLang);
      $this->pageService = new PageService($this->currentLang);
      $this->postService = new PostService($this->languages, $this->currentLang);
    }

    private function renderPage (RouteData $routeData, $categories, $products, $posts): void 
    {  
      // Название страницы
      $pageTitle = 'Vvintage - интернет магазин. Главная страница';

      // Подключение шаблонов страницы
      $this->renderLayout('main/index', [
            'categories' => $categories,
            'products' => $products,
            'posts' => $posts,
            'pageTitle' => $pageTitle,
            'routeData' => $routeData
      ]);
    }


    public function index(RouteData $routeData): void
    {
      $this->setRouteData($routeData); // <-- передаём routeData

      // Получим категории, продукты и посты
      $categories = $this->categoryService->getMainCategories();
      $pagesTitles = $this->pageService->getPagesTitle();
      dd($pagesTitles);
      $products = $this->productService->getLastProducts(4);
      $posts = $this->postService->getLastPosts(3);
 
      // Показываем страницу
      $this->renderPage($routeData, $categories, $products, $posts);
    }




    private function getNewPosts(): array
    {
      $postsAtHome = 4;
      // ЗДЕСБ ВЫЗЫВАТЬ СЕРВИС  постов
      $repository = new PostRepository();
      $pagination = pagination($postsAtHome, 'posts');

      return $repository->getAllPosts($pagination);
    }

}
