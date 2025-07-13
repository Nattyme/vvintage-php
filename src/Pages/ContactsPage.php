<?php
declare(strict_types=1);

namespace Vvintage\Pages;

final class ContactsPage 
{
  public function renderPage()
  {
    $pageTitle = "Контакты";

    // Хлебные крошки
    $breadcrumbs = [
      ['title' => $pageTitle, 'url' => '#'],
    ];

    // Шаблон страницы
    include ROOT . 'templates/_page-parts/_head.tpl';
    include ROOT . 'templates/_parts/_header.tpl';

    include ROOT . 'templates/contacts/contacts.tpl';

    include ROOT . 'templates/_parts/_footer.tpl';
    include ROOT . 'templates/_page-parts/_foot.tpl';
  }
}