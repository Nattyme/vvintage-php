<?php

require_once 'config.php';
require_once 'db.php';
require_once ROOT . './libs/functions.php';

$_SESSION['errors'] = array();
$_SESSION['success'] = array();

session_start();

require ROOT . 'modules/settings/settings.php';
require ROOT . 'modules/admin-panel/admin-panel.php';
// require ROOT . 'modules/navigation/navigation.php';
require ROOT . 'modules/cart/usercart.php';
// require ROOT . 'modules/favorite/userfavorite.php';

$uriModule = getModuleName();
$uriGet = getUriGet();
$uriGetParam = getUriGetParam();

/*****************************
            РОУТЕР
*****************************/
switch ($uriModule) {
  case '':
    require ROOT . 'modules/main/index.php';
    break;

  // ::::::::::::: USERS :::::::::::::::::::
  case 'login':
    require ROOT . 'modules/login/login.php';
    break;

  case 'registration':
    require ROOT . 'modules/login/registration.php';
    break;

  case 'logout':
    require ROOT . 'modules/login/logout.php';
    break;

  case 'lost-password':
    require ROOT . 'modules/login/lost-password.php';
    break;

  case 'set-new-password':
    require ROOT . 'modules/login/set-new-password.php';
    break;

  case 'profile':
    require ROOT . 'modules/profile/profile.php';
    break;

  case 'profile-edit':
    require ROOT . 'modules/profile/profile-edit.php';
    break;

  case 'profile-order':
    require ROOT . 'modules/profile/profile-order.php';
    break;

  // ::::::::::::: OTHER :::::::::::::::::::
  case 'main':
    require ROOT . 'modules/main/index.php';
    break;

  case 'contacts':
    require ROOT . 'modules/contacts/index.php';
    break;

  case 'about':
    require ROOT . 'modules/about/index.php';
    break;

  // ::::::::::::: SHOP :::::::::::::::::::
  case 'shop':
    if ( isset($uriGet) ) {
      require ROOT . 'modules/shop/product.php';
    } else {
      require ROOT . 'modules/shop/catalog.php';
    }
  break;

  // ::::::::::::: CART :::::::::::::::::::
  case 'cart':
    require ROOT . 'modules/cart/cart.php';
    break;
    
  case 'addtocart':
    require ROOT . 'modules/cart/addtocart.php';
    break;
  
  case 'removefromcart':
    require ROOT . 'modules/cart/remove.php';
    break;

  // ::::::::::::: ORDERS :::::::::::::::::::
  case 'neworder':
    require ROOT . 'modules/orders/new.php';
    break;

  case 'ordercreated':
    require ROOT . 'modules/orders/created.php';
    break;
}