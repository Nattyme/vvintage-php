<?php
use Vvintage\Config\Config;
use Vvintage\Database\Database;

// Подключаем  компилятор composer
require_once __DIR__ . '/../vendor/autoload.php';


// Определяем константы 
define('ROOT', Config::getRoot());
define('HOST', Config::getHost());

require_once ROOT . "libs/resize-and-crop.php";
require_once ROOT . "libs/functions.php";

$_SESSION['errors'] = array();
$_SESSION['success'] = array();

// Старт сессии
session_start();

//Обязательно подключение БД:
Database::connect(); // <-- Вызов подключения

// Проверка на права доступа
if ( !(isset($_SESSION['role']) && $_SESSION['role'] === 'admin')) {
  header('Location: ' . HOST . 'login');
} 

/* ................................................
                  РОУТЕР - МАРШРУТ
................................................ */
$uriModule = getModuleNameForAdmin();
switch ($uriModule) {
  case '':
    require ROOT . "admin/modules/main/index.php";
    break;


  // ::::::::::::: BLOG :::::::::::::::::::
  case 'blog':
    require ROOT . "admin/modules/blog/all.php";
    break;

  case 'post-new':
    require ROOT . "admin/modules/blog/new.php";
    break;

  case 'post-edit':
    require ROOT . "admin/modules/blog/edit.php";
    break;

  case 'post-delete':
    require ROOT . "admin/modules/blog/delete.php";
    break;


 // ::::::::::::: CATEGORIES :::::::::::::::::::
  case 'category':
    require ROOT . "admin/modules/categories/all.php";
    break;

  case 'category-new':
    require ROOT . "admin/modules/categories/new.php";
    break;

  case 'category-edit':
    require ROOT . "admin/modules/categories/edit.php";
    break;

  case 'category-delete':
    require ROOT . "admin/modules/categories/delete.php";
    break;


  // ::::::::::::: BRANDS :::::::::::::::::::
  case 'brand':
    require ROOT . "admin/modules/brands/all.php";
    break;

  case 'brand-new':
    require ROOT . "admin/modules/brands/new.php";
    break;

  case 'brand-edit':
    require ROOT . "admin/modules/brands/edit.php";
    break;

  case 'brand-delete':
    require ROOT . "admin/modules/brands/delete.php";
    break;

  // ::::::::::::: USERS :::::::::::::::::::
  case 'users':
    require ROOT . "admin/modules/users/all.php";
    break; 

  case 'user-edit':
    require ROOT . "admin/modules/users/edit.php";
    break; 

  case 'user-block':
    require ROOT . "admin/modules/users/block.php";
    break; 


  // ::::::::::::: SHOP :::::::::::::::::::
  case 'shop':
    require ROOT . "admin/modules/shop/all.php";
    break;

  case 'shop-new':
    require ROOT . "admin/modules/shop/new.php";
    break;

  case 'shop-edit':
    require ROOT . "admin/modules/shop/edit.php";
    break;

  case 'shop-delete':
    require ROOT . "admin/modules/shop/delete.php";
    break;


    // ::::::::::::: SHOP :::::::::::::::::::
    case 'orders':
      require ROOT . "admin/modules/orders/all.php";
      break;
  
    case 'order':
      require ROOT . "admin/modules/orders/single.php";
      break;
  
    case 'order-delete':
      require ROOT . "admin/modules/orders/delete.php";
      break;


  // ::::::::::::: CATEGORIES SHOP :::::::::::::::::::
  case 'category':
    require ROOT . "admin/modules/categories/all.php";
    break;

  case 'category-new':
    require ROOT . "admin/modules/categories/new.php";
    break;

  case 'category-edit':
    require ROOT . "admin/modules/categories/edit.php";
    break;

  case 'category-delete':
    require ROOT . "admin/modules/categories/delete.php";
    break;

    // ::::::::::::: CATEGORIES BLOG :::::::::::::::::::
  case 'category-blog':
    require ROOT . "admin/modules/categories-blog/all.php";
    break;

  case 'category-blog-new':
    require ROOT . "admin/modules/categories-blog/new.php";
    break;

  case 'category-blog-edit':
    require ROOT . "admin/modules/categories-blog/edit.php";
    break;

  case 'category-blog-delete':
    require ROOT . "admin/modules/categories-blog/delete.php";
    break;

   // ::::::::::::: MESSAGES :::::::::::::::::::

   case 'messages':
    require ROOT . "admin/modules/messages/all.php";
    break;

  case 'message':
    require ROOT . "admin/modules/messages/single.php";
    break;

  case 'message-delete':
    require ROOT . "admin/modules/messages/delete.php";
    break;

    
  // ::::::::::::: PAGES :::::::::::::::::::
  case 'main':
    require ROOT . "admin/modules/pages/main.php";
    break;

  case 'about':
  require ROOT . "admin/modules//pages/about.php";
    break;

  case 'delivery':
  require ROOT . "admin/modules//pages/delivery.php";
    break;

  case 'contacts':
    require ROOT . "admin/modules//pages/contacts.php";
    break;

  // ::::::::::::: OTHER :::::::::::::::::::
  case 'comments':
    require ROOT . "admin/modules/comments/all.php";
    break;

  case 'comment':
    require ROOT . "admin/modules/comments/single.php";
    break;

  // ::::::::::::: SETTINGS :::::::::::::::::::
  case 'settings':
    require ROOT . "admin/modules/settings/settings.php";
    break;

  case 'settings-main':
    require ROOT . "admin/modules/settings/settings-main.php";
    break;

  case 'settings-social':
    require ROOT . "admin/modules/settings/settings-social.php";
    break;

  case 'settings-cookies':
    require ROOT . "admin/modules/settings/settings-cookies.php";
    break;

  case 'settings-cards':
    require ROOT . "admin/modules/settings/settings-cards.php";
    break;
  // ::::::::::::: SETTINGS :::::::::::::::::::

  default: 
    require ROOT . "admin/modules/main/index.php";
    break;
}









