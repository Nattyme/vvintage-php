<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Page;

use Vvintage\Repositories\Page\PageRepository;
use Vvintage\Services\Page\PageService;
use Vvintage\Models\Settings\Settings;

final class PageController
{
  public static function index($routeData, $slug)
  {
    $pageService = new PageService();
    $pageModel = $pageService->getPageBySlug($slug);

    if(!$pageModel) {
      http_response_code(404);
      echo "404 — Страница не найдена";
      return;
    }

    // Передаем данные  шаблон
    $page = $pageModel->export();
    $fields = [];

    foreach($pageModel->getFields() as $field) {
      $fields[$field->getName()] = $field->getValue();
    }

    // Получаем массив всех настроек
    $settings = Settings::all();

    // Хлебные крошки
    $breadcrumbs = [
      ['title' => $pageModel->getTitle(), 'url' => '#'],
    ];

      // Шаблон страницы
    include ROOT . 'views/_page-parts/_head.tpl';
    include ROOT . 'views/_parts/_header.tpl';

    include ROOT . 'views/pages/' . $slug . '/index.tpl';

    include ROOT . 'views/_parts/_footer.tpl';
    include ROOT . 'views/_page-parts/_foot.tpl';

  }

}