<?php
  namespace Vvintage\Routing;

  use Vvintage\Routing\RouteData;

  /**  Сервисы */
  use Vvintage\Services\Messages\FlashMessage;
  use Vvintage\Services\Auth\SessionManager;

  /** Контроллеры */
  use Vvintage\Controllers\Auth\AuthController;
  use Vvintage\Controllers\Cart\CartController;

  /** Модели */
  use Vvintage\Models\Cart\Cart;

  /** Хранилища */
  use Vvintage\Store\Cart\GuestCartStore;
  use Vvintage\Store\Cart\UserCartStore;

  /** Интерфейсы */
  use Vvintage\Models\User\UserInterface;
  use Vvintage\Store\Cart\CartStoreInterface;


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

        case 'favorites':
        case 'addtofav':
        case 'removefromfav':
          self::routeFav($routeData);
          break;
        
        case 'neworder':
        case 'ordercreated':
          self::routeOrders($routeData);
          break;

        case 'contacts':
          self::routePages($routeData);
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
      $controller  = new AuthController( new FlashMessage());

      switch ($routeData->uriModule) {
        case 'login':
          $controller->login($routeData);
          break;

        case 'registration':
          $controller->register($routeData);
          break;

        case 'logout':
          $controller->logout($routeData);
          break;

        case 'lost-password':
          $controller->resetPassword($routeData);
          break;

        case 'set-new-password':
          $controller->setNewPassword($routeData);
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
      /**
       * Получаем модель пользователя - гость или залогиненный
       * @var UserInreface $userModel
      */
      $userModel = SessionManager::getLoggedInUser();

      // Получаем корзину и ее модель
      $cartModel = $userModel->getCartModel();
      $cart = $userModel->getCart();

      /**
       * Получаем хранилище
       * @var CartStoreInterface $cartStore;
       */
      $cartStore = ($userModel instanceof User) 
                    ? new UserCartStore( new UserRepository() ) 
                    : new GuestCartStore();

      $notes = new FlashMessage();



      $controller  = new CartController( $userModel, $cartModel, $cart, $cartStore, $notes );

      switch ($routeData->uriModule) {
        case 'cart':
          $controller->index($routeData);
          break;
        case 'addtocart':
          $controller->addItem((int) $_GET['id'], $routeData);
          break;
        case 'removefromcart':
          $controller->removeItem((int) $_GET['id'], $routeData);
          break;
      }
    }

    private static function routeFav(RouteData $routeData) {
      switch ($routeData->uriModule) {
        case 'favorites':
          \Vvintage\Controllers\Favorites\FavoritesController::index($routeData);
          break;
        case 'addtofav':
          \Vvintage\Controllers\Favorites\FavoritesController::addItem((int) $_GET['id'], $routeData);
          break;
        case 'removefromfav':
          \Vvintage\Controllers\Favorites\FavoritesController::removeItem((int) $_GET['id'], $routeData);
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

    /*************************/
    /******** PAGES *********/
    /**********************/
    private static function routePages(RouteData $routeData)
    {
      switch ($routeData->uriModule) {
        case 'contacts':
          \Vvintage\Controllers\Page\PageController::index($routeData, $routeData->uriModule);
          break;
          
        case 'contacts':
          \Vvintage\Controllers\Page\PageController::index($routeData, $routeData->uriModule);
          break;
      }
    }
  }