<?php
declare(strict_types=1);

namespace Vvintage\Services\Shared;

/** Контракты */
use Vvintage\Contracts\User\UserInterface;
use Vvintage\Contracts\User\UserItemsListStoreInterface;

/** Репозитории */
use Vvintage\Services\Base\BaseService;
use Vvintage\Repositories\Product\ProductRepository;
use Vvintage\Services\Product\ProductService;

/** Модели */
use Vvintage\Models\Shared\AbstractUserItemsList;

/** Сервисы */
use Vvintage\Services\Messages\FlashMessage;

abstract class AbstractUserItemsListService extends BaseService
{
    private $userModel;
    private $itemsModel;
    private $items;
    private $itemsStore;
    private ProductService $productService;

    public function __construct( 
      UserInterface $userModel, 
      AbstractUserItemsList $itemsModel, 
      array $items, 
      UserItemsListStoreInterface $itemsStore, 
      ProductService $productService, 
      )
    {
      parent::__construct();
      $this->userModel = $userModel;
      $this->itemsModel = $itemsModel;
      $this->items = $items;
      $this->itemsStore = $itemsStore;
      $this->productService = $productService;
    }

    public function getListItems ()
    {
   
      return !empty($this->items) ? $this->productService->getProductsByIds($this->items) : [];
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
