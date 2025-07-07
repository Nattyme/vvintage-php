<?php
  namespace Vvintage\Routing;

  use Vvintage\Routing\RouteData;

  class Router {
     /*****************************
            РОУТЕР
    *****************************/
    public static function route(RouteData $routeData) {
 
      switch ($routeData->uriModule) {
        case '':
        case 'main':
          require ROOT . 'modules/admin-panel/admin-panel.php';
          require ROOT . 'modules/main/index.php';
          break;

        // ::::::::::::: USERS :::::::::::::::::::
        case 'login':
        case 'registration':
        case 'logout':
        case 'lost-password':
        case 'set-new-password':
          self::routeAuth($routeData);
          break;

        case 'profile':
        case 'profile-edit':
        case 'profile-order':
          self::routeProfile($routeData);
          break;

        case 'shop':
          self::routeShop($routeData);
          break;
        
        case 'blog':
        case 'add-comment':
          self::routeBlog($routeData);
          break;

        case 'cart':
        case 'addtocart':
        case 'removefromcart':
          self::routeCart($routeData);
          break;
        
        case 'neworder':
        case 'ordercreated':
          self::routeOrders($routeData);
          break;

        case 'contacts':
          require ROOT . 'modules/contacts/index.php';
          break;

        case 'about':
          require ROOT . 'modules/about/index.php';
          break;

        default:
          http_response_code(404);
          require ROOT . 'modules/404/404.php';
          break;
      }
  
    }
    /*****************************
              // РОУТЕР 
    *****************************/




    private static function routeAuth(RouteData $routeData) {
      switch ($routeData->uriModule) {
        case 'login':
          \Vvintage\Controllers\Auth\AuthController::login($routeData);
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
      }
    }

    private static function routeProfile(RouteData $routeData) {
      switch ($routeData->uriModule) {
        case 'profile':
          require ROOT . 'modules/profile/profile.php';
          break;

        case 'profile-edit':
          require ROOT . 'modules/profile/profile-edit.php';
          break;

        case 'profile-order':
          require ROOT . 'modules/profile/profile-order.php';
          break;
      }
    }

    // ::::::::::::: SHOP :::::::::::::::::::
    private static function routeShop(RouteData $routeData) {
      if ( isset($routeData->uriGet) && $routeData->uriGet === 'cat' && !empty($routeData->uriGetParam) ) {
        require ROOT . 'modules/shop/categories.php';
      } else if ( isset($routeData->uriGet) && $routeData->uriGet === 'brand' && !empty($routeData->uriGetParam) ) {
        require ROOT . 'modules/shop/brands.php';
      } else if ( isset($routeData->uriGet) && $routeData->uriGet === 'subcat' && !empty($routeData->uriGetParam)) {
        require ROOT . 'modules/shop/subcat.php';
      } else if ( isset($routeData->uriGet) && $routeData->uriGet !== 'cat' && $routeData->uriGet !== 'subcat') {
        \Vvintage\Controllers\Shop\ProductController::index($routeData);
      } else if (isset($routeData->uriGet) && $routeData->uriGet === 'shop') {
        \Vvintage\Controllers\Shop\CatalogController::index($routeData);
      }
      else {
        \Vvintage\Controllers\Shop\CatalogController::index($routeData);
      }
    }

    private static function routeBlog(RouteData $routeData) {
        if ($routeData->uriModule === 'add-comment') {
          require ROOT . 'modules/blog/add-comment.php';
        } elseif ($routeData->uriGet === 'cat' && !empty($routeData->uriGetParam)) {
          require ROOT . 'modules/blog/categories.php';
        } elseif (!empty($routeData->uriGet)) {
          require ROOT . 'modules/blog/single.php';
        } else {
          require ROOT . 'modules/blog/all.php';
        }
    }

    private static function routeCart(RouteData $routeData) {
      switch ($routeData->uriModule) {
        case 'cart':
          \Vvintage\Controllers\Cart\CartController::index($routeData);
          break;
        case 'addtocart':
          \Vvintage\Controllers\Cart\CartController::addItem($_GET['id'], $routeData);
          break;
        case 'removefromcart':
          \Vvintage\Controllers\Cart\CartController::removeItem($routeData);
          break;
      }
    }

    private static function routeOrders(RouteData $routeData) {
      switch ($routeData->uriModule) {
        case 'neworder':
          require ROOT . 'modules/orders/new.php';
          break;
        case 'ordercreated':
          require ROOT . 'modules/orders/created.php';
          break;
      }
    }
  }