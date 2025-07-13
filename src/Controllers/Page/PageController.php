<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Pages;

use Vvintage\Repositories\Page\PageRepository;
use Vvintage\Services\Page\PageService;

final class PageController
{
  public function show($slug)
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

    include ROOT . 'views/pages/contacts/index.tpl';
  }
}