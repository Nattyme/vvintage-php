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

  private function handleItemsMerge(User $userModel): void
  {
    $guestCartStore = new GuestItemsListStore();
    $guestFavStore = new GuestItemsListStore();

    $guestCart = $guestCartStore->load('cart');
    $guestFav = $guestFavStore->load('fav_list');

    $guestCartModel = new Cart($guestCart);
    $guestFavoritesModel = new Favorites($guestFav);

    $cartService = new CartService(
      $userModel, $guestCartModel, $guestCartModel->getItems(), $guestCartStore, $this->productRepository, $this->notes
    );
    $favService = new FavoritesService(
      $userModel, $guestFavoritesModel, $guestFavoritesModel->getItems(), $guestFavStore, $this->productRepository, $this->notes
    );

    $userCartStore = new UserItemsListStore($this->userRepository); 
    $userFavStore = new UserItemsListStore($this->userRepository);

    $userCart = $userCartStore->load('cart');
    $userFav =  $userFavStore->load('fav');

    $userCartModel = new Cart( $userCart );
    $userFavoritesModel = new Favorites( $userFav );

    $userItemsMergeService = new UserItemsMergeService($cartService, $favService);
    
    $userItemsMergeService->mergeAllAfterLogin(
      $userCartModel,
      $guestCartModel,
      $userFavoritesModel,
      $guestFavoritesModel
    );
    


    // $userCartStore = new UserItemsListStore($this->userRepository); 
    // $userFavStore = new UserItemsListStore($this->userRepository);

    // $userCart = $userCartStore->load('cart');
    // $userFav =  $userFavStore->load('fav');

    // $cartModel = new Cart( $userCart );
    // $favModel = new Favorites( $userFav );

    // $cartService->mergeItemsListAfterLogin($cartModel, $guestCartModel);
    // $favService->mergeItemsListAfterLogin($favModel, $guestFavModel);

    // $this->userRepository->saveUserItemsList('cart', $userModel, $cartModel->getItems());
    // $this->userRepository->saveUserItemsList('fav_list', $userModel, $favModel->getItems());
  }


  private function renderForm(RouteData $routeData): void
  {
    $pageTitle = "Вход на сайт";
    $pageClass = "authorization-page";

    ob_start();
    include ROOT . 'views/login/form-login.tpl';
    $content = ob_get_clean();

    include ROOT . "templates/_page-parts/_head.tpl";
    include ROOT . "views/login/login-page.tpl";
    include ROOT . "views/_page-parts/_foot.tpl";
  }
}
