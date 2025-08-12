<?php
  namespace Vvintage\Routing;

  use Vvintage\Routing\RouteData;

  // Пеервод на другие языки
  use Vvintage\Config\LanguageConfig;

  /** Контракты */
  use Vvintage\Contracts\User\UserInterface;
  use Vvintage\Store\Cart\CartStoreInterface;
  use Vvintage\Store\Favorites\FavoritesStoreInterface;

  /** Контроллеры */
  use Vvintage\Controllers\Home\HomeController;
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
  use Vvintage\Services\Auth\SessionManager;
  use Vvintage\Services\Product\ProductService;
  use Vvintage\Services\Page\PageService;
  use Vvintage\Services\Validation\LoginValidator;
  use Vvintage\Services\Validation\NewOrderValidator;
  use Vvintage\Services\Page\Breadcrumbs;
  use Vvintage\Services\Messages\FlashMessage;
  use Vvintage\Services\Seo\SeoService;


  /** Модели */
  use Vvintage\Models\User\User;
  use Vvintage\Models\User\GuestUser;
  use Vvintage\Models\Cart\Cart;
  use Vvintage\Models\Blog\Post;
  use Vvintage\Models\Message\Message;
  use Vvintage\Models\Favorites\Favorites;

  /** Хранилища */
  use Vvintage\Store\UserItemsList\GuestItemsListStore;
  use Vvintage\Store\UserItemsList\UserItemsListStore;


  /** Репозитории */
  use Vvintage\Repositories\User\UserRepository;
  use Vvintage\Repositories\Product\ProductRepository;
  use Vvintage\Repositories\Order\OrderRepository;
  use Vvintage\Repositories\Post\PostRepository;
  use Vvintage\Repositories\PostCategory\PostCategoryRepository;
  use Vvintage\Repositories\Message\MessageRepository;

  /** Админ контроллеры */
  use Vvintage\Controllers\Admin\HomeAdminController;
  use Vvintage\Controllers\Admin\AdminProductController;
  use Vvintage\Controllers\Admin\AdminBrandController;
  use Vvintage\Controllers\Admin\AdminCategoryController;
  use Vvintage\Controllers\Admin\AdminUsersController;
  use Vvintage\Controllers\Admin\AdminOrdersController;
  use Vvintage\Controllers\Admin\AdminPostController;
  use Vvintage\Controllers\Admin\AdminMessageController;
  use Vvintage\Controllers\Admin\AdminPostCatController;

  // API
  use Vvintage\Controllers\Api\Category\CategoryApiController;




  class Router {
     /*****************************
            РОУТЕР
    *****************************/
    public static function route(RouteData $routeData) {

      switch ($routeData->uriModule) {
        case '':
        case 'main':
          self::routeHome($routeData);
          // require ROOT . 'modules/main/index.php';
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
          self::routePages($routeData);
          // require ROOT . 'modules/about/index.php';
          break;

        case 'admin':
          self::routeAdminPages($routeData);
          break;

        case 'api' : 
          self::routeApi($routeData);
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

    private static function routeApi(RouteData $routeData)
    {
        $categoryApiController = new CategoryApiController();

        switch ($routeData->uriGet) {
            case 'category':
                if (isset($routeData->uriGetParam) && is_numeric($routeData->uriGetParam)) {
                    $categoryApiController->getMainCategories((int) $routeData->uriGetParam);
                } else {
                    // Если параметра нет, или он некорректен — возможно, вернуть все категории
                    $categoryApiController->getMainCategories();
                }
                break;
            case 'categories':
               $categoryApiController->getAllCategories();
               break;

            default:
                http_response_code(404);
                echo json_encode(['error' => 'API endpoint not found']);
                break;
        }
    }


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
          $profileController->edit($routeData);
          break;

        case 'profile-order':
          $profileController->order($routeData);
          // require ROOT . 'modules/profile/profile-order.php';
          break;
      }
    }

    // ::::::::::::: SHOP :::::::::::::::::::
    private static function routeShop(RouteData $routeData) {
      $languages = LanguageConfig::getAvailableLanguages();
      $currentLang = LanguageConfig::getCurrentLocale();
      $breadcrumbs = new Breadcrumbs();

      // Инициализируем SEO-сервис
      $seoService = new SeoService();
      $productService = new ProductService( $languages, $currentLang);
      $productController = new ProductController(  $productService, $seoService, $breadcrumbs );
      $catalogController  = new CatalogController(  $productService, $seoService, $breadcrumbs );

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
  
      $blogController = new BlogController($notes, $breadcrumbs);
      $postController = new PostController($notes, $breadcrumbs);
    

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
      $breadcrumbs = new Breadcrumbs();


      // Получаем корзину и ее модель
      $cartModel = $userModel->getCartModel();
      $cart = $userModel->getCart();


      $cartStore = ($userModel instanceof User) 
                    ? new UserItemsListStore( $userRepository ) 
                    : new GuestItemsListStore();

      $cartService = new CartService($userModel, $cartModel, $cartModel->getItems(), $cartStore, $productRepository, $notes);

      $orderRepository = new OrderRepository();
      $orderService = new OrderService($orderRepository, $userModel, $productRepository, $notes);
      $controller = new OrderController(
        $orderService, 
        $cartService, 
        $userModel, 
        $cartModel, 
        $cart, 
        $cartStore, 
        $validator, 
        $notes,
        $breadcrumbs);

      switch ($routeData->uriModule) {
        case 'neworder':
          $controller->index($routeData);
          break;
        case 'ordercreated':
          $controller->renderCreated($routeData);
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

        case 'about':
          $controller->index($routeData);
          break;

        
      }
    }

    private static function routeHome(RouteData $routeData)
    {
      $controller = new HomeController();
      $controller->index($routeData);
    }



    
    /*************************/
    /******** ADMIN  *********/
    /**********************/
    private static function routeAdminPages(RouteData $routeData)
    {
      $notes = new FlashMessage();
      $breadcrumbs = new Breadcrumbs();

      $postRepository = new  PostRepository();
      $postCategoryRepository = new PostCategoryRepository(); 
      $messageRepository = new MessageRepository(); 


      $homeAdminController = new HomeAdminController();
      $adminProductController = new AdminProductController();
      $adminBrandController = new AdminBrandController();
      $adminCategoryController = new AdminCategoryController();
      $adminUsersController = new AdminUsersController();
      $adminOrdersController = new AdminOrdersController();
      $adminPostController = new AdminPostController($notes, $breadcrumbs);
      $adminMessageController = new AdminMessageController($messageRepository, $notes);
      $adminPostCatController = new AdminPostCatController($postCategoryRepository, $notes);

      switch ($routeData->uriGet) {
         // ::::::::::::: SHOP :::::::::::::::::::
        case '':
          $homeAdminController->index($routeData);
          break;

        case 'shop':
          $adminProductController->all($routeData);
          break;

        case 'shop-new':
          $adminProductController->new($routeData);
          break;

        case 'shop-edit':
          $adminProductController->edit($routeData);
          break;

 
        // ::::::::::::: ORDERS :::::::::::::::::::
        case 'orders':
          $adminOrdersController->all($routeData);
          break;
      
        case 'order':
          $adminOrdersController->single($routeData);
          break;
      
        case 'order-delete':
          $adminOrdersController->delete($routeData);
          break;

        
      // ::::::::::::: BRANDS :::::::::::::::::::
      case 'brand':
        $adminBrandController->all($routeData);
        break;

      case 'brand-new':
        $adminBrandController->new($routeData);
        // require ROOT . "admin/modules/brands/new.php";
        break;

      case 'brand-edit':
        $adminBrandController->edit($routeData);
        // require ROOT . "admin/modules/brands/edit.php";
        break;

      case 'brand-delete':
        $adminBrandController->delete($routeData);
        // require ROOT . "admin/modules/brands/delete.php";
        break;


      // ::::::::::::: CATEGORIES SHOP :::::::::::::::::::
      case 'category':
        $adminCategoryController->all($routeData);
        // require ROOT . "admin/modules/categories/all.php";
        break;

      case 'category-new':
        $adminCategoryController->new($routeData);
        // require ROOT . "admin/modules/categories/new.php";
        break;

      case 'category-edit':
        $adminCategoryController->edit($routeData);
        // require ROOT . "admin/modules/categories/edit.php";
        break;

      case 'category-delete':
        $adminCategoryController->delete($routeData);
        // require ROOT . "admin/modules/categories/delete.php";
        break;


      // ::::::::::::: USERS :::::::::::::::::::
      case 'users':
        $adminUsersController->all($routeData);
        break; 

      case 'user-edit':
        $adminUsersController->edit($routeData);
        require ROOT . "admin/modules/users/edit.php";
        break; 

      case 'user-block':
        $adminUsersController->block($routeData);
        require ROOT . "admin/modules/users/block.php";
        break;

        // ::::::::::::: BLOG :::::::::::::::::::
      case 'blog':
        $adminPostController->all($routeData);
        break;

      case 'post-new':
         $adminPostController->new($routeData);
        break;

      case 'post-edit':
        $adminPostController->edit($routeData);
        break;

      case 'post-delete':
        $adminPostController->delete($routeData);
        break;

      // ::::::::::::: CATEGORIES BLOG :::::::::::::::::::
      case 'category-blog':
        $adminPostCatController->all($routeData);
        // require ROOT . "admin/modules/categories-blog/all.php";
        break;

      case 'category-blog-new':
        $adminPostCatController->new($routeData);
        // require ROOT . "admin/modules/categories-blog/new.php";
        break;

      case 'category-blog-edit':
        $adminPostCatController->edit($routeData);
        // require ROOT . "admin/modules/categories-blog/edit.php";
        break;

      case 'category-blog-delete':
         $adminPostCatController->delete($routeData);
        // require ROOT . "admin/modules/categories-blog/delete.php";
        break;

      // ::::::::::::: MESSAGES :::::::::::::::::::

      case 'messages':
        $adminMessageController->all($routeData);

        // require ROOT . "admin/modules/messages/all.php";
        break;

      case 'message':
        // $adminMessageController->all($routeData);
        // require ROOT . "admin/modules/messages/single.php";
        break;

      case 'message-delete':
        require ROOT . "admin/modules/messages/delete.php";
        break;

    
        // // ::::::::::::: PAGES :::::::::::::::::::
        // case 'main':
        //   require ROOT . "admin/modules/pages/main.php";
        //   break;

        // case 'about':
        // require ROOT . "admin/modules//pages/about.php";
        //   break;

        // case 'delivery':
        // require ROOT . "admin/modules//pages/delivery.php";
        //   break;

        // case 'contacts':
        //   require ROOT . "admin/modules//pages/contacts.php";
        //   break;

        // // ::::::::::::: OTHER :::::::::::::::::::
        // case 'comments':
        //   require ROOT . "admin/modules/comments/all.php";
        //   break;

        // case 'comment':
        //   require ROOT . "admin/modules/comments/single.php";
        //   break;

        // // ::::::::::::: SETTINGS :::::::::::::::::::
        // case 'settings':
        //   require ROOT . "admin/modules/settings/settings.php";
        //   break;

        // case 'settings-main':
        //   require ROOT . "admin/modules/settings/settings-main.php";
        //   break;

        // case 'settings-social':
        //   require ROOT . "admin/modules/settings/settings-social.php";
        //   break;

        // case 'settings-cookies':
        //   require ROOT . "admin/modules/settings/settings-cookies.php";
        //   break;

        // case 'settings-cards':
        //   require ROOT . "admin/modules/settings/settings-cards.php";
        //   break;
        // // ::::::::::::: SETTINGS :::::::::::::::::::

        // default: 
        //   require ROOT . "admin/modules/main/index.php";
        //   break;

     
      }
    }


  }