<?php
  // Подключаем readbean
  use RedBeanPHP\R; 
  
  // Задаем название страницы и класс
  $pageTitle = "Все товары";
  $pageClass = "admin-page";

  // Устанавливаем пагинацию
  $pagination = pagination(4, 'products');

  $sqlQuery = 'SELECT
                  p.id, 
                  p.article, 
                  p.title, 
                  p.price, 
                  p.url, 
                  p.timestamp,
                  b.title AS brand, 
                  c.title AS category,
                  pi.filename AS cover
                  
              FROM `products` p
              LEFT JOIN `brands` b ON p.brand = b.id
              LEFT JOIN `categories` c ON p.category = c.id
              LEFT JOIN (
                SELECT product_id, filename
                FROM productimages 
                WHERE image_order = 1
              ) pi ON p.id = pi.product_id
              ORDER BY p.id DESC ' . $pagination["sql_page_limit"];

  $products = R::getAll($sqlQuery);

 
  ob_start();
  include ROOT . "admin/templates/shop/all.tpl";
  $content = ob_get_contents();
  ob_end_clean();

  //Шаблон страницы
  include ROOT . "admin/templates/template.tpl";
