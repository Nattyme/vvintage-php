<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Pages;

use Vvintage\Repositories\PageRepository;

final class PageController
{
  public function show($slug)
  {
    $page = PageRepository::getBySLug($slug);

    if(!$page) {
      http_response_code(404);
      echo "404 — Страница не найдена";
      return;
    }

    // Передаем данные  шаблон
  }
}