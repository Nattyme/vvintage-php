<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Auth;

use Vvintage\Routing\Router;
use Vvintage\Routing\RouteData;
use Vvintage\Services\Auth\SessionManager;
use Vvintage\Models\User\User;
use Vvintage\Models\Cart\Cart;
use Vvintage\Models\Favorites\Favorites;
use Vvintage\Repositories\UserRepository;
use Vvintage\Repositories\CartRepository;
use Vvintage\User\GuestUser;
use Vvintage\User\UserInterface;
use Vvintage\Store\Cart\GuestCartStore;
use Vvintage\Store\Cart\UserCartStore;
use Vvintage\Store\Cart\CartStoreInterface;
use Vvintage\Controllers\Cart\CartController;
use Vvintage\Store\Favorites\GuestFavoritesStore;
use Vvintage\Store\Favorites\UserFavoritesStore;
use Vvintage\Store\Favorites\FavoritesStoreInterface;
use Vvintage\Services\Validation\LoginValidator;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Cart\CartService;
use Vvintage\Services\Favorites\FavoritesService;

require_once ROOT . './libs/functions.php';

final class AuthController
{
    public static function login(RouteData $routeData): void
    {

      //1. Проверяем массив POST
      if (isset($_POST['login'])) {
        $userRepository = new UserRepository();
        $notes = new FlashMessage ();   
        $validator = new LoginValidator( $userRepository, $notes);
        $cartService = new CartService( $notes );
        $favService = new FavoritesService( $notes );

          // Если ошибок нет
          if (empty($_SESSION['errors'])) {

            // Ищем нужного пользователя в базе данных
            $userModel = $userRepository->findUserByEmail($_POST['email']);

            if (!$userModel) {
              $notes->pushError('Неверный email');
            }

            if (empty($_SESSION['errors'])) {

                /** Получаем модель с корзиной гостя
                  * @var UserInterface $guestCartData 
                */
                $guestCartData = (new GuestCartStore())->load();
                $guestFavData = (new GuestFavoritesStore())->load();
                $guestCartModel = new Cart( $guestCartData);
                $guestFavModel = new Favorites( $guestFavData);

                // Проверить пароль
                if (password_verify($_POST['password'], $userModel->getPassword())) {
                  $isLoggedIn = SessionManager::setUserSession($userModel);
              
                  /** Получаем корзину пользователя из БД
                   * @var UserInterface  $userCartData
                  */
                  $userCartData = ( new UserCartStore($userRepository) ) -> load(); 
                  $userFavData = ( new UserFavoritesStore($userRepository) ) -> load(); 

                  // Создаем модель корзины пользователя
                  $cartModel = new Cart( $userCartData );
                  $favModel = new Favorites( $userFavData );

                  // Выполняем слияние cart и fav через Service
                  $cartService->mergeCartAfterLogin($cartModel, $guestCartModel);
                  $favService->mergeFavAfterLogin($favModel, $guestFavModel);
          
                  $mergedCart = $cartModel->getItems();
                  $mergedFav = $favModel->getItems();

                  // Сохраняем в БД
                  $userRepository->saveUserCart($userModel, $mergedCart);
                  $userRepository->saveUserFav($userModel, $mergedFav);
                  
                  // Редирект
                  header('Location: ' . HOST . 'cart');
                  // header('Location: ' . HOST . 'profile');
                  exit();

                } else {
                    // Пароль не верен
                    $notes->pushError('Неверный пароль');
                }
            }
          }
      }

      // Показываем страницу
      self::renderPage($routeData);
    }

    private static function renderPage (RouteData $routeData): void
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

    }

    public static function register()
    {

    }

    public static function setNewPassword()
    {

    }
}
