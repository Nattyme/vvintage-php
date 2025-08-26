<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Page;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

use Vvintage\Models\Page\Page;
// use Vvintage\Repositories\Page\PageRepository;
use Vvintage\Services\Page\PageService;
use Vvintage\Services\Page\Breadcrumbs;

class PageController extends BaseController
{
  private Page $pageModel;
  private PageService $pageService;
  private Breadcrumbs $breadcrumbsService;

  public function __construct (Page $pageModel, PageService $pageService, Breadcrumbs $breadcrumbs)
  {
    parent::__construct(); // Важно!
    $this->pageModel = $pageModel;
    $this->pageService = $pageService;
    $this->breadcrumbsService = $breadcrumbs;
  }

  public function index($routeData)
  {
   
    if(!$this->pageModel) {
      http_response_code(404);
      echo "404 — Страница не найдена";
      return;
    }

    // получаем общие данные старницы 
    $this->setRouteData($routeData); // <-- передаём routeData
    $page = $this->pageModel->export();

    // Получаем данные полей страницы
    $fields = [];

    foreach($this->pageModel->getFields() as $field) {
      $fields[$field->getName()] = $field->getValue();
    }

    $slug = $this->pageModel->getSlug();
    
    // Название страницы
    $pageTitle = $this->pageModel->getTitle();

    // Хлебные крошки
    $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);
  
    // Общий рендер
    $this->renderLayout("pages/{$slug}/index", [
        'page' => $page,
        'routeData' => $routeData,
        'fields' => $fields,
        'breadcrumbs' => $breadcrumbs,
        'pageTitle' => $pageTitle
    ]);
  }

}