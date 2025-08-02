<?php
declare(strict_types=1);

namespace Vvintage\Services\Shared;

use Vvintage\Repositories\Product\ProductRepository;
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
      return !empty($this->items) ? $this->productRepository->findProductsByIds($this->items) : [];
    }

    public function addItem($itemId)
    {
      $this->itemsModel->addItem($itemId);
      $sessionKey = $this->itemsModel->getSessionKey();

      // Сохраняем в хранилище
      $this->itemsStore->save($sessionKey, $this->itemsModel, $this->userModel);
    }

    public function removeItem(int $itemId)
    {
      $this->itemsModel->removeItem($itemId);
      $sessionKey = $this->itemsModel->getSessionKey();
      $this->itemsStore->save($sessionKey, $this->itemsModel, $this->userModel);
    }

    public function mergeItemsListAfterLogin(AbstractUserItemsList $userItemsModel, AbstractUserItemsList $guestItemsModel): void
    {
   
      $userItems = $userItemsModel->getItems();
      $guestItems = $guestItemsModel->getItems();

      foreach ($guestItems as $itemId => $quantity) {
          if (!isset( $userItems[$itemId]) ) {
            $userItemsModel->addItem($itemId);
          }
      }
      
      $sessionKey = $this->itemsModel->getSessionKey();

      // Обновляем даннные пользователя 
      $this->itemsStore->save( $sessionKey, $userItemsModel, $this->userModel);

      // Обновляем сессию
      $_SESSION['logged_user'][ $sessionKey] = $userItemsModel->getItems();
      $_SESSION[  $sessionKey] =  $userItemsModel->getItems();

      // Очищаем cookies
      $this->clearGuestCookies();
    }

    

    private function clearGuestCookies()
    {
      $sessionKey = $this->itemsModel->getSessionKey();

      if (isset($_COOKIE[$sessionKey])) {
        setcookie($sessionKey, '', time() - 3600, '/');
      }
    }


    // abstract public function getSessionKey(): string; // обязательно для наследников
}
