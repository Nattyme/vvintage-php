<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Page;

/** Базовый контроллер страниц*/
use Vvintage\Routing\RouteData;
use Vvintage\Controllers\Base\BaseController;

use Vvintage\Models\Page\Page;

use Vvintage\Services\Validation\ContactFormValidation;

/** Сервисы */
use Vvintage\Services\SEO\SeoService;
use Vvintage\Services\Post\PostService;
use Vvintage\Services\Page\PageService;
use Vvintage\Services\Page\Breadcrumbs;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Product\ProductService;
use Vvintage\Services\Messages\MessageService;
use Vvintage\Services\Category\CategoryService;
use Vvintage\Services\Session\SessionService;
use Vvintage\Services\AdminPanel\AdminPanelService;


class PageController extends BaseController
{
  public function __construct (
    protected CategoryService $categoryService,
    protected ProductService $productService,
    protected PostService $postService,
    protected SessionService $sessionService, 
    protected AdminPanelService $adminPanelService,
    private PageService $pageService, 
    private Breadcrumbs $breadcrumbsService, 
    private FlashMessage $flash, 
    private SeoService $seoService
  )
  {
    parent::__construct($sessionService, $adminPanelService); // Важно!
  }

  public function index(RouteData $routeData): void
  { 
    $slug = $routeData->uriModule ?: 'main';  

    // получаем общие данные страницы 
    $this->setRouteData($routeData); // <-- передаём routeData

    // Название страницы
    $page = $this->pageService->getPageBySlug($slug);
    $pageModel = $this->pageService->getPageModelBySlug( $slug );
    $seo = $this->seoService->getSeoForPage('about', $pageModel);

    // Название страницы
    $pageTitle = $seo->title;

    // Хлебные крошки
    $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
      $csrfToken = $_POST['csrf'] ?? '';

      if (!$csrfToken) {
        $this->flash->pushSuccess('Неверный токен безопасности');
        $this->redirect('contacts');
      }

    
      $result = ContactFormValidation::validate($_POST);

      // Если есть ошибки - пройдём по массиву и покажем.
      if(!empty($result['errors'])) {
        $this->renderErrors($result['errors']);
        $this->redirect('contacts');
      }

      $service = new MessageService();
      $saved = $service->createMessage($result['data']);

      if ($saved) {
          $this->flash->pushSuccess('Сообщение успешно отправлено. Мы свяжемся с вами в ближайшее время');
          $this->redirect('contacts');
      } else {
          $this->flash->pushError('Не отправить сообщение. Проверьте данные и попробуйте ещё раз.');
          $this->redirect('contacts');
      }
    }


   
    // Общий рендер
    $this->renderLayout("pages/{$slug}/index", [
        'seo' => $seo,
        'page' => $page,
        'routeData' => $routeData,
        'fields' => $page['fields'],
        'navigation' => $this->pageService->getLocalePagesNavTitles(),
        'breadcrumbs' => $breadcrumbs,
        'pageTitle' => $pageTitle,
        'currentLang' => $this->pageService->currentLang,
        'languages' => $this->pageService->languages
    ]);
  }



  public function home(RouteData $routeData): void
  {
      $slug = $routeData->uriModule ?: 'main';  
      $this->setRouteData($routeData); // <-- передаём routeData
  
      // Получим категории, продукты и посты
      $categories = $this->categoryService->getMainCategories();

      $products = $this->productService->getLastProducts(4);
      $posts = $this->postService->getLastPosts(4);

      $page = $this->pageService->getPageBySlug($slug);
      $pageModel = $this->pageService->getPageModelBySlug( $slug );

      // Название страницы
      $pageTitle = $page['title'];

      // Хлебные крошки
      $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);
      $seo = $this->seoService->getSeoForPage('home', $pageModel);


      // Показываем страницу
      $this->renderLayout("pages/{$slug}/index", [
        'seo' => $seo,
        'page' => $page,
        'routeData' => $routeData,
        'categories' => $categories,
        'products' => $products,
        'posts' => $posts,
        'fields' => $page['fields'],
        'navigation' => $this->pageService->getLocalePagesNavTitles(),
        'breadcrumbs' => $breadcrumbs,
        'pageTitle' => $pageTitle,
        'currentLang' => $this->pageService->currentLang,
        'languages' => $this->pageService->languages
      ]);
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


  private function renderErrors(array $errors): void
  {
      foreach ($errors as $fields) {
        foreach ($fields as $index => $value) {
              $this->flash->pushError("Ошибка: ", $value );
        }
      }
  
      return;
  }

}