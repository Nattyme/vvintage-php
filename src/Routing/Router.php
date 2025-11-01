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
  use Vvintage\Services\Session\SessionService;
  use Vvintage\Services\Navigation\NavigationService;
  use Vvintage\Services\Messages\FlashMessage;
  use Vvintage\Services\Admin\Product\AdminProductImageService;

  use Vvintage\Services\Page\PageService;
  use Vvintage\Services\Cart\CartService;
  use Vvintage\Services\Blog\BlogService;
  use Vvintage\Services\Page\Breadcrumbs;
  use Vvintage\Services\Order\OrderService;
  use Vvintage\Services\Product\ProductService;
  use Vvintage\Services\User\UserService;
  use Vvintage\Services\Locale\LocaleService;
  use Vvintage\Services\Category\CategoryService;
  use Vvintage\Services\Brand\BrandService;
  use Vvintage\Services\Post\PostService;
  use Vvintage\Services\Favorites\FavoritesService;
  use Vvintage\Services\Validation\NewOrderValidator;
  use Vvintage\Services\Validation\ProfileValidator;

  use Vvintage\Services\Validation\LoginValidator;
  use Vvintage\Services\Security\PasswordSetNewService;
  use Vvintage\Services\Security\RegistrationService;
  use Vvintage\Services\Security\PasswordResetService;
  use Vvintage\Services\Validation\RegistrationValidator;
  use Vvintage\Services\Security\LoginService;
  use Vvintage\Services\Validation\PasswordResetValidator;
  use Vvintage\Services\AdminPanel\AdminPanelService;
  use Vvintage\Services\Admin\Brand\AdminBrandService;
  use Vvintage\Services\Admin\Validation\AdminBrandValidator;
  use Vvintage\Services\Admin\Category\AdminCategoryService;
  use Vvintage\Services\Admin\Validation\AdminCategoryValidator;
  use Vvintage\Services\Admin\Messages\AdminMessageService;
  use Vvintage\Services\Admin\Order\AdminOrderService;
  use Vvintage\Services\Admin\Post\AdminPostService;
  use Vvintage\Services\Admin\PostCategory\AdminPostCategoryService;
  use Vvintage\Services\Admin\Validation\AdminPostCategoryValidator;
  use Vvintage\Services\Admin\Product\AdminProductService;
  use Vvintage\Services\Admin\User\AdminUserService;
  use Vvintage\Services\Admin\AdminStatsService;
  use Vvintage\Services\Messages\MessageService;
  use Vvintage\Services\Product\ProductImageService;
  use Vvintage\Services\Shared\PaginationService;
  
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
  use Vvintage\Repositories\Brand\BrandRepository;
  use Vvintage\Repositories\Brand\BrandTranslationRepository;
  use Vvintage\Repositories\Product\ProductTranslationRepository;

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
      $localeService = new LocaleService();
      $flash = new FlashMessage();
      $userRepository = new UserRepository();
      $setNewPassService = new PasswordSetNewService($userRepository);
      $sessionService = new SessionService();
      $validator = new LoginValidator($userRepository);
      $pageService = new PageService();
      $registrationService = new RegistrationService();
      $registrationValidator = new RegistrationValidator(); 
      $sessionService = new SessionService();
      $messageService = new MessageService();

      $brandRepository = new BrandRepository();
      $brandTranslationRepo = new BrandTranslationRepository();
      $brandService = new BrandService($localeService, $brandRepository,  $brandTranslationRepo);

      $productRepository = new ProductRepository();
      $productTranslationRepository = new ProductTranslationRepository();
      $categoryService = new CategoryService();
      $productImageService = new ProductImageService();
      $paginationService = new PaginationService();

      $productService = new ProductService(
         $productRepository,
         $productTranslationRepository,
         $categoryService,
         $brandService,
         $productImageService,
         $paginationService
      );
      $orderRepository = new OrderRepository();
      $orderService = new OrderService($orderRepository, $productService );
      $adminPanelService = new AdminPanelService($messageService, $orderService);
      $passResetService = new PasswordResetService( $userRepository );
      $passResetValidator = new PasswordResetValidator($passResetService);
      $loginValidator = new LoginValidator($userRepository);
      $loginService = new LoginService($userRepository, $loginValidator, $sessionService);
    

      $loginController = new LoginController(
        $sessionService, 
        $adminPanelService, 
        $loginService,
        $productService, 
        $pageService, 
        $flash, 
        $seoService, 
        $userRepository
      );
      $regController = new RegistrationController(
        $sessionService, 
        $adminPanelService, 
        $registrationValidator,
        $registrationService, 
        $pageService, 
        $flash, 
        $seoService
      );
      $resetController = new PasswordResetController(
        $sessionService, 
        $adminPanelService, 
        $passResetValidator,
        $passResetService,
        $pageService,  
        $flash, 
        $seoService
      );
      $setNewPassController = new PasswordSetNewController(
        $sessionService, 
        $adminPanelService, 
        $pageService, 
        $flash, 
        $seoService, 
        $setNewPassService
      );

   
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
        $flash = new FlashMessage();
        $pageService = new PageService();
        $userService = new UserService();
        $orderRepository = new OrderRepository();
        $localeService = new LocaleService();

        $brandRepository = new BrandRepository();
        $brandTranslationRepo = new BrandTranslationRepository();
        $brandService = new BrandService($localeService, $brandRepository,  $brandTranslationRepo);

        $productRepository = new ProductRepository();
        $productTranslationRepository = new ProductTranslationRepository();
        $categoryService = new CategoryService();
        $productImageService = new ProductImageService();
        $paginationService = new PaginationService();
      
        $productService = new ProductService(
          $productRepository,
          $productTranslationRepository,
          $categoryService,
          $brandService,
          $productImageService,
          $paginationService
        );
     
        $orderService = new OrderService( $orderRepository, $productService);
        $breadcrumbs = new Breadcrumbs();
        $seoService = new SeoService();
        $localeService = new LocaleService();
        $sessionService = new SessionService();
        $adminPanelService = new AdminPanelService();

        $profileValidator = new ProfileValidator();
        $profileController = new ProfileController(
          $sessionService,
          $adminPanelService,
          $orderService,
          $localeService, 
          $pageService, 
          $profileValidator, 
          $userService, 
          $flash, 
          $seoService, 
          $breadcrumbs
        );

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
      $flash = new FlashMessage();
      $categoryService = new CategoryService();
      $localeService = new LocaleService();

      $brandRepository = new BrandRepository();
      $brandTranslationRepo = new BrandTranslationRepository();
      $brandService = new BrandService($localeService, $brandRepository,  $brandTranslationRepo);
      $pageService = new PageService();
      $sessionService = new SessionService();

      $productRepository = new ProductRepository();
      $productTranslationRepository = new ProductTranslationRepository();
      $categoryService = new CategoryService();
      $productImageService = new ProductImageService();
      $paginationService = new PaginationService();
    
      $productService = new ProductService(
        $productRepository,
        $productTranslationRepository,
        $categoryService,
        $brandService,
        $productImageService,
        $paginationService
      );
     
      $messageService = new MessageService();
      $orderRepository = new OrderRepository();
      $orderService = new OrderService($orderRepository, $productService );
      $adminPanelService = new AdminPanelService($messageService, $orderService);
      $seoService = new SeoService();


      $productController = new ProductController( 
        $sessionService, 
        $adminPanelService,  
        $pageService, 
        $productService, 
        $flash, 
        $seoService, 
        $breadcrumbs 
      );
      $catalogController  = new CatalogController(
        $sessionService, 
        $adminPanelService,  
        $pageService, 
        $brandService, 
        $categoryService, 
        $productService, 
        $flash, 
        $seoService, 
        $breadcrumbs 
      );

      if ( isset($routeData->uriGet) ) {
        $productController->index($routeData);
      } else {
        $catalogController->index($routeData);
      }

    }

      
    private static function routeBlog(RouteData $routeData) {
      $breadcrumbs = new Breadcrumbs();
      $postService = new PostService();
      $navigationService = new NavigationService();
      $seoService = new SeoService();
      $localeService = new LocaleService();
      $sessionService = new SessionService();
      $brandRepository = new BrandRepository();
      $brandTranslationRepo = new BrandTranslationRepository();
      $brandService = new BrandService($localeService, $brandRepository,  $brandTranslationRepo);

      $productRepository = new ProductRepository();
      $productTranslationRepository = new ProductTranslationRepository();
      $categoryService = new CategoryService();
      $productImageService = new ProductImageService();
      $paginationService = new PaginationService();
      
      $productService = new ProductService(
        $productRepository,
        $productTranslationRepository,
        $categoryService,
        $brandService,
        $productImageService,
        $paginationService
      );
      
      $messageService = new MessageService();
      $orderRepository = new OrderRepository();
      $orderService = new OrderService($orderRepository, $productService );
      $adminPanelService = new AdminPanelService($messageService, $orderService);
      
  
      $blogController = new BlogController($sessionService, $adminPanelService, $postService, $navigationService, $breadcrumbs);
      $postController = new PostController($sessionService, $adminPanelService, $postService, $navigationService, $seoService, $breadcrumbs);
    
    
        if ($routeData->uriModule === 'blog' && isset($routeData->uriGet)) {
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
      $localeService = new LocaleService();
      $sessionService = new SessionService();
      $brandRepository = new BrandRepository();
      $brandTranslationRepo = new BrandTranslationRepository();
      $brandService = new BrandService($localeService, $brandRepository,  $brandTranslationRepo);
        
      $productRepository = new ProductRepository();
      $productTranslationRepository = new ProductTranslationRepository();
      $categoryService = new CategoryService();
      $productImageService = new ProductImageService();
      $paginationService = new PaginationService();
      
      $productService = new ProductService(
        $productRepository,
        $productTranslationRepository,
        $categoryService,
        $brandService,
        $productImageService,
        $paginationService
      );
      $messageService = new MessageService();
      $orderRepository = new OrderRepository();
      $orderService = new OrderService($orderRepository, $productService );
      $adminPanelService = new AdminPanelService($messageService, $orderService);
      $seoService = new SeoService();
      $flashMessage = new FlashMessage();
      $pageService = new PageService();
     
     
      $userModel = $sessionService->getLoggedInUser();
      $breadcrumbs = new Breadcrumbs();

      // Получаем корзину и ее модель
      $cartModel = $userModel->getCartModel();
      $cart = $userModel->getCart();;
     
      $brandRepository = new BrandRepository();
      $brandTranslationRepo = new BrandTranslationRepository();
      $brandService = new BrandService( $localeService, $brandRepository,  $brandTranslationRepo);

      $productRepository = new ProductRepository();
      $productTranslationRepository = new ProductTranslationRepository();
      $categoryService = new CategoryService();
      $productImageService = new ProductImageService();
      $paginationService = new PaginationService();
    
      $productService = new ProductService(
        $productRepository,
        $productTranslationRepository,
        $categoryService,
        $brandService,
        $productImageService,
        $paginationService
      );

      $cartStore = ($userModel instanceof User) 
                    ? new UserItemsListStore( new UserRepository() ) 
                    : new GuestItemsListStore();
      $cartService = new CartService($userModel, $cartModel, $cartModel->getItems(), $cartStore, $productService);

      $controller  = new CartController(
        $sessionService, 
        $adminPanelService,
        $pageService, 
        $flashMessage, 
        $cartService, 
        $userModel, 
        $cartModel, 
        $cart, 
        $cartStore, 
        $breadcrumbs, 
        $seoService 
      );

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
      $localeService = new LocaleService();
      $sessionService = new SessionService();
      $brandRepository = new BrandRepository();
      $brandTranslationRepo = new BrandTranslationRepository();
      $brandService = new BrandService( $localeService, $brandRepository,  $brandTranslationRepo);
    

      $productRepository = new ProductRepository();
      $productTranslationRepository = new ProductTranslationRepository();
      $categoryService = new CategoryService();
      $productImageService = new ProductImageService();
      $paginationService = new PaginationService();
    
      $productService = new ProductService(
        $productRepository,
        $productTranslationRepository,
        $categoryService,
        $brandService,
        $productImageService,
        $paginationService
      );
      $messageService = new MessageService();
      $orderRepository = new OrderRepository();
      $orderService = new OrderService($orderRepository, $productService );
      $adminPanelService = new AdminPanelService($messageService, $orderService);
      $seoService = new SeoService();
      $flashMessage = new FlashMessage();
      $pageService = new PageService();
 
      $userModel = $sessionService->getLoggedInUser();
      $breadcrumbs = new Breadcrumbs();

      // Получаем избранное и ее модель
      $favModel = $userModel->getFavModel();
      $fav = $userModel->getFavList();
     
      $brandRepository = new BrandRepository();
      $brandTranslationRepo = new BrandTranslationRepository();
      $brandService = new BrandService($localeService, $brandRepository,  $brandTranslationRepo);

      $productRepository = new ProductRepository();
      $productTranslationRepository = new ProductTranslationRepository();
      $categoryService = new CategoryService();
      $productImageService = new ProductImageService();
      $paginationService = new PaginationService();
    
      $productService = new ProductService(
        $productRepository,
        $productTranslationRepository,
        $categoryService,
        $brandService,
        $productImageService,
        $paginationService
      );

      $favStore = ($userModel instanceof User) 
                    ? new UserItemsListStore( new UserRepository() ) 
                    : new GuestItemsListStore();
                    
      $favService = new FavoritesService($userModel, $favModel, $favModel->getItems(), $favStore, $productService);
      $controller  = new FavoritesController(
        $sessionService, 
        $adminPanelService, 
        $pageService, 
        $flashMessage, 
        $favService, 
        $userModel, 
        $favModel, 
        $fav, 
        $favStore, 
        $breadcrumbs, 
        $seoService 
      );

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
      $userModel = $sessionService->getLoggedInUser();
      $pageService = new PageService();
      $flashMessage = new FlashMessage();
      $localeService = new LocaleService();

      $brandRepository = new BrandRepository();
      $brandTranslationRepo = new BrandTranslationRepository();
      $brandService = new BrandService($localeService, $brandRepository,  $brandTranslationRepo);


      $productRepository = new ProductRepository();
      $productTranslationRepository = new ProductTranslationRepository();
      $categoryService = new CategoryService();
      $productImageService = new ProductImageService();
      $paginationService = new PaginationService();
    
      $productService = new ProductService(
        $productRepository,
        $productTranslationRepository,
        $categoryService,
        $brandService,
        $productImageService,
        $paginationService
      );
      $messageService = new MessageService();
      $orderRepository = new OrderRepository();
      $orderService = new OrderService($orderRepository, $productService );
      $adminPanelService = new AdminPanelService($messageService, $orderService);

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
      $brandRepository = new BrandRepository();
      $brandTranslationRepo = new BrandTranslationRepository();
      $brandService = new BrandService($localeService, $brandRepository,  $brandTranslationRepo);
   
      $productRepository = new ProductRepository();
      $productTranslationRepository = new ProductTranslationRepository();
      $categoryService = new CategoryService();
      $productImageService = new ProductImageService();
      $paginationService = new PaginationService();
    
      $productService = new ProductService(
        $productRepository,
        $productTranslationRepository,
        $categoryService,
        $brandService,
        $productImageService,
        $paginationService
      );


      $cartStore = ($userModel instanceof User) 
                    ? new UserItemsListStore( $userRepository ) 
                    : new GuestItemsListStore();

      $cartService = new CartService($userModel, $cartModel, $cartModel->getItems(), $cartStore, $productService);


      $orderRepository = new OrderRepository();

      $brandRepository = new BrandRepository();
      $brandTranslationRepo = new BrandTranslationRepository();
      $brandService = new BrandService($localeService, $brandRepository,  $brandTranslationRepo);


      $productRepository = new ProductRepository();
      $productTranslationRepository = new ProductTranslationRepository();
      $categoryService = new CategoryService();
      $productImageService = new ProductImageService();
      $paginationService = new PaginationService();
    
      $productService = new ProductService(
        $productRepository,
        $productTranslationRepository,
        $categoryService,
        $brandService,
        $productImageService,
        $paginationService
      );

      $orderService = new OrderService( $orderRepository, $productService);
      $controller = new OrderController(
        $sessionService,
        $adminPanelService,
        $flashMessage,
        $pageService,
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
      $categoryService = new CategoryService();
      $postService = new PostService();
      $pageService = new PageService();
      $breadcrumbs = new Breadcrumbs();
      $localeService = new LocaleService();
      $flash = new FlashMessage();
      $sessionService = new SessionService();
      $brandRepository = new BrandRepository();
      $brandTranslationRepo = new BrandTranslationRepository();
      $brandService = new BrandService($localeService, $brandRepository,  $brandTranslationRepo);


      $productRepository = new ProductRepository();
      $productTranslationRepository = new ProductTranslationRepository();
      $categoryService = new CategoryService();
      $productImageService = new ProductImageService();
      $paginationService = new PaginationService();
    
      $productService = new ProductService(
        $productRepository,
        $productTranslationRepository,
        $categoryService,
        $brandService,
        $productImageService,
        $paginationService
      );
      $messageService = new MessageService();
      $orderRepository = new OrderRepository();
      $orderService = new OrderService($orderRepository, $productService );
      $adminPanelService = new AdminPanelService($messageService, $orderService);

      // Инициализируем SEO-сервис
      $seoService = new SeoService();
     
      $controller = new PageController( 
        $categoryService,
        $productService,    
        $postService,
        $sessionService,
        $adminPanelService,
        $pageService, 
        $breadcrumbs, 
        $flash, 
        $seoService
      );

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


    
    /*************************/
    /******** ADMIN  *********/
    /**********************/
    public static function routeAdminPages(RouteData $routeData)
    {
      $flash = new FlashMessage();
      $breadcrumbs = new Breadcrumbs();
      $localeService = new LocaleService();
      $sessionService = new SessionService();
      $postRepository = new  PostRepository();
      $postCategoryRepository = new PostCategoryRepository(); 

      $adminBrandService = new AdminBrandService( $brandRepository,  $brandTranslationRepo);
      $adminBrandValidator = new AdminBrandValidator();
      $adminCategoryService = new AdminCategoryService();

      $adminCategoryValidator = new AdminCategoryValidator();
      $adminMessageService = new AdminMessageService();

      $brandRepository = new BrandRepository();
      $brandTranslationRepo = new BrandTranslationRepository();
      $brandService = new BrandService( $localeService, $brandRepository,  $brandTranslationRepo);

    

      $productRepository = new ProductRepository();
      $productTranslationRepository = new ProductTranslationRepository();
      $categoryService = new CategoryService();
      $productImageService = new ProductImageService();
      $paginationService = new PaginationService();
    
      $productService = new ProductService(
        $productRepository,
        $productTranslationRepository,
        $categoryService,
        $brandService,
        $productImageService,
        $paginationService
      );
      $orderRepository = new OrderRepository();
      $orderService = new OrderService($orderRepository, $productService );
      $adminOrderService =  new AdminOrderService($orderRepository, $productService);

      $adminPostService = new AdminPostService($localeService);
      $adminPostCategoryService = new AdminPostCategoryService();
      $adminPostCategoryValidator = new AdminPostCategoryValidator();

      $adminProductImageService = new AdminProductImageService();

      $productRepository = new ProductRepository();
      $productTranslationRepo = new ProductTranslationRepository();
      $categoryService = new CategoryService();
      $productImageService = new ProductImageService();
      $paginationService = new PaginationService();
      $localeService = new LocaleService();

      $productService = new ProductService(
        $productRepository, 
        $productTranslationRepo,
        $categoryService,
        $brandService,
        $productImageService,
        $paginationService,
        $localeService
      );
   
      $adminProductService = new AdminProductService( $adminProductImageService,  $brandService);
      $adminUserService = new AdminUserService();
      $adminStatsService = new AdminStatsService;

      $homeAdminController = new HomeAdminController( $adminStatsService, $localeService,  $sessionService,$flash);
      $adminProductController = new AdminProductController(
        $adminProductService, 
        $localeService,  
        $sessionService, 
        $flash
      );

      $adminBrandController = new AdminBrandController( 
        $adminBrandService, 
        $adminBrandValidator, 
        $localeService,  
        $sessionService, 
        $flash
      );

      $adminCategoryController = new AdminCategoryController(
        $adminCategoryService,
        $adminCategoryValidator,
        $localeService,  
        $sessionService, 
        $flash
      );
      $adminUserController = new AdminUserController( $adminUserService, $localeService,  $sessionService, $flash);
      $adminOrderController = new AdminOrderController( 
        $adminOrderService, 
        $localeService,  
        $sessionService, 
        $flash
      );
      $adminPostController = new AdminPostController(
        $adminPostService,
        $localeService,  
        $sessionService, 
        $flash, 
        $breadcrumbs
      );
      
      $adminMessageController = new AdminMessageController(
        $adminMessageService,
        $localeService,  
        $sessionService, 
        $flash
      );
      $adminPostCatController = new AdminPostCategoryController( 
        $adminPostCategoryService, 
        $adminPostCategoryValidator,
        $localeService,  
        $sessionService, 
        $flash, 
        $postCategoryRepository
      );
  
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
  
          break;

        case 'brand-edit':
          $adminBrandController->edit($routeData);
  
          break;

        case 'brand-delete':
          $adminBrandController->delete($routeData);
        
          break;


        // ::::::::::::: CATEGORIES SHOP :::::::::::::::::::
        case 'category':
          $adminCategoryController->all($routeData);
        
          break;

        case 'category-new':
          $adminCategoryController->new($routeData);
  
          break;

        case 'category-edit':
          $adminCategoryController->edit($routeData);
          break;

        case 'category-delete':
          $adminCategoryController->delete($routeData);
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
          break;

        case 'category-blog-new':
          $adminPostCatController->new($routeData);
          break;

        case 'category-blog-edit':
          $adminPostCatController->edit($routeData);
          break;

        case 'category-blog-delete':
          $adminPostCatController->delete($routeData);
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

        default: 
          $homeAdminController->index($routeData);
          break;

     
      }
    }


  }




