<?php

declare(strict_types=1);

namespace Vvintage\Models\Cart;

use Vvintage\Models\User\User;
use Vvintage\Models\User\UserInterface;
use Vvintage\Repositories\UserRepository;

final class Cart
{
    private array $cart;

    public function __construct( array $cart)
    {
        $this->cart = $cart;
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

    public function addCartItem(int $productId)
    {
      // Добавляем новый товар
      if (!isset($this->cart[$productId])) {
          $this->cart[$productId] = 1;
      }
    }

    public function removeCartItem(int $productId, ?UserInterface $userModel)
    {
        // Если залогинен 
        if ($userModel instanceof User) {
            // Удаляем товар из модели
            if (!isset($this->cart[$productId])) {
                return;
            }

            unset($this->cart[$productId]);
// dd($this->userRepository);
            // // Обновляем корзину в БД
            // $this->userRepository->saveUserCart($userModel, $this->cart);
        } else {
            // 1. Загружаем старую корзину из куки (если есть)
            $cookieCart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];

            // 2. Добавляем товар
            if (!isset($cookieCart[$productId])) {
                return;
            }

            unset($cookieCart[$productId]);

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
        return isset($this->cart[(int)$productId])
            ? (int)$this->cart[(int)$productId]
            : 0;
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


    /**
      * Слияние корзины (очистка куки, сохранение новой корзины в БД и сессию)
      * @param User $user модель пользователя
      * @param Cart $cookieCart модель корзины
    */
    public function mergeCartAfterLogin(array $guestCart): void
    {
        print_r("Функция совмещения корзин после логина");
     

        if (!empty($guestCart)) {
            foreach ($guestCart as $itemKey => $quantity) {
                if (!isset($this->cart[$itemKey])) {
                    $this->cart[$itemKey] = 1;
                }
            }
        }

        // Очищаем cookies
        if (isset($_COOKIE['cart'])) {
            setcookie('cart', '', time() - 3600, '/');

        }
        if (isset($_COOKIE['fav_list'])) {
            setcookie('fav_list', '', time() - 3600, '/');
        }

        // Обновляем сессию
        $_SESSION['logged_user']['cart'] = json_encode($this->cart);
        $_SESSION['cart'] = json_encode($this->cart);
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

    public function saveToSession($cart)
    {

        if (isset($_SESSION['cart'])) {
            $_SESSION['cart'] = !empty($_SESSION['cart']) ? $cart : '[]';
        }
    }


}
