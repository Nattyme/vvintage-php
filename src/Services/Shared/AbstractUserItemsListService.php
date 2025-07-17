<?php
declare(strict_types=1);

namespace Vvintage\Services\Shared;

use Vvintage\Repositories\ProductRepository;
use Vvintage\Models\User\UserInterface;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Models\Shared\AbstractUserItemsList;
use Vvintage\Store\UserItemsList\ItemsListStoreInterface;


abstract class AbstractUserItemsListService
{
    private $userModel;
    private $itemsModel;
    private $items;
    private $itemsStore;
    private $productRepository;
    private FlashMessage $notes;

    public function __construct( UserInterface $userModel, AbstractUserItemsList $itemsModel, array $items, ItemsListStoreInterface $itemsStore, ProductRepository $productRepository, FlashMessage $notes)
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

    public function addItem($itemKey, $itemId)
    {
      $this->itemsModel->addItem($itemId);
      // Сохраняем в хранилище
      $this->itemsStore->save($itemKey, $this->itemsModel, $this->userModel);
    }

    public function removeItem($itemKey, int $itemId)
    {
      $this->itemsModel->removeItem($itemId);
      $this->itemsStore->save($itemKey, $this->itemsModel, $this->userModel);
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
      $_SESSION['logged_user']['cart'] = $userItemsModel->getItems();
      $_SESSION['cart'] =  $userItemsModel->getItems();
    }

    

    private function clearGuestCookies()
    {
      if (isset($_COOKIE[$this->getSessionKey()])) {
        setcookie($this->getSessionKey(), '', time() - 3600, '/');
      }
    }


    abstract public function getSessionKey(): string; // обязательно для наследников
}
