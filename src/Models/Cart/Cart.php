<?php

declare(strict_types=1);

namespace Vvintage\Models\Cart;

use Vvintage\Models\User\User;
use Vvintage\Repositories\UserRepository;

final class Cart
{
    private UserRepository $userRepository;
    private array $cart = [];

    public function __construct(UserRepository $userRepository, array $cart = [])
    {
        $this->userRepository = $userRepository;
        $this->cart = $cart;
    }

    public function getUserRepository(): UserRepository
    {
        return $this->userRepository;
    }


    /**
     * Загружает корзину пользователя из БД, если она не была передана вручную
    */
    public function loadFromUser(int $userId): void
    {
        $this->cart = $this->userRepository->getUserCart($userId);
    }

    public function loadFromNotUser(): array
    {
        if (isset($_COOKIE['cart'])) {
            $this->cart = json_decode($_COOKIE['cart'], true);
        } else {
            $this->cart = [];
        }
        return $this->cart;

    }


    public function getItems(): array
    {
        return $this->cart;
    }

    public function addToCart(int $productId, ?User $userModel = null): void
    {
        if ($userModel !== null) {
            $this->cart = $this->userRepository->addToUserCart($productId, $userModel);
            dd($_SESSION);
            $_SESSION['cart'] = json_encode($this->cart);
        } else {
            // 1. Загружаем старую корзину из куки (если есть)
            $cookieCart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];

            // 2. Добавляем товар
            if (!isset($cookieCart[$productId])) {
                $cookieCart[$productId] = 1;
            }

            // 3. Сохраняем обратно в куки
            setcookie('cart', json_encode($cookieCart), time() + 3600 * 24 * 7, '/');

            // 4. Обновляем локальную корзину
            $this->cart = $cookieCart;
        }

    }


    // Метод получает корзину из БД или куки и записывает её в $this->cart
    /**
     * @return array
     */
    public function loadCart(bool $isLoggedIn, User $user = null): array
    {
        if ($isLoggedIn && $user) {
            $cart = $user->getCart()->getItems();
            dd($cart);
        } else {

            // 1. Проверить наличие корзины пользователя
            // 2. Если корзина есть - работаем с ней, если нет - создаем новую
            if (isset($_COOKIE['cart'])) {
                // Получаем корзину из COOKIE
                $cart = json_decode($_COOKIE['cart'], true);
            } else {
                $cart = [];
            }
        }

        $this->cart = $cart;
        return $cart;
    }

    public function getQuantity($productId): int
    {
        // Проверяем, есть ли товар в корзине
        return $this->cart[(int) $productId] ?? 0; // если товара нет, возвращаем 0
    }

    public function getTotalPrice(array $products): int
    {

        $total = 0;
        foreach ($this->cart as $id => $quantity) {
            if (isset($products[$id])) {
                $total = $total + $products[$id]['price'] * $quantity;
            }
        }

        return $total;
    }

    public function setProductsInCart(array $products): void
    {
        if (!empty($products)) {
            foreach ($products as $itemKey => $quantity) {
                if (!isset($this->cart[$itemKey])) {
                    $this->cart[$itemKey] = 1;
                }
            }
        }
    }

    //Слияние корзины (очистка куки, сохранение новой корзины в БД и сессию)
    public function mergeCartAfterLogin(User $user, array $cookieCart): void
    {
        print_r("Функция совмещения корзин после логина");
        $userId = $user->getId();

        // 1. Получаем корзину пользователя из БД (или создаём пустую)
        $cartModel = $user->getCartModel();

        /**
         * @return void
         */
        $cartModel->setProductsInCart($cookieCart);


        // Обновляем корзину пользователя
        $cart = $cartModel->getItems();
        $userRepository = $cartModel->getUserRepository();

        // Если получена корзина и id пользователя - обновляем в БД
        if ($userId && $cart) {
            $userRepository->saveUserCart($userId, $cart);
        }

        // Очищаем cookies
        if (isset($_COOKIE['cart'])) {
            setcookie('cart', '', time() - 3600, '/');

        }
        if (isset($_COOKIE['fav_list'])) {
            setcookie('fav_list', '', time() - 3600, '/');
        }

        // Обновляем сессию
        $_SESSION['cart'] = json_encode($cart);
        // $_SESSION['fav_list'] = $merged['fav_list'];

        if (isset($_SESSION['logged_user']['name']) && trim($_SESSION['logged_user']['name']) !== '') {
            $_SESSION['success'][] = ['title' => 'Здравствуйте, ' . htmlspecialchars($_SESSION['logged_user']['name']), 'desc' => 'Вы успешно вошли на сайт. Рады снова видеть вас'];
        } else {
            $_SESSION['success'][] = ['title' => 'Здравствуйте!', 'desc' => 'Вы успешно вошли на сайт. Рады снова видеть вас'];
        }
    }

    public function isSessionCartStale(): bool
    {
        $sessionCart = json_decode($_SESSION['cart'] ?? '[]', true);
        return $sessionCart !== $this->cart;
    }

    public function saveToSession()
    {
        $_SESSION['cart'] = isset($_SESSION['cart']) ? json_encode($this->$cart) : '[]';
    }


}
