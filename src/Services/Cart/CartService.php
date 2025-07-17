<?php
declare(strict_types=1);

namespace Vvintage\Services\Cart;

use RedBeanPHP\R;
use Vvintage\Models\Cart\Cart;
use Vvintage\Models\User\User;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Shared\AbstractUserItemsListService;


final class CartService extends AbstractUserItemsListService
{
    public function getCartTotalPrice($products, $cartModel)
    {
      return !empty($products) ? $cartModel->getTotalPrice($products) : 0;
    }
  
    /**
      * Слияние корзины (очистка куки, сохранение новой корзины в БД и сессию)
      * @param Cart $userCartModel модель корзины пользователя
      * @param Cart $guestCartModel модель корзины гостя
    */
    // public function mergeCartAfterLogin(Cart $userCartModel, Cart $guestCartModel): void
    // {
    //   $userCartProducts = $userCartModel->getItems();
    //   $guestCartProducts = $guestCartModel->getItems();

    //   foreach ($guestCartProducts as $itemId => $quantity) {
    //       if (!isset( $userCartProducts[$itemId]) ) {
    //         $userCartModel->addItem($itemId);
    //       }
    //   }

    //   // Очищаем cookies
    //   $this->clearGuestCookies();

    //   // Обновляем сессию
    //   $_SESSION['logged_user']['cart'] = $userCartModel->getItems();
    //   $_SESSION['cart'] =  $userCartModel->getItems();
    //   // $_SESSION['fav_list'] = $merged['fav_list'];

    //   // Передаем приветствие в сессию
    //   // $this->setWelcomeMessage();
    // }

  public function getSessionKey(): string
  {
      return 'cart';
  }

}
