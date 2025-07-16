<?php
declare(strict_types=1);

namespace Vvintage\Services\Shared;

use Vvintage\Repositories\ProductRepository;
use Vvintage\Services\Messages\FlashMessage;


abstract class AbstractUserItemsListService
{
    private $userModel;
    private $model;
    private $items;
    private $itemsStore;
    private $itemsRepository;
    private FlashMessage $notes;

    public function __construct($userModel, $model, $items, $itemsStore, $itemsRepository, FlashMessage $notes)
    {
      $this->userModel = $userModel;
      $this->model = $model;
      $this->items = $items;
      $this->itemsStore = $itemsStore;
      $this->itemsRepository = $itemsRepository;
      $this->notes = $notes;
    }

    public function getListItems ()
    {
      return !empty($this->items) ? $this->itemsRepository->findByIds($this->items) : [];
    }

    public function addItem($itemId)
    {
      $this->model->addItem($itemId);
      // Сохраняем в хранилище
      $this->itemsStore->save($this->model, $this->userModel);
    }

    public function removeItem(int $itemId)
    {
      $this->model->removeItem($itemId);
      $this->itemsStore->save($this->model, $this->userModel);
    }

    public function mergeItemsListAfterLogin($userItemsModel, $guestItemsModel): void
    {
      $userItems = $userItemsModel->getItems();
      $guestItems = $guestItemsModel->getItems();

      foreach ($guestItems as $itemId => $quantity) {
          if (!isset( $userItems[$itemId]) ) {
            $userItemsModel->addItem($itemId);
          }
      }

      // Очищаем cookies
      $this->clearGuestCookies();

      // Обновляем сессию
      $_SESSION['logged_user']['cart'] = $userCartModel->getItems();
      $_SESSION['cart'] =  $userCartModel->getItems();
      // $_SESSION['fav_list'] = $merged['fav_list'];
    }

    

    // private function clearGuestCookies()
    // {
    //   if (isset($_COOKIE[$this->getSessionKey()])) {
    //     setcookie($this->getSessionKey(), '', time() - 3600, '/');
    //   }

    //   // if (isset($_COOKIE['fav_list'])) {
    //   //     setcookie('fav_list', '', time() - 3600, '/');
    //   // }
    // }


    // abstract public function getSessionKey(): string; // обязательно для наследников
}
