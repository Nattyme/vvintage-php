<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Security;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

/** Модели */
use Vvintage\Models\User\User;
use Vvintage\Models\Cart\Cart;
use Vvintage\Models\Favorites\Favorites;

/** Сервисы */
use Vvintage\Services\SEO\SeoService;
use Vvintage\Services\Cart\CartService;
use Vvintage\Services\Page\PageService;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Security\LoginService;
use Vvintage\Services\Product\ProductService;
use Vvintage\Services\Favorites\FavoritesService;
use Vvintage\Services\User\UserItemsMergeService;
use Vvintage\Services\Session\SessionService;
use Vvintage\Services\AdminPanel\AdminPanelService;

/** Хранилища */
use Vvintage\Store\UserItemsList\GuestItemsListStore;
use Vvintage\Store\UserItemsList\UserItemsListStore;

/** Репозитории */
use Vvintage\Repositories\User\UserRepository;

/** Роутинг */
use Vvintage\Routing\RouteData;

// Пеервод на другие языки
use Vvintage\Config\LanguageConfig;
use Vvintage\Services\Translator\Translator;
 
final class LoginController extends BaseController
{
  public function __construct( 
    protected SessionService $sessionService, 
    protected AdminPanelService $adminPanelService,
    private UserItemsListStore $store,
    private Cart $cart,
    private Favorites $fav,
    private CartService $cartService,
    private FavoritesService $favService,
    private UserItemsMergeService $userItemsMergeService,
    private LoginService $service,
    private ProductService $productService, 
    private PageService $pageService, 
    private FlashMessage $flash, 
    private SeoService $seoService, 
    private UserRepository $userRepository) 
  {
    parent::__construct($sessionService, $adminPanelService); // Важно!
  }

  public function index(RouteData $routeData): void
  {
    if (!isset($_POST['login'])) {
      $this->renderForm($routeData);
      return;
    }

    $userModel = $this->service->login($_POST);


    if (!$userModel) {
      $this->renderForm($routeData);
      return;
    }

    $this->handleItemsMerge($userModel);

    // Сообщение об успехе
    $userName = $_SESSION['logged_user']['name'] ?? '';
    
    if (trim($userName) !== '') {
      $this->flash->pushSuccess(h(__('login.success.username', ['%name%' => $userName], 'messages')));
    } else {
      $this->flash->pushSuccess(h(__('login.success', [], 'messages')));
    }

    // Редирект
    header('Location: ' . HOST . 'profile');
    exit();
  }


  private function handleItemsMerge(User $userModel): void
  {
    $guest = $this->createGuestModels();
   
    $user = $this->createUserModels();
 
    // Здесь возвращается guest Store
    // $cartService = new CartService(
    //   $userModel, $guest['cart'], $guest['cart']->getItems(), $user['store'], $this->productService
    // );

    // $favService = new FavoritesService(
    //   $userModel, $guest['fav'], $guest['fav']->getItems(), $user['store'], $this->productService
    // );
    // $userItemsMergeService = new UserItemsMergeService($favService, $cartService);
  //  private CartService $cartService,
  //   private FavoritesService $favService,
  //   private UserItemsMergeService $userItemsMergeService,
    $this->userItemsMergeService->mergeAllAfterLogin(
      $user['cart'],
      $guest['cart'],
      $user['fav'],
      $guest['fav']
    );
    
  }

  /**
   * Создаёт и возвращает модели корзины и избранного гостя + хранилище
   *
   * @return array{GuestItemsListStore, Cart, Favorites}
 */
  private function createGuestModels(): array
  {
    $store = new GuestItemsListStore();

    $cart = new Cart($store->load('cart'));
    $fav = new Favorites($store->load('fav_list'));

    return ['store' => $store, 'cart' => $cart, 'fav' => $fav];
  }

  /**
   * Создаёт и возвращает модели корзины и избранного пользователя + хранилище
   *
   * @return array{UserItemsListStore, Cart, Favorites}
 */
  private function createUserModels(): array
  {  
    return ['store' => $this->store, 'cart' => $this->cart, 'fav' => $this->fav];
  }



  private function renderForm(RouteData $routeData): void
  {
    // Название страницы
    $page = $this->pageService->getPageBySlug($routeData->uriModule);
    $pageModel = $this->pageService->getPageModelBySlug( $routeData->uriModule );
    $seo = $this->seoService->getSeoForPage('profile-edit', $pageModel);

    $pageTitle = "Вход на сайт";
    $pageClass = "authorization-page";
    

    $currentLang =  $this->productService->currentLang;
    $languages = $this->productService->languages;
   
    $errors = $this->flash->get('errors');
    $success = $this->flash->get('success');
    ob_start();
    include ROOT . 'views/login/form-login.tpl';
    $content = ob_get_clean();

    include ROOT . "views/_page-parts/_head.tpl";
    include ROOT . "views/login/login-page.tpl";
    include ROOT . "views/_page-parts/_foot.tpl";
  }
}
