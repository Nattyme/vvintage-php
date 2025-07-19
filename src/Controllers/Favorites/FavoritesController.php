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
// use Vvintage\Store\Favorites\GuestFavoritesStore;
// use Vvintage\Store\Favorites\UserFavoritesStore;
// use Vvintage\Store\Favorites\FavoritesStoreInterface;
/** Хранилище */
use Vvintage\Store\UserItemsList\GuestItemsListStore;
use Vvintage\Store\UserItemsList\UserItemsListStore;

use Vvintage\Repositories\UserRepository;
use Vvintage\Services\Messages\FlashMessage;

/** Сервисы */
use Vvintage\Services\Favorites\FavoritesService;


/** Абстракции */
use Vvintage\Models\Shared\AbstractUserItemsList;

/** Интерфейсы */
use Vvintage\Models\User\UserInterface;
use Vvintage\Store\UserItemsList\ItemsListStoreInterface;


require_once ROOT . './libs/functions.php';

final class FavoritesController
{
    private FavoritesService $favService;
    private UserInterface $userModel;
    private Favorites $favModel;
    private array $fav_list;
    private ItemsListStoreInterface $favStore;
    private FlashMessage $notes;

    public function __construct(
      FavoritesService $favService, 
      UserInterface $userModel, 
      Favorites $favModel, 
      array $fav_list, 
      ItemsListStoreInterface $favStore, 
      FlashMessage $notes)
    {
      $this->favService = $favService;
      $this->userModel = $userModel;
      $this->favModel = $favModel;
      $this->fav_list = $fav_list;
      $this->favStore = $favStore;
      $this->notes = $notes;
    }

    public function index(RouteData $routeData): void
    {
      // Получаем продукты
      $products = !empty($this->fav_list) ? ProductRepository::findByIds($this->fav_list) : [];
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
      // Передаем ключ для сохранения куки и id продукта
      $this->favService->addItem($productId);

      // Добавляем новый продукт
      // $this->favModel->addItem($productId);
      // $this->favStore->save($this->favModel, $this->userModel);

      // Переадресация обратно на страницу товара
      header('Location: ' . HOST . 'shop/' . $productId);
      exit();
    }

    public function removeItem(int $productId): void
    {      

        // Удаляем товар
        $this->favService->removeItem($productId);
        // $this->favStore->save($this->favModel, $this->userModel);

        // Переадресация обратно на страницу товара
        header('Location: ' . HOST . 'favorites');
        exit();
    }

}
