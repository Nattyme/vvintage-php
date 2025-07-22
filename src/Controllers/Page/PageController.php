<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Page;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

use Vvintage\Models\Page\Page;
use Vvintage\Models\Settings\Settings;
use Vvintage\Repositories\Page\PageRepository;
use Vvintage\Services\Page\PageService;

final class PageController extends BaseController
{
  private Page $pageModel;
  private PageService $pageService;

  public function __construct (Page $pageModel, PageService $pageService)
  {
    $this->pageModel = $pageModel;
    $this->pageService = $pageService;
  }

  public function index($routeData)
  {
    if(!$this->pageModel) {
      http_response_code(404);
      echo "404 — Страница не найдена";
      return;
    }

    // Передаем данные  шаблон
    $page = $this->pageModel->export();
    $fields = [];

    foreach($this->pageModel->getFields() as $field) {
      $fields[$field->getName()] = $field->getValue();
    }

    // Получаем массив всех настроек
    $settings = Settings::all();

    // Хлебные крошки
    $breadcrumbs = [
      ['title' => $this->pageModel->getTitle(), 'url' => '#'],
    ];

    $slug = $this->pageModel->getSlug();
    $pageTitle = $this->pageModel->getTitle();

    // Общий рендер
    $this->renderLayout("pages/{$slug}/index", [
        'page' => $page,
        'fields' => $fields,
        'settings' => $settings,
        'breadcrumbs' => $breadcrumbs,
        'pageTitle' => $pageTitle
    ]);

    // Шаблон страницы
    // ob_start();
    // include ROOT . 'views/pages/' . $slug . '/index.tpl';
    // $content = ob_get_clean();
    

    // include ROOT . 'views/layout.php';
  }

}