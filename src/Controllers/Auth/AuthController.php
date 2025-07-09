<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Auth;

use Vvintage\Routing\Router;
use Vvintage\Routing\RouteData;
use Vvintage\Services\Auth\SessionManager;
use Vvintage\Models\User\User;
use Vvintage\Models\Cart\Cart;
use Vvintage\Repositories\UserRepository;
use Vvintage\Repositories\CartRepository;
use Vvintage\User\GuestUser;
use Vvintage\User\UserInterface;
use Vvintage\Store\Cart\GuestCartStore;
use Vvintage\Store\Cart\UserCartStore;
use Vvintage\Store\Cart\CartStoreInterface;
use Vvintage\Controllers\Cart\CartController;
use Vvintage\Services\Validation\LoginValidator;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Cart\CartService;

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

            // Если ошибок нет
            if (empty($_SESSION['errors'])) {

              // Ищем нужного пользователя в базе данных
              $userModel = $userRepository->findUserByEmail($_POST['email']);

              if (!$userModel) {
                $_SESSION['errors'][] = ['title' => 'Неверный email'];
              }

              if (empty($_SESSION['errors'])) {

                  /** Получаем модель с корзиной гостя
                    * @var UserInterface $guestCartData 
                  */
                  $guestCartData = (new GuestCartStore())->load();
                  $guestCartModel = new Cart( $guestCartData);

                  // Проверить пароль
                  if (password_verify($_POST['password'], $userModel->getPassword())) {
                  
                    $isLoggedIn = SessionManager::setUserSession($userModel);

                
                    /** Получаем корзину пользователя из БД
                     * @var UserInterface  $userCartData
                    */
                    $userCartData = ( new UserCartStore($userRepository) ) -> load(); 

                    // Создаем модель корзины пользователя
                    $cartModel = new Cart( $userCartData );

                    // Выполняем слияние через CartService
                    $cartService = new \Vvintage\Services\Cart\CartService();
                    $cartService->mergeCartAfterLogin($cartModel, $guestCartModel);
            
                    $mergedCart = $cartModel->getItems();
                  
                    // $cart = CartController::loadCart($isLoggedIn, $userModel); // передаем объект User

                    // Редирект
                    header('Location: ' . HOST . 'cart');
                    // header('Location: ' . HOST . 'profile');
                    exit();

                  } else {
                      // Пароль не верен
                      $_SESSION['errors'][] = ['title' => 'Неверный пароль'];
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

      include ROOT . "views/_page-parts/_head.tpl";
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
