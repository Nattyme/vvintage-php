<?php 
// Подключаем readbean
use RedBeanPHP\R;

require_once ROOT . "./libs/functions.php";

//Одиночный пост, показываем отдельную страницу блога
$sqlQuery = 'SELECT
                posts.id, 
                posts.title, 
                posts.description, 
                posts.content, 
                posts.cover, 
                posts.views, 
                posts.timestamp, 
                posts.edit_time, 
                posts.cat,
                categories.title AS cat_title
             FROM `posts`
             LEFT JOIN `categories` ON posts.cat = categories.id
             WHERE posts.id = ? LIMIT 1';

$post = R::getRow($sqlQuery, [$uriGet]);

if (!$post) {
  header('Location: ' . HOST . 'blog');
  exit();
};

// Кнопки назад и вперед
$postsId = R::getCol('SELECT id FROM posts');
foreach ($postsId as $index => $value) {
  if ( $post['id'] == $value ) {
    $prevId = array_key_exists($index + 1, $postsId) ? $postsId[$index + 1] : NULL;
    $nextId = array_key_exists($index - 1, $postsId) ? $postsId[$index - 1] : NULL;
  }
}

// Комментарии
$sqlQueryComments = 'SELECT 
                        comments.text, comments.user, comments.timestamp,
                        users.id, users.name, users.surname, users.avatar_small
                     FROM `comments`
                     LEFT JOIN `users` ON comments.user = users.id
                     WHERE comments.post = ?';

// $comments = R::getAll( $sqlQueryComments, [$post['id']] );

// Вывод похожих постов
$relatedPosts = get_related_posts($post['title']);
$pageTitle = "Запись в блоге - {$post['title']}";

//Сохраняем код ниже в буфер
ob_start();
include ROOT . 'templates/blog/single.tpl';
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
