<?php
declare(strict_types=1);

namespace Vvintage\Services\Cart;

use RedBeanPHP\R;
use Vvintage\Models\Cart\Cart;
use Vvintage\Models\User\User;

final class CartService 
{
    private FlashMessage $flash;

    public function __construct(FlashMessage $flash)
    {
        $this->flash = $flash;
    }
  // public function loadCartFromUser(User $user): Cart
  // {
  //   return new Cart($user->getCart()->getItems());
  // }

    /**
      * Слияние корзины (очистка куки, сохранение новой корзины в БД и сессию)
      * @param Cart $userCartModel модель корзины пользователя
      * @param Cart $guestCartModel модель корзины гостя
    */
    public function mergeCartAfterLogin(Cart $userCartModel, Cart $guestCartModel): void
    {
      $userCartProducts = $userCartModel->getItems();
      $guestCartProducts = $guestCartModel->getItems();

      foreach ($guestCartProducts as $itemId => $quantity) {
          if (!isset(  $userCartProducts[$itemId]) ) {
            $userCartModel->addCartItem($itemId);
          }
      }

      // Очищаем cookies
      $this->clearGuestCookies();

      // Обновляем сессию
      $_SESSION['logged_user']['cart'] = $userCartModel->getItems();
      $_SESSION['cart'] =  $userCartModel->getItems();
      // $_SESSION['fav_list'] = $merged['fav_list'];

      // Передаем приветствие в сессию
      $this->setWelcomeMessage();
    }

    private function clearGuestCookies()
    {
      if (isset($_COOKIE['cart'])) {
             setcookie('cart', '', time() - 3600, '/');
      }

      if (isset($_COOKIE['fav_list'])) {
          setcookie('fav_list', '', time() - 3600, '/');
      }
    }

    private function setWelcomeMessage()
    {
      if (isset($_SESSION['logged_user']['name']) && trim($_SESSION['logged_user']['name']) !== '') {
        $this->notes->pushSuccess('Здравствуйте, ' . htmlspecialchars($_SESSION['logged_user']['name']), 'Вы успешно вошли на сайт. Рады снова видеть вас');
      } else {
        $this->notes->pushSuccess('Здравствуйте!', 'Вы успешно вошли на сайт. Рады снова видеть вас');
      }  
    }

}
