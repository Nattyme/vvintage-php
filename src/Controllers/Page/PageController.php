<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Page;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;
use Vvintage\Routing\RouteData;

use Vvintage\Models\Page\Page;
use Vvintage\Services\Page\PageService;
// use Vvintage\Repositories\Page\PageRepository;
use Vvintage\Services\Page\Breadcrumbs;

class PageController extends BaseController
{
  private Page $pageModel;
  protected PageService $pageService;
  private Breadcrumbs $breadcrumbsService;

  public function __construct ()
  {
    parent::__construct(); // Важно!
    $this->pageService = new PageService($this->currentLang);
    $this->breadcrumbsService = new Breadcrumbs();
  }

  public function index(RouteData $routeData)
  { 
    $slug = $routeData->uriModule ?: 'main';  
 
    $pageModel = $this->pageService->getPageBySlug($slug);

    // получаем общие данные страницы 
    $this->setRouteData($routeData); // <-- передаём routeData
    $page = $pageModel->export();
    $fields = $pageModel->getFieldsAssoc();

    // Название страницы
    $pageTitle = $pageModel->getTitle();

    // Хлебные крошки
    $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

    // Общий рендер
    $this->renderLayout("pages/{$slug}/index", [
        'page' => $page,
        'routeData' => $routeData,
        'fields' => $fields,
        'navigation' => $this->pageService->getLocalePagesNavTitles(),
        'breadcrumbs' => $breadcrumbs,
        'pageTitle' => $pageTitle
    ]);
  }

}