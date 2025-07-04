<?php

declare(strict_types=1);

namespace Vvintage\Services;

// use Vvintage\Repositories\CartRepository;
use Vvintage\Repositories\UserRepository;
use Vvintage\Models\User\User;
use Vvintage\Models\Cart\Cart;

final class CartService
{
    // private CartRepository  $cartRepository;

    // Создает экземпляр
    // public function __construct ( CartRepository $cartRepository)
    // {
    //   $this->cartRepository = $cartRepository;
    // }

    public function addItem(int $productId, bool $isLoggedIn, User $user = null): void
    {
        if ($isLoggedIn) {
            $userId = $user->getId();

            // Работа с моделью и данными корзины
            $cartModel = new Cart(new UserRepository());
            $cartModel->addToCart($userId, $productId);  // Добавляем товар в корзину БД
            $cartModel->loadFromUser((int) $userId);   // Устанавливаем новые данные по корзине в модель
            dd($cartModel->getItems());
            // Получаем продукты
            $products = $cartModel->getItems();


            // Обноваляем пользователя в БД
            // Обноваляем пользователя в БД
            $userRepository = new UserRepository();
            $userRepository->saveUser($user);
            // R::store($user);

            // Обновляем состояние корзины в сессии. Сохраняем сообщение о добавлении товара
            $_SESSION['cart'] = $cart;
            $_SESSION['success'][] = ['title' => 'Товар добавлен в корзину.'];

        }

        // Пользователь НЕ вошел в профиль
        // 1. Проверить наличие корзины пользователя
        // 2. Если корзина есть - работаем с ней, если нет - создаем новую
        if (!$isLoggedIn) {
            // Получаем корзину из COOKIE
            $cart = json_decode($_COOKIE['cart'] ?? '[]', true);

            // 3. Добавляем товар в корзину, если его там нет
            if (!isset($cart[$productId])) {
                // Формируем корзину в ассоциативный массив
                $cart[$productId] = 1;

                // 4. Сохранение корзины в COOKIE
                setcookie('cart', json_encode($cart), [
                  'expires' => time() + 60 * 60 * 24 * 30,
                  'path' => '/',
                  'secure' => true, // только через HTTPS
                  'httponly' => true, //Недоступно из JS
                  'samesite' => 'Strict'
                ]);

                // 5. Сообщение о добавлении товара
                $_SESSION['success'][] = ['title' => 'Товар добавлен в корзину.'];

                header('Location: ' . HOST . 'shop/' . $productId);
                exit();
            }
        }

    }

    public function removeItem(bool $isLoggedIn, int $userId): void
    {
        if ($isLoggedIn) {
            // Находим пользователя в БД по id
            $user = self::getUser($_SESSION['logged_user']['id']);

            // Получаем корзину из БД
            $cart = json_decode($user->cart, true);

            // Удаляем товар из корзины
            unset($cart[$_GET['id']]);

            // Превращаем корзину в json строку
            $user->cart = json_encode($cart);

            // Обноваляем пользователя в БД
            $userRepository = new UserRepository();
            $userRepository->saveUser($user);
            // R::store($user);

            // Обновляем состояние корзины в сессии
            $_SESSION['cart'] = $cart;

            // Сообщение об удалении товара
            $_SESSION['success'][] = ['title' => 'Товар был удалён из корзины.'];
        }

        if (!$isLoggedIn) {
            if (isset($_COOKIE['cart'])) {
                // Получаем корзину из COOKIE
                $cart = json_decode($_COOKIE['cart'], true);
            } else {
                $cart = [];
            }

            // 3. Удаляем товар из корзины
            unset($cart[$_GET['id']]);

            // 4. Сохранение корзины в COOKIE
            setcookie('cart', json_encode($cart), time() + 60 * 60 * 24 * 30);

            // Сообщение об удалении товара
            $_SESSION['success'][] = ['title' => 'Товар был удалён из корзины.'];
        }

        header('Location: ' . HOST . 'cart');
        exit();
    }



}
