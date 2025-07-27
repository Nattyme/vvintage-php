<?php
include ROOT . 'views/_page-parts/_head.tpl';

if ($isAdminLoggedIn) {
    include ROOT . "views/_parts/_admin-panel.tpl";
}

include ROOT . 'views/_parts/_header.tpl';

echo $content;

include ROOT . 'views/_parts/_footer.tpl';
include ROOT . 'views/_page-parts/_foot.tpl';