<?php
  namespace Vvintage\Routing;

  use Vvintage\Routing\RouteData;

  /**  Сервисы */
  use Vvintage\Services\Auth\SessionManager;
  use Vvintage\Services\Page\PageService;
  use Vvintage\Services\Cart\CartService;
  use Vvintage\Services\Favorites\FavoritesService;
  use Vvintage\Services\Messages\FlashMessage;
  use Vvintage\Services\Validation\LoginValidator;


  /** Контроллеры */
  use Vvintage\Controllers\Auth\AuthController;
  use Vvintage\Controllers\Page\PageController;
  use Vvintage\Controllers\Cart\CartController;
  use Vvintage\Controllers\Favorites\FavoritesController;
  use Vvintage\Controllers\Security\RegistrationController;
  use Vvintage\Controllers\Security\PasswordResetController;
  use Vvintage\Controllers\Security\PasswordSetNewController;
  use Vvintage\Services\Security\PasswordSetNewService;

  /** Модели */
  use Vvintage\Models\User\User;
  use Vvintage\Models\Cart\Cart;
  use Vvintage\Models\Favorites\Favorites;

  /** Хранилища */
  use Vvintage\Store\Cart\UserCartStore;
  use Vvintage\Store\Favorites\UserFavoritesStore;
  use Vvintage\Store\Cart\GuestCartStore;
  use Vvintage\Store\Favorites\GuestFavoritesStore;

  /** Интерфейсы */
  use Vvintage\Models\User\UserInterface;
  use Vvintage\Store\Cart\CartStoreInterface;
  use Vvintage\Store\Favorites\FavoritesStoreInterface;

  /** Репозитории */
  use Vvintage\Repositories\UserRepository;
  use Vvintage\Repositories\ProductRepository;

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
      $userRepository = new UserRepository();
      $cartService = new CartService();
      $favService = new FavoritesService();
      $setNewPassService = new PasswordSetNewService($userRepository);

      $notes = new FlashMessage();
      $validator = new LoginValidator($userRepository,  $notes);

      $controller = new AuthController( $userRepository, $cartService, $favService, $notes, $validator);
      $regController = new RegistrationController($notes);
      $setNewPassController = new PasswordSetNewController( $setNewPassService, $notes );
      $resetController = new PasswordResetController($notes);
   
      switch ($routeData->uriModule) {
        case 'login':
          $controller->login($routeData);
          break;

        case 'registration':
          $controller->register($regController, $routeData);
          break;

        case 'logout':
          $controller->logout($routeData);
          break;

        case 'lost-password':
          $controller->resetPassword($resetController, $routeData);
          break;

        case 'set-new-password':
          $controller->setNewPassword( $setNewPassController, $routeData);
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
      $notes = new FlashMessage();

      // Получаем корзину и ее модель
      $cartModel = $userModel->getCartModel();
      $cart = $userModel->getCart();

      $productRepository = new ProductRepository();

      /**
       * Получаем хранилище
       * @var CartStoreInterface $cartStore;
       */
      $cartStore = ($userModel instanceof User) 
                    ? new UserCartStore( new UserRepository() ) 
                    : new GuestCartStore();

      $cartService = new CartService($userModel, $cartModel, $cart, $cartStore, $productRepository, $notes);

      $controller  = new CartController( $cartService, $userModel, $cartModel, $cart, $cartStore, $notes );

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
      $notes = new FlashMessage();

      /**
       * Получаем модель пользователя - гость или залогиненный
       * @var UserInreface $userModel
      */
      $userModel = SessionManager::getLoggedInUser();

      // Получаем корзину и ее модель
      $favModel = $userModel->getFavModel();
      $fav = $userModel->getFavList();

      /**
       * Получаем хранилище
       * @var FavoritesStoreInterface $cartStore;
      */
      $favStore = ($userModel instanceof User) 
                    ? new UserFavoritesStore( new UserRepository() ) 
                    : new GuestFavoritesStore();

                    $controller  = new FavoritesController($userModel, $favModel, $fav, $favStore, $notes);

      switch ($routeData->uriModule) {
        case 'favorites':
          $controller->index($routeData);
          break;
        case 'addtofav':
          $controller->addItem((int) $_GET['id'], $routeData);
          break;
        case 'removefromfav':
          $controller->removeItem((int) $_GET['id'], $routeData);
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
      $pageService = new PageService();
      $pageModel = $pageService->getPageBySlug($routeData->uriModule);

      $controller = new PageController($pageModel, $pageService);

      switch ($routeData->uriModule) {
        case 'contacts':
          $controller->index($routeData);
          break;
        
      }
    }
  }