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
use Vvintage\Store\UserItemsList\GuestItemsListStore;
use Vvintage\Store\UserItemsList\UserItemsListStore;

/** Контролеры */
use Vvintage\Controllers\Cart\CartController;
use Vvintage\Controllers\Security\LoginController;
use Vvintage\Controllers\Security\RegistrationController;
use Vvintage\Controllers\Security\PasswordResetController;
use Vvintage\Controllers\Security\PasswordSetNewController;
use Vvintage\Services\Security\PasswordSetNewService;

require_once ROOT . './libs/functions.php';

final class AuthController
{   
    // private UserRepository $userRepository;
    // private LoginValidator $validator;
    // private FlashMessage $notes;

    // public function __construct(
    //   UserRepository $userRepository, 
    //   LoginValidator $validator,
    //   FlashMessage $notes
    // )
    // {
    //   $this->userRepository = $userRepository;
    //   $this->validator = $validator;
    //   $this->notes = $notes;
    // }

    // public function login(LoginController $controller, ProductRepository $productRepository, RouteData $routeData): void
    // {
    //   $controller->index($productRepository, $routeData);
    // }

    // public static function logout()
    // {
    //   SessionManager::logout();
    // }

    // public function register( RegistrationController $controller, RouteData $routeData)
    // {
    //   $controller->index($routeData);
    // }

    // public function setNewPassword( PasswordSetNewController $controller, RouteData $routeData)
    // {
    //   $controller->index($routeData);
    // }

    // public function resetPassword(PasswordResetController $controller, RouteData $routeData)
    // {
    //   $controller->index($routeData);
    // }
}
