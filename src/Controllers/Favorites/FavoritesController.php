<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Favorites;

use Vvintage\Routing\Router;
use Vvintage\Routing\RouteData;
use Vvintage\Repositories\ProductRepository;
use Vvintage\Models\Settings\Settings;
use Vvintage\Models\Shop\Catalog;
use Vvintage\Models\Favorites\Favorites;
use Vvintage\Services\Auth\SessionManager;
use Vvintage\Models\User\User;
use Vvintage\Models\User\GuestUser;
use Vvintage\Store\Favorites\GuestFavoritesStore;
use Vvintage\Store\Favorites\UserFavoritesStore;
use Vvintage\Store\Favorites\FavoritesStoreInterface;
use Vvintage\Models\User\UserInterface;
use Vvintage\Repositories\UserRepository;
use Vvintage\Services\Messages\FlashMessage;

require_once ROOT . './libs/functions.php';

final class FavoritesController
{
    public static function index(RouteData $routeData): void
    {
      /**
       * Получаем модель пользователя - гость или залогиненный
       * @var UserInreface $userModel
      */
      $userModel = SessionManager::getLoggedInUser();
    
      // Получаем корзину и ее модель
      $favModel = $userModel->getFavModel();
      $fav = $userModel->getFav();

      // Получаем продукты
      $products = !empty($fav) ? ProductRepository::findByIds($fav) : [];
      $totalPrice = !empty($products) ? $favModel->getTotalPrice($products) : 0;

      // Показываем страницу
      self::renderPage($routeData, $products, $favModel, $totalPrice);
    }

    private static function renderPage (RouteData $routeData, array $products, Favorites $favModel, int $totalPrice): void 
    {  
      /**
        * Проверяем вход пользователя в профиль
        * @var bool
      */
      $settings = Settings::all(); // Получаем массив всех настроек
      
      $pageTitle = "Корзина товаров";

      // Хлебные крошки
      $breadcrumbs = [
        ['title' => $pageTitle, 'url' => '#'],
      ];

      // Подключение шаблонов страницы
      include ROOT . "views/_page-parts/_head.tpl";
      include ROOT . "views/_parts/_header.tpl";
      include ROOT . "views/favorites/favorites.tpl";
      include ROOT . "views/_parts/_footer.tpl";
      include ROOT . "views/_page-parts/_foot.tpl";
    }

    public static function addItem(int $productId, $routeData): void
    {
  
      /**
       * Получаем модель пользователя - гость или залогоиненный
       * @var UserInreface $userModel
      */
      $userModel = SessionManager::getLoggedInUser();
    
      // Получаем корзину и ее модель
      $favModel = $userModel->getFavModel();
      $fav = $userModel->getFav();

      // Добавляем новый продукт
      $favModel->addFavItem($productId);

      /**
       * Сохраняем в нужное хранилище
       * @var FavoritesStoreInterface $cartStore;
       */
      $favStore = ($userModel instanceof User) 
                    ? new UserFavStore( new UserRepository() ) 
                    : new GuestFavStore();

      $favStore->save($favModel, $userModel);

      // Переадресация обратно на страницу товара
      header('Location: ' . HOST . 'shop/' . $productId);
      exit();
    }

    public static function removeItem(int $productId): void
    {
        /**
         * Получаем модель пользователя - гость или залогиненный
         * @var UserInreface $userModel
        */
        $userModel = SessionManager::getLoggedInUser();

        // Получаем корзину и ее модель
        $favModel = $userModel->getFavModel();
        $fav = $userModel->getFav();

        // Удаляем товар
        $favModel->removeFavItem($productId);

        /**
         * Сохраняем в нужное хранилище
         * @var FavStoreInterface $cartStore;
         */
        $favStore = ($userModel instanceof User) 
                     ? new UserFavStore( new UserRepository() ) 
                     : new GuestFavStore();

        $favStore->save($favModel, $userModel);

        // Переадресация обратно на страницу товара
        header('Location: ' . HOST . 'fav');
        exit();
    }

}
