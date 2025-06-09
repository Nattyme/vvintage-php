<?php 
$pageTitle = "Блог - все записи";
$pagination = pagination(4, 'posts');
// $pagination = pagination($settings[5], 'posts');

// Делаем запрос в БД для получения постов
// $posts = R::find('posts', "ORDER BY id DESC");
$posts = R::find('posts', "ORDER BY id DESC {$pagination['sql_page_limit']}");

// Вывод похожих постов
// $relatedPosts = get_related_posts($post['title']);
$relatedPosts = $posts;

//Сохраняем код ниже в буфер
ob_start();
include ROOT . 'templates/blog/all.tpl';
//Записываем вывод из буфера в пепеменную
$content = ob_get_contents();
//Окончание буфера, очищаем вывод
ob_end_clean();

// Подключение шаблонов страницы
include ROOT . "templates/_page-parts/_head.tpl";
include ROOT . "templates/_parts/_header.tpl";

include ROOT . 'templates/blog/template.tpl';

include ROOT . "templates/_parts/_footer.tpl";
include ROOT . "templates/_page-parts/_foot.tpl";