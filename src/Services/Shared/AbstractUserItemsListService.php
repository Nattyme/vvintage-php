<?php
declare(strict_types=1);

namespace Vvintage\Services\Shared;

use Vvintage\Repositories\ProductRepository;
use Vvintage\Services\Messages\FlashMessage;


abstract class AbstractUserItemsListService
{
    private $userModel;
    private $itemsModel;
    private $items;
    private $itemsStore;
    private $itemsRepository;
    private FlashMessage $notes;

    public function __construct(UserInterface $userModel, $itemsModel, $items, $itemsStore, ProductRepository $productRepository, FlashMessage $notes)
    {
      $this->userModel = $userModel;
      $this->itemsModel = $itemsModel;
      $this->items = $items;
      $this->itemsStore = $itemsStore;
      $this->productRepository = $productRepository;
      $this->notes = $notes;
    }

    public function getListItems ()
    {
      return !empty($this->items) ? $this->productRepository->findByIds($this->items) : [];
    }

    public function addItem($itemId)
    {
      $this->itemsModel->addItem($itemId);
      // Сохраняем в хранилище
      $this->itemsStore->save($this->itemsModel, $this->userModel);
    }

    public function removeItem(int $itemId)
    {
      $this->itemsModel->removeItem($itemId);
      $this->itemsStore->save($this->itemsModel, $this->userModel);
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

    

    private function clearGuestCookies()
    {
      if (isset($_COOKIE[$this->getSessionKey()])) {
        setcookie($this->getSessionKey(), '', time() - 3600, '/');
      }
    }


    abstract public function getSessionKey(): string; // обязательно для наследников
}
