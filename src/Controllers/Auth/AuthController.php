<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Auth;

/** Роутер */
use Vvintage\Routing\Router;
use Vvintage\Routing\RouteData;

/** Модели */
use Vvintage\Models\User\User;
use Vvintage\Models\User\GuestUser;
use Vvintage\Models\Cart\Cart;
use Vvintage\Models\Favorites\Favorites;

/** Интерфейсы */
use Vvintage\Models\User\UserInterface;
use Vvintage\Store\UserItemsList\ItemsListStoreInterface;

/** Репозитории */
use Vvintage\Repositories\UserRepository;
use Vvintage\Repositories\CartRepository;
use Vvintage\Repositories\ProductRepository;

/** Сервисы */
use Vvintage\Services\Auth\SessionManager;
use Vvintage\Services\Validation\LoginValidator;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Cart\CartService;
use Vvintage\Services\Favorites\FavoritesService;

/** Store */
// use Vvintage\Store\Cart\GuestCartStore;
// use Vvintage\Store\Cart\UserCartStore;
// use Vvintage\Store\Cart\CartStoreInterface;
// use Vvintage\Store\Favorites\GuestFavoritesStore;
// use Vvintage\Store\Favorites\UserFavoritesStore;
// use Vvintage\Store\Favorites\FavoritesStoreInterface;
use Vvintage\Store\UserItemsList\GuestItemsListStore;
use Vvintage\Store\UserItemsList\UserItemsListStore;

/** Контролеры */
use Vvintage\Controllers\Cart\CartController;
use Vvintage\Controllers\Security\RegistrationController;
use Vvintage\Controllers\Security\PasswordResetController;
use Vvintage\Controllers\Security\PasswordSetNewController;
use Vvintage\Services\Security\PasswordSetNewService;

require_once ROOT . './libs/functions.php';

final class AuthController
{   
    private UserRepository $userRepository;
    private LoginValidator $validator;
    private FlashMessage $notes;

    public function __construct(
      UserRepository $userRepository, 
      LoginValidator $validator,
      FlashMessage $notes
    )
    {
      $this->userRepository = $userRepository;
      $this->validator = $validator;
      $this->notes = $notes;
    }

    public function login(ProductRepository $productRepository, RouteData $routeData): void
    {

      //1. Проверяем массив POST
      if (isset($_POST['login'])) {

          // Если ошибок нет
          if (empty($_SESSION['errors'])) {

            // Ищем нужного пользователя в базе данных
            $userModel = $this->userRepository->findUserByEmail($_POST['email']);
            
            if (!$userModel) {
              $this->notes->pushError('Неверный email');
            }

            if (empty($_SESSION['errors'])) {
                /** Получаем модель с корзиной гостя В АБСТРАКЦИЮ
                  * @var UserInterface $guestCartData 
                */
                $guestCartStore = new GuestItemsListStore();
                $guestFavStore = new GuestItemsListStore();

                $guestCart = $guestCartStore->load('cart');
                $guestFav = $guestFavStore->load('fav_list');

                // $guestCartData = (new GuestCartStore())->load();
                // $guestFavData = (new GuestFavoritesStore())->load();
                $guestCartModel = new Cart( $guestCart);
                $guestFavModel = new Favorites($guestFav);

                $cartService = new CartService(
                  $userModel, $guestCartModel, $guestCartModel->getItems(), $guestCartStore, $productRepository, $this->notes
                );
                $favService = new FavoritesService(
                  $userModel, $guestFavModel, $guestFavModel->getItems(), $guestFavStore, $productRepository, $this->notes
                );

                // Проверить пароль
                if (password_verify($_POST['password'], $userModel->getPassword())) {
                  $isLoggedIn = SessionManager::setUserSession($userModel);
              
                  /** Получаем корзину пользователя из БД
                   * @var UserInterface  $userCartData
                  */
                  $userCartStore = new UserItemsListStore($this->userRepository); 
                  $userFavStore = new UserItemsListStore($this->userRepository);
                  
                  $userCart = $userCartStore->load('cart');
                  $userFav =  $userFavStore->load('fav');

                  // Создаем модель корзины пользователя В АБСТРАКЦИЮ
                  $cartModel = new Cart( $userCart);
                  $favModel = new Favorites(  $userFav );

                  // Выполняем слияние cart и fav через Service МЕТОЖ УЖЕ В АБСТРАКЦИИ ПРОВЕРИТЬ 
                  $cartService->mergeItemsListAfterLogin($cartModel, $guestCartModel);
                  $favService->mergeItemsListAfterLogin($favModel, $guestFavModel);
   
                  $mergedCart = $cartModel->getItems();
                  $mergedFav = $favModel->getItems();
    
                  // Сохраняем в БД
                  $this->userRepository->saveUserItemsList('cart', $userModel, $mergedCart);
                  $this->userRepository->saveUserItemsList('fav_list', $userModel, $mergedFav);

                  
                  if (isset($_SESSION['logged_user']['name']) && trim($_SESSION['logged_user']['name']) !== '') {
                    $this->notes->pushSuccess('Здравствуйте, ' . htmlspecialchars($_SESSION['logged_user']['name']), 'Вы успешно вошли на сайт. Рады снова видеть вас');
                  } else {
                    $this->notes->pushSuccess('Здравствуйте!', 'Вы успешно вошли на сайт. Рады снова видеть вас');
                  }  
                  
                  
                  // Редирект
                  header('Location: ' . HOST . 'cart');
                  // header('Location: ' . HOST . 'profile');
                  exit();

                } else {
                  // Пароль не верен
                  $this->notes->pushError('Неверный пароль');
                }
            }
          }
      }

      // Показываем страницу
      self::renderPage($routeData);
    }

    private function renderPage (RouteData $routeData): void
    {
      $pageTitle = "Вход на сайт";
      $pageClass = "authorization-page";

      //Сохраняем код ниже в буфер
      ob_start();
      include ROOT . 'views/login/form-login.tpl';
      //Записываем вывод из буфера в пепеменную
      $content = ob_get_contents();
      //Окончание буфера, очищаем вывод
      ob_end_clean();

      include ROOT . "templates/_page-parts/_head.tpl";
      include ROOT . "views/login/login-page.tpl";
      include ROOT . "views/_page-parts/_foot.tpl";
    }

    public static function logout()
    {
      if (empty($_SESSION['errors'])) {
        session_destroy();
        setcookie(session_name(), '', time() - 60);

        header("Location: " . HOST);
      }

    }

    public function register( RegistrationController $controller, RouteData $routeData)
    {
      $controller->index($routeData);
    }

    public function setNewPassword( PasswordSetNewController $controller, RouteData $routeData)
    {
      $controller->index($routeData);
    }

    public function resetPassword(PasswordResetController $controller, RouteData $routeData)
    {
      $controller->index($routeData);
    }
}
