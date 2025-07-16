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
    private UserInterface $userModel;
    private Favorites $favModel;
    private array $fav;
    private FavoritesStoreInterface $favStore;
    private FlashMessage $notes;

    public function __construct(UserInterface $userModel, Favorites $favModel, array $fav, FavoritesStoreInterface $favStore, FlashMessage $notes)
    {
      $this->userModel = $userModel;
      $this->favModel = $favModel;
      $this->fav = $fav;
      $this->favStore = $favStore;
      $this->notes = $notes;
    }

    public function index(RouteData $routeData): void
    {
      // Получаем продукты
      $products = !empty($this->fav) ? ProductRepository::findByIds($this->fav) : [];
      // $totalPrice = !empty($products) ? $favModel->getTotalPrice($products) : 0;

      // Показываем страницу
      self::renderPage($routeData, $products, $this->favModel);
    }

    private function renderPage (RouteData $routeData, array $products, Favorites $favModel): void 
    {  
      /**
        * Проверяем вход пользователя в профиль
        * @var bool
      */
      $settings = Settings::all(); // Получаем массив всех настроек
      
      $pageTitle = "Избранное";

      // Хлебные крошки
      $breadcrumbs = [
        ['title' => $pageTitle, 'url' => '#'],
      ];

      // Подключение шаблонов страницы
      include ROOT . "templates/_page-parts/_head.tpl";
      include ROOT . "views/_parts/_header.tpl";
      include ROOT . "views/favorites/favorites.tpl";
      include ROOT . "views/_parts/_footer.tpl";
      include ROOT . "views/_page-parts/_foot.tpl";
    }

    public function addItem(int $productId, $routeData): void
    {
      // Добавляем новый продукт
      $this->favModel->addItem($productId);
      $this->favStore->save($this->favModel, $this->userModel);

      // Переадресация обратно на страницу товара
      header('Location: ' . HOST . 'shop/' . $productId);
      exit();
    }

    public function removeItem(int $productId): void
    {
        // Удаляем товар
        $this->favModel->removeItem($productId);
        $this->favStore->save($this->favModel, $this->userModel);

        // Переадресация обратно на страницу товара
        header('Location: ' . HOST . 'favorites');
        exit();
    }

}
