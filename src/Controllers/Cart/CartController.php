<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Cart;

use RedBeanPHP\R; // Подключаем readbean
use Vvintage\Routing\Router;
use Vvintage\Routing\RouteData;
use Vvintage\Repositories\ProductRepository;
use Vvintage\Models\Settings\Settings;
use Vvintage\Models\Shop\Catalog;
use Vvintage\Models\Cart\Cart;
use Vvintage\Models\Auth\Auth;
use Vvintage\Models\User\User;
use Vvintage\Store\GuestCartStore;
use Vvintage\Models\User\GuestUser;
use Vvintage\Models\User\UserInterface;
use Vvintage\Repositories\UserRepository;

require_once ROOT . './libs/functions.php';

final class CartController
{
    public static function index(RouteData $routeData): void
    {
        /**
         * Проверяем вход пользователя в профиль
         * @var bool
         */
        $settings = Settings::all(); // Получаем массив всех настроек
dd($_SESSION);

          /**
           * Получаем модель пользователя - гость или залогоиненный
           * @var UserInreface $userModel
          */
          $userModel = Auth::getLoggedInUser();
     
        // Получаем корзину и ее модель
        $cartModel = $userModel->getCartModel();
        $cart = $userModel->getCart();
// dd($cart);
        // Получаем продукты
        $products = !empty($cart) ? ProductRepository::findByIds($cart) : [];
        $totalPrice = !empty($products) ? $cartModel->getTotalPrice($products) : 0;

        $pageTitle = "Корзина товаров";

        // Хлебные крошки
        $breadcrumbs = [
          ['title' => $pageTitle, 'url' => '#'],
        ];

        // Подключение шаблонов страницы
        include ROOT . "views/_page-parts/_head.tpl";
        include ROOT . "views/_parts/_header.tpl";
        include ROOT . "views/cart/cart.tpl";
        include ROOT . "views/_parts/_footer.tpl";
        include ROOT . "views/_page-parts/_foot.tpl";
    }

    // public static function loadCart(bool $isLoggedIn, User $user = null): Cart
    // {

    //     $cartModel = new Cart($user->getItems());

    //     if (!$user) {
    //         // Устанавливаем корзину пользователя в модель
    //         $cart = $cartModel->loadFromNotUser();

    //         return $cartModel;
    //     }

    //     // Устанавливаем корзину пользователя в модель
    //     $userId = $user->getId();
    //     $cartModel->loadFromUser($userId);

    //     // Получаем продукты и записываем в сессию
    //     // $cart = $cartModel->getItems();
    //     $_SESSION['cart'] = $cartModel->getItems();

    //     return $cartModel;
    // }

    public static function addItemToCart(int $productId, $routeData): void
    {
        /**
         * Получаем модель пользователя - гость или залогоиненный
         * @var UserInreface $userModel
        */
        $userModel = Auth::getLoggedInUser();

        // Получаем корзину и ее модель
        $cartModel = $userModel->getCartModel();
        $cart = $userModel->getCart();

        $cartModel->addCartItem($productId, $userModel);

        $updatedCart = $cartModel->getItems();

        // Обновляем параметр cart в сессии
        $cartModel->saveToSession($updatedCart);

        // Обновляем данные пользователя в БД и сессии
        if ($userModel instanceof User) {
            $userRepository = $userModel->getRepository();
            $userRepository->saveUserCart($userModel, $updatedCart);

            // обновляем сессию логина
            Auth::setUserSession($userModel);
            // Переадресация обратно на страницу товара (или корзины)
            header('Location: ' . HOST . 'shop/' . $productId);
            exit();
        }

        // Переадресация обратно на страницу товара
        header('Location: ' . HOST . 'shop/' . $productId);
        exit();
    }

    public static function removeItem(): void
    {
        /**
         * Получаем модель пользователя - гость или залогоиненный
         * @var UserInreface $userModel
        */
        $userModel = Auth::getLoggedInUser();

        // Получаем корзину и ее модель
        $cartModel = $userModel->getCartModel();
        $cart = $userModel->getCart();


        $productId = (int) $_GET['id'];
        $cartModel->removeCartItem($productId, $userModel);

        $updatedCart = $cartModel->getItems();

        // Обновляем параметр cart
        $cartModel->saveToSession($updatedCart);

        // Обновляем данные пользователя в БД и сессии
        if ($userModel instanceof User) {

            $userRepository = $userModel->getRepository();
            $userRepository->saveUserCart($userModel, $updatedCart);

            // обновляем сессию логина
            Auth::setUserSession($userModel);
        }

        // Переадресация обратно на страницу товара
        header('Location: ' . HOST . 'cart');
        exit();
    }

}
