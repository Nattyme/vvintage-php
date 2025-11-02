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
  use Vvintage\Controllers\Blog\PostController;
  use Vvintage\Controllers\Blog\BlogController;
  use Vvintage\Controllers\Order\OrderController;
  use Vvintage\Controllers\Shop\CatalogController;
  use Vvintage\Controllers\Shop\ProductController;
  use Vvintage\Controllers\Security\LoginController;
  use Vvintage\Controllers\Profile\ProfileController;
  use Vvintage\Controllers\Favorites\FavoritesController;
  use Vvintage\Controllers\Security\RegistrationController;
  use Vvintage\Controllers\Security\PasswordResetController;
  use Vvintage\Controllers\Security\PasswordSetNewController;

  /** Сервисы */
  use Vvintage\Services\SEO\SeoService;
  use Vvintage\Services\Page\PageService;
  use Vvintage\Services\Cart\CartService;
  use Vvintage\Services\Blog\BlogService;
  use Vvintage\Services\Page\Breadcrumbs;
  use Vvintage\Services\Order\OrderService;
  use Vvintage\Services\Messages\FlashMessage;
  use Vvintage\Services\Product\ProductService;
  use Vvintage\Services\Session\SessionService;
  use Vvintage\Services\Cookie\CookieService;
  use Vvintage\Services\Validation\LoginValidator;
  use Vvintage\Services\Favorites\FavoritesService;
  use Vvintage\Services\Validation\NewOrderValidator;
  use Vvintage\Services\Security\PasswordSetNewService;


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
  use Vvintage\Controllers\Admin\Product\AdminProductController;
  use Vvintage\Controllers\Admin\Brand\AdminBrandController;
  use Vvintage\Controllers\Admin\Category\AdminCategoryController;
  use Vvintage\Controllers\Admin\User\AdminUserController;
  use Vvintage\Controllers\Admin\Order\AdminOrderController;
  use Vvintage\Controllers\Admin\Post\AdminPostController;
  use Vvintage\Controllers\Admin\Message\AdminMessageController;
  use Vvintage\Controllers\Admin\PostCategory\AdminPostCategoryController;

  // API
  use Vvintage\Controllers\Api\Category\CategoryApiController;
  use Vvintage\Controllers\Api\Brand\BrandApiController;
  use Vvintage\Controllers\Api\Product\ProductApiController;




  class Router {
     /*****************************
            РОУТЕР
    *****************************/
    public static function route(RouteData $routeData) {

      switch ($routeData->uriModule) {
        case '':
        case 'main':
          self::routePages($routeData);
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
        case 'profile/edit':
        case 'profile/order':
          self::routeProfile($routeData);
          break;

        case 'shop':
          self::routeShop($routeData);
          break;
        
        case 'blog':
        case 'post':
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

        case 'delivery':
          self::routePages($routeData);
          break;

        case 'contacts':
          self::routePages($routeData);
          break;

        case 'about':
          self::routePages($routeData);
          break;

        case 'api' : 
          self::routeApi($routeData);
          break;

        default:
          http_response_code(404);
          require ROOT . 'views/pages/404.tpl';
          break;
      }
  
    }
    /*****************************
              // РОУТЕР 
    *****************************/

    private static function routeApi(RouteData $routeData)
    {
        $categoryApiController = new CategoryApiController();
        $brandApiController = new BrandApiController();
        $productApiController = new ProductApiController();

        $uri = preg_replace('#^api/#', '', $routeData->uri);
        $method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
        switch (true) {
           
            // --- Categories ---
            // 1. /categories/{id}/subcategories
            case preg_match('#^categories/(\d+)/subcategories$#', $uri, $matches):
                $parentId = (int)$matches[1];
                $categoryApiController->getSubCategories($parentId);
                break;

            // 2. /categories/{id}
            case preg_match('#^categories/(\d+)$#',  $uri, $matches):
                $id = (int)$matches[1];

                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                  $categoryApiController->getOne($id);
                } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
                    // $categoryApiController->update($id);
                } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                  // $categoryApiController->delete($id);
                }
                break;

            case $routeData->uriGet === 'categories' && $_SERVER['REQUEST_METHOD'] === 'POST':
                // $categoryApiController->create();
                break;

            // 3. /categories
            case preg_match('#^categories$#',  $uri):
                $categoryApiController->getMainCategories();
                break;

            case preg_match('#^categories-data$#',  $uri):
              error_log('hey');
                $categoryApiController->getAllCategories();
                break;

            // --- Brands ---
            case $routeData->uriGet === 'brands':  
                $brandApiController->getAllBrands();
                break;

            case preg_match('#^brands/(\d+)$#',  $uri, $matches):  
                $id = (int)$matches[1];
                $brandApiController->getBrand($id);
                break;

            // --- Products ---

            case preg_match('#^products/(\d+)$#',  $uri, $matches): 
                $id = (int)$matches[1];
                    file_put_contents(__DIR__.'/debug.log', "In products case, id=$id, method=$method\n", FILE_APPEND);

                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $productApiController->getOne($id);
                } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && ($method === 'PUT')) {
                    $productApiController->edit($id);
                } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                    $productApiController->delete($id);
                }
                break;

            case $routeData->uriGet === 'products' && $_SERVER['REQUEST_METHOD'] === 'POST':
                $productApiController->create();
                break;
            case $routeData->uriGet === 'products':  
              $productApiController->getAll();
              break;

            // --- Default ---
            default:
                http_response_code(404);
                echo json_encode(['error' => 'API endpoint not found']);
                break;
        }

    }



    private static function routeAuth(RouteData $routeData) {
      $seoService = new SeoService();
      $sessionService = new SessionService();
      $cookieService = new CookieService();
      $userRepository = new UserRepository();
      $pageService = new PageService();
      $productService = new ProductService ();
      $setNewPassService = new PasswordSetNewService($userRepository);
      $validator = new LoginValidator($userRepository);

      $loginController = new LoginController( $sessionService, $cookieService, $seoService, $pageService, $productService, $userRepository);
      $regController = new RegistrationController( $seoService);
      $resetController = new PasswordResetController( $seoService);
      $setNewPassController = new PasswordSetNewController( $seoService, $setNewPassService);

   
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
          $sessionService->logout();
          break;
      }
    }



    public static function routeProfile(RouteData $routeData)
    {
        $breadcrumbs = new Breadcrumbs();
        $seoService = new SeoService();
        $profileController = new ProfileController($seoService, $breadcrumbs);

        // Свой профиль
        if (isset($routeData->uriGet) && $routeData->uriGet === 'edit') {
            $profileController->edit($routeData); 
        } else if ($routeData->uriModule === 'order' && isset($routeData->uriGet)) {
            $profileController->order($routeData); // Профиль
        } elseif ($routeData->uriModule === 'profile' && isset($routeData->uriGet) && !empty($routeData->uriGet)) {
           $profileController->index($routeData);
        } else {
           $profileController->index($routeData); // Профиль
        } 
        
    }


    // ::::::::::::: SHOP :::::::::::::::::::
    private static function routeShop(RouteData $routeData) {
      $breadcrumbs = new Breadcrumbs();

      // Инициализируем SEO-сервис
      $seoService = new SeoService();
      $productController = new ProductController($seoService, $breadcrumbs );
      $catalogController  = new CatalogController($seoService, $breadcrumbs );

      if ( isset($routeData->uriGet) ) {
        $productController->index($routeData);
      } else {
        $catalogController->index($routeData);
      }

    }

      
    private static function routeBlog(RouteData $routeData) {
      $breadcrumbs = new Breadcrumbs();
  
      $blogController = new BlogController($breadcrumbs);
      $postController = new PostController($breadcrumbs);
    
        if ($routeData->uriModule === 'add-comment') {
          // require ROOT . 'modules/blog/add-comment.php';
        } 
        elseif ($routeData->uriModule === 'blog' && isset($routeData->uriGet)) {
          $blogController->index($routeData);
        }
        elseif ($routeData->uriModule === 'post') {
          if (!empty($routeData->uriGet)) {
              $postController->index($routeData); // конкретный пост
          } else {
              header("Location: /blog");
              exit;
          }
        }

        else {
          $blogController->index($routeData);
        }
    }

    private static function routeCart(RouteData $routeData) {
      $sessionService = new SessionService();
      $seoService = new SeoService();
      /**
       * Получаем модель пользователя - гость или залогиненный
       * @var UserInreface $userModel
      */
      $userModel = $sessionService->getLoggedInUser();
      $breadcrumbs = new Breadcrumbs();

      // Получаем корзину и ее модель
      $cartModel = $userModel->getCartModel();
      $cart = $userModel->getCart();;
      $productService = new ProductService();

      /**
       * Получаем хранилище
       * @var CartStoreInterface $cartStore;
       */
      $cartStore = ($userModel instanceof User) 
                    ? new UserItemsListStore( new UserRepository() ) 
                    : new GuestItemsListStore();
      $cartService = new CartService($userModel, $cartModel, $cartModel->getItems(), $cartStore, $productService);

      $controller  = new CartController( $cartService, $userModel, $cartModel, $cart, $cartStore, $breadcrumbs, $seoService );

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
      $sessionService = new SessionService();
      $seoService = new SeoService();
      /**
       * Получаем модель пользователя - гость или залогиненный
       * @var UserInreface $userModel
      */
      $userModel = $sessionService->getLoggedInUser();
      $breadcrumbs = new Breadcrumbs();

      // Получаем избранное и ее модель
      $favModel = $userModel->getFavModel();
      $fav = $userModel->getFavList();
      $productService = new ProductService();


      /**
       * Получаем хранилище
       * @var FavoritesStoreInterface $cartStore;
      */
      $favStore = ($userModel instanceof User) 
                    ? new UserItemsListStore( new UserRepository() ) 
                    : new GuestItemsListStore();
                    
      $favService = new FavoritesService($userModel, $favModel, $favModel->getItems(), $favStore, $productService);
      $controller  = new FavoritesController( $favService, $userModel, $favModel, $fav, $favStore, $breadcrumbs, $seoService );

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
      $sessionService = new SessionService();
      /**
       * Получаем модель пользователя - гость или залогиненный
       * @var UserInreface $userModel
      */
      $userModel = $sessionService->getLoggedInUser();

      // Если гость - перенаправляем на страницу входа
      if($userModel instanceof GuestUser) {
        header('Location: ' . HOST . 'login');
        exit();
      }

      $userRepository = $userModel->getRepository();
      $validator = new NewOrderValidator($userRepository);
      $breadcrumbs = new Breadcrumbs();


      // Получаем корзину и ее модель
      $cartModel = $userModel->getCartModel();
      $cart = $userModel->getCart();
      $productService = new ProductService();


      $cartStore = ($userModel instanceof User) 
                    ? new UserItemsListStore( $userRepository ) 
                    : new GuestItemsListStore();

      $cartService = new CartService($userModel, $cartModel, $cartModel->getItems(), $cartStore, $productService);

      $orderService = new OrderService();
      $controller = new OrderController(
        $orderService, 
        $cartService, 
        $userModel, 
        $cartModel, 
        $cart, 
        $cartStore, 
        $validator, 
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
      $breadcrumbs = new Breadcrumbs();

      // Инициализируем SEO-сервис
      $seoService = new SeoService();
      // $pageModel = $pageService->getPageBySlug($routeData->uriModule);

      // $controller = new PageController($pageModel, $breadcrumbs);
      $controller = new PageController( $seoService);

      switch ($routeData->uriModule) {
        case '':
          $controller->home($routeData);
          break;
        case 'main':
          $controller->home($routeData);
          break;
        default :
          $controller->index($routeData);
          break;
      }
    }

    // private static function routeHome(RouteData $routeData)
    // {
    //   $controller = new HomeController();
    //   $controller->index($routeData);
    // }



    
    /*************************/
    /******** ADMIN  *********/
    /**********************/
    public static function routeAdminPages(RouteData $routeData)
    {
      $breadcrumbs = new Breadcrumbs();
      $postRepository = new  PostRepository();
      $postCategoryRepository = new PostCategoryRepository(); 


      $homeAdminController = new HomeAdminController();
      $adminProductController = new AdminProductController();
      $adminBrandController = new AdminBrandController();
      $adminCategoryController = new AdminCategoryController();
      $adminUserController = new AdminUserController();
      $adminOrderController = new AdminOrderController();
      $adminPostController = new AdminPostController($breadcrumbs);
      $adminMessageController = new AdminMessageController();
      $adminPostCatController = new AdminPostCategoryController($postCategoryRepository);
  
      switch ($routeData->uriModule) {
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
          $adminOrderController->all($routeData);
          break;
      
        case 'order':
          $adminOrderController->single($routeData);
          break;
      
        case 'order-delete':
          $adminOrderController->delete($routeData);
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
          $adminUserController->all($routeData);
          break; 

        case 'user-edit':
          $adminUserController->edit($routeData);
          require ROOT . "admin/modules/users/edit.php";
          break; 

        case 'user-block':
          $adminUserController->block($routeData);
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
          break;

        case 'message':
          $adminMessageController->single($routeData);
          break;

        case 'message-delete':
          $adminMessageController->delete($routeData);
          break;

    
  
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

        default: 
          $homeAdminController->index($routeData);
          break;

     
      }
    }


  }