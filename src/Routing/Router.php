<?php
  namespace Vvintage\Routing;

  use Vvintage\Routing\RouteData;

  /**  Сервисы */
  use Vvintage\Services\Auth\SessionManager;
  use Vvintage\Services\Messages\FlashMessage;
  use Vvintage\Services\Page\PageService;
  use Vvintage\Services\Validation\LoginValidator;
  use Vvintage\Services\Validation\NewOrderValidator;


  /** Контроллеры */
  use Vvintage\Controllers\Auth\AuthController;
  use Vvintage\Controllers\Page\PageController;
  use Vvintage\Controllers\Cart\CartController;
  use Vvintage\Controllers\Order\OrderController;
  use Vvintage\Controllers\Shop\CatalogController;
  use Vvintage\Controllers\Shop\ProductController;
  use Vvintage\Controllers\Blog\PostController;
  use Vvintage\Controllers\Blog\BlogController;
  use Vvintage\Controllers\Profile\ProfileController;
  use Vvintage\Controllers\Favorites\FavoritesController;
  use Vvintage\Controllers\Security\LoginController;
  use Vvintage\Controllers\Security\RegistrationController;
  use Vvintage\Controllers\Security\PasswordResetController;
  use Vvintage\Controllers\Security\PasswordSetNewController;

  /** Сервисы */
  use Vvintage\Services\Security\PasswordSetNewService;
  use Vvintage\Services\Cart\CartService;
  use Vvintage\Services\Favorites\FavoritesService;
  use Vvintage\Services\Order\OrderService;
  use Vvintage\Services\Blog\BlogService;
  use Vvintage\Services\Page\Breadcrumbs;


  /** Модели */
  use Vvintage\Models\User\User;
  use Vvintage\Models\User\GuestUser;
  use Vvintage\Models\Cart\Cart;
  use Vvintage\Models\Blog\Post;
  use Vvintage\Models\Favorites\Favorites;

  /** Хранилища */
  use Vvintage\Store\UserItemsList\GuestItemsListStore;
  use Vvintage\Store\UserItemsList\UserItemsListStore;

  /** Интерфейсы */
  use Vvintage\Models\User\UserInterface;
  use Vvintage\Store\Cart\CartStoreInterface;
  use Vvintage\Store\Favorites\FavoritesStoreInterface;

  /** Репозитории */
  use Vvintage\Repositories\UserRepository;
  use Vvintage\Repositories\ProductRepository;
  use Vvintage\Repositories\OrderRepository;
  use Vvintage\Repositories\PostRepository;


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
      $setNewPassService = new PasswordSetNewService($userRepository);

      // $cartModel = new Cart();
      // $favModel = new Favorites();

      $notes = new FlashMessage();
      $validator = new LoginValidator($userRepository, $notes);
      $productRepository = new ProductRepository();

      $loginController = new LoginController($userRepository, $productRepository, $notes);
      $regController = new RegistrationController($notes);
      $resetController = new PasswordResetController($notes);
      $setNewPassController = new PasswordSetNewController( $setNewPassService, $notes );

   
      switch ($routeData->uriModule) {
        case 'login':
          $loginController->index($routeData);
          break;

        case 'registration':
          $regController->index($routeData);
          break;

        case 'lost-password':
          $resetController->index($routeData);
          break;

        case 'set-new-password':
          $setNewPassController->index($routeData);
          break;
        
        case 'logout':
          SessionManager::logout();
          break;
      }
    }

    private static function routeProfile(RouteData $routeData) {
      $sessionManager = new SessionManager();
      $breadcrumbs = new Breadcrumbs();
      $notes = new FlashMessage();

      $profileController = new ProfileController($sessionManager, $breadcrumbs, $notes);

      switch ($routeData->uriModule) {
        case 'profile':
          $profileController->index($routeData);
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
      $breadcrumbs = new Breadcrumbs();
      $catalogController  = new CatalogController( $breadcrumbs );
      $productController = new ProductController( $breadcrumbs );

      if ( isset($routeData->uriGet) && $routeData->uriGet === 'cat' && !empty($routeData->uriGetParam) ) {
        require ROOT . 'modules/shop/categories.php';
      } else if ( isset($routeData->uriGet) && $routeData->uriGet === 'brand' && !empty($routeData->uriGetParam) ) {
        require ROOT . 'modules/shop/brands.php';
      } else if ( isset($routeData->uriGet) && $routeData->uriGet === 'subcat' && !empty($routeData->uriGetParam)) {
        require ROOT . 'modules/shop/subcat.php';
      } else if ( isset($routeData->uriGet) && $routeData->uriGet !== 'cat' && $routeData->uriGet !== 'subcat') {
        $productController->index($routeData);
      } else if (isset($routeData->uriGet) && $routeData->uriGet === 'shop') {
        $catalogController->index($routeData);
      }
      else {
        $catalogController->index($routeData);
      }
    }

    private static function routeBlog(RouteData $routeData) {
      $breadcrumbs = new Breadcrumbs();
      $notes = new FlashMessage();
      $postRepository = new PostRepository();
      $blogService = new BlogService( $postRepository );
  
      $blogController = new BlogController($blogService, $notes, $breadcrumbs);
      $postController = new PostController($blogService, $breadcrumbs);
    

        if ($routeData->uriModule === 'add-comment') {
          require ROOT . 'modules/blog/add-comment.php';
        } elseif ($routeData->uriGet === 'cat' && !empty($routeData->uriGetParam)) {
          require ROOT . 'modules/blog/categories.php';
        } elseif (!empty($routeData->uriGet)) {
          $postController->index($routeData);
        } else {
          $blogController->index($routeData);
        }
    }

    private static function routeCart(RouteData $routeData) {
      /**
       * Получаем модель пользователя - гость или залогиненный
       * @var UserInreface $userModel
      */
      $userModel = SessionManager::getLoggedInUser();
      $notes = new FlashMessage();
      $breadcrumbs = new Breadcrumbs();

      // Получаем корзину и ее модель
      $cartModel = $userModel->getCartModel();
      $cart = $userModel->getCart();

      $productRepository = new ProductRepository();

      /**
       * Получаем хранилище
       * @var CartStoreInterface $cartStore;
       */
      $cartStore = ($userModel instanceof User) 
                    ? new UserItemsListStore( new UserRepository() ) 
                    : new GuestItemsListStore();
      $cartService = new CartService($userModel, $cartModel, $cartModel->getItems(), $cartStore, $productRepository, $notes);

      $controller  = new CartController( $cartService, $userModel, $cartModel, $cart, $cartStore, $notes, $breadcrumbs );

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
      /**
       * Получаем модель пользователя - гость или залогиненный
       * @var UserInreface $userModel
      */
      $userModel = SessionManager::getLoggedInUser();
      $notes = new FlashMessage();
      $breadcrumbs = new Breadcrumbs();

      // Получаем избранное и ее модель
      $favModel = $userModel->getFavModel();
      $fav = $userModel->getFavList();

      $productRepository = new ProductRepository();

      /**
       * Получаем хранилище
       * @var FavoritesStoreInterface $cartStore;
      */
      $favStore = ($userModel instanceof User) 
                    ? new UserItemsListStore( new UserRepository() ) 
                    : new GuestItemsListStore();
                    
      $favService = new FavoritesService($userModel, $favModel, $favModel->getItems(), $favStore, $productRepository, $notes);
      $controller  = new FavoritesController( $favService, $userModel, $favModel, $fav, $favStore, $notes, $breadcrumbs );

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
      /**
       * Получаем модель пользователя - гость или залогиненный
       * @var UserInreface $userModel
      */
      $userModel = SessionManager::getLoggedInUser();

      // Если гость - перенаправляем на страницу входа
      if($userModel instanceof GuestUser) {
        header('Location: ' . HOST . 'login');
        exit();
      }

      $userRepository = $userModel->getRepository();
      $productRepository = new ProductRepository();
      $notes = new FlashMessage();
      $validator = new NewOrderValidator($userRepository, $notes);


      // Получаем корзину и ее модель
      $cartModel = $userModel->getCartModel();
      $cart = $userModel->getCart();


      $cartStore = ($userModel instanceof User) 
                    ? new UserItemsListStore( $userRepository ) 
                    : new GuestItemsListStore();

      $cartService = new CartService($userModel, $cartModel, $cartModel->getItems(), $cartStore, $productRepository, $notes);

      $orderRepository = new OrderRepository();
      $orderService = new OrderService($orderRepository, $userModel, $productRepository, $notes);
      $controller = new OrderController($orderService, $cartService, $userModel, $cartModel, $cart, $cartStore, $validator, $notes );

      switch ($routeData->uriModule) {
        case 'neworder':
          $controller->index($routeData);
          break;
        case 'ordercreated':
          $controller->created($routeData);
          break;
      }
    }

    /*************************/
    /******** PAGES *********/
    /**********************/
    private static function routePages(RouteData $routeData)
    {
      $pageService = new PageService();
      $notes = new FlashMessage();
      $breadcrumbs = new Breadcrumbs();
      $pageModel = $pageService->getPageBySlug($routeData->uriModule);

      $controller = new PageController($pageModel, $pageService, $notes, $breadcrumbs);

      switch ($routeData->uriModule) {
        case 'contacts':
          $controller->index($routeData);
          break;
        
      }
    }
  }