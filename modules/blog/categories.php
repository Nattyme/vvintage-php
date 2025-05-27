<?php 
// Получаем категории
$category = R::load('categories', $uriGetParam);

foreach ($category as $currentCat) {
  if ( $currentCat === 0) {
    header('Location: ' . HOST . 'blog');
    exit();
  }
}

$pageTitle = "Категория: {$category['title']}";

// Подключаем пагинацию
$pagination = pagination($settings['card_on_page_blog'], 'posts', ['cat = ? ', [$uriGetParam]]);
$posts = R::findLike('posts', ['cat' => [$uriGetParam]], 'ORDER BY id DESC ' . $pagination['sql_page_limit']); 

// Подключение шаблонов страницы
include ROOT . "templates/page-parts/_head.tpl";
include ROOT . "templates/_parts/_header.tpl";

include ROOT . "templates/blog/all.tpl";

include ROOT . "templates/_parts/_footer.tpl";
include ROOT . "templates/page-parts/_foot.tpl";