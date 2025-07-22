<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Security;

/** Модели */
use Vvintage\Models\User\User;
use Vvintage\Models\Cart\Cart;
use Vvintage\Models\Favorites\Favorites;
use Vvintage\Services\Auth\SessionManager;

/** Сервисы */
use Vvintage\Services\Cart\CartService;
use Vvintage\Services\Favorites\FavoritesService;
use Vvintage\Services\Auth\LoginService;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\User\UserItemsMergeService;

/** Хранилища */
use Vvintage\Store\UserItemsList\GuestItemsListStore;
use Vvintage\Store\UserItemsList\UserItemsListStore;

/** Репозитории */
use Vvintage\Repositories\UserRepository;
use Vvintage\Repositories\ProductRepository;

/** Роутинг */
use Vvintage\Routing\RouteData;

final class LoginController
{
  private UserRepository $userRepository;
  private ProductRepository $productRepository;
  private FlashMessage $notes;

  public function __construct(UserRepository $userRepository, ProductRepository $productRepository, FlashMessage $notes) 
  {
    $this->userRepository = $userRepository;
    $this->productRepository = $productRepository;
    $this->notes = $notes;
  }

  public function index(RouteData $routeData): void
  {
    if (!isset($_POST['login'])) {
      $this->renderForm($routeData);
      return;
    }

    $loginService = new LoginService($this->userRepository, $this->notes);
    $userModel = $loginService->login($_POST);

    if (!$userModel) {
      $this->renderForm($routeData);
      return;
    }

    $this->handleItemsMerge($userModel);

    // Сообщение об успехе
    $userName = $_SESSION['logged_user']['name'] ?? '';
    
    if (trim($userName) !== '') {
      $this->notes->pushSuccess(h(__('login.success.username', ['%name%' => $userName], 'messages')));
    } else {
      $this->notes->pushSuccess(h(__('login.success', [], 'messages')));
    }

    // Редирект
    header('Location: ' . HOST . 'profile');
    exit();
  }

  /**
   * Метод совмещает списки пользователя
   * @return void
  */
  private function handleItemsMerge(User $userModel): void
  {
    $guest = $this->createGuestModels();
   
    $user = $this->createUserModels();
    // Здесь возвращается guest Store
    $cartService = new CartService(
      $userModel, $guest['cart'], $guest['cart']->getItems(), $user['store'], $this->productRepository, $this->notes
    );

    $favService = new FavoritesService(
      $userModel, $guest['fav'], $guest['fav']->getItems(), $user['store'], $this->productRepository, $this->notes
    );
    $userItemsMergeService = new UserItemsMergeService($favService, $cartService);

    $userItemsMergeService->mergeAllAfterLogin(
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
    $store = new UserItemsListStore($this->userRepository);
    $cart = new Cart($store->load('cart'));
    $fav = new Favorites($store->load('fav_list'));
    
    return ['store' => $store, 'cart' => $cart, 'fav' => $fav];
  }



  private function renderForm(RouteData $routeData): void
  {
    $pageTitle = "Вход на сайт";
    $pageClass = "authorization-page";

    ob_start();
    include ROOT . 'views/login/form-login.tpl';
    $content = ob_get_clean();

    include ROOT . "views/_page-parts/_head.tpl";
    include ROOT . "views/login/login-page.tpl";
    include ROOT . "views/_page-parts/_foot.tpl";
  }
}
