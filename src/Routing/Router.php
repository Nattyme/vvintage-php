<?php
  namespace Vvintage\Routing;

  use Vvintage\Routing\RouteData;

  class Router {
     /*****************************
            РОУТЕР
    *****************************/
    public static function route(RouteData $data) {
 
      switch ($data->uriModule) {
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
          self::routeAuth($data);
          break;

        case 'profile':
        case 'profile-edit':
        case 'profile-order':
          self::routeProfile($data);
          break;

        case 'shop':
          self::routeShop($data);
          break;
        
        case 'blog':
        case 'add-comment':
          self::routeBlog($data);
          break;

        case 'cart':
        case 'addtocart':
        case 'removefromcart':
          self::routeCart($data);
          break;
        
        case 'neworder':
        case 'ordercreated':
          self::routeOrders($data);
          break;

        case 'contacts':
          require ROOT . 'modules/contacts/index.php';
          break;

        case 'about':
          require ROOT . 'modules/about/index.php';
          break;

        default:
          http_response_code(404);
          // require ROOT . 'modules/errors/404.php';
          break;
      }
  
    }
    /*****************************
              // РОУТЕР 
    *****************************/




    private static function routeAuth(RouteData $data) {
      switch ($data->uriModule) {
        case 'login':
          \Vvintage\Controllers\Auth\AuthController::login($data);
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

    private static function routeProfile(RouteData $data) {
      switch ($data->uriModule) {
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
    private static function routeShop(RouteData $data) {
      if ( isset($data->uriGet) && $data->uriGet === 'cat' && !empty($data->uriGetParam) ) {
        require ROOT . 'modules/shop/categories.php';
      } else if ( isset($data->uriGet) && $data->uriGet === 'brand' && !empty($data->uriGetParam) ) {
        require ROOT . 'modules/shop/brands.php';
      } else if ( isset($data->uriGet) && $data->uriGet === 'subcat' && !empty($data->uriGetParam)) {
        require ROOT . 'modules/shop/subcat.php';
      } else if ( isset($data->uriGet) && $data->uriGet !== 'cat' && $data->uriGet !== 'subcat') {
        \Vvintage\Controllers\Shop\ProductController::index($data);
      } else if (isset($data->uriGet) && $data->uriGet === 'shop') {
        \Vvintage\Controllers\Shop\CatalogController::index($data);
      }
      else {
        \Vvintage\Controllers\Shop\CatalogController::index($data);
      }
    }

    private static function routeBlog(RouteData $data) {
        if ($data->uriModule === 'add-comment') {
          require ROOT . 'modules/blog/add-comment.php';
        } elseif ($data->uriGet === 'cat' && !empty($data->uriGetParam)) {
          require ROOT . 'modules/blog/categories.php';
        } elseif (!empty($data->uriGet)) {
          require ROOT . 'modules/blog/single.php';
        } else {
          require ROOT . 'modules/blog/all.php';
        }
    }

    private static function routeCart(RouteData $data) {
      switch ($data->uriModule) {
        case 'cart':
          \Vvintage\Controllers\Cart\CartController::index($data);
          break;
        case 'addtocart':
          \Vvintage\Controllers\Cart\CartController::addItem($_GET['id'], $data);
          break;
        case 'removefromcart':
          \Vvintage\Controllers\Cart\CartController::removeItem($data);
          break;
      }
    }

    private static function routeOrders(RouteData $data) {
      switch ($data->uriModule) {
        case 'neworder':
          require ROOT . 'modules/orders/new.php';
          break;
        case 'ordercreated':
          require ROOT . 'modules/orders/created.php';
          break;
      }
    }
  }