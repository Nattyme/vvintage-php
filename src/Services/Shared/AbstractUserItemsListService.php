<?php
declare(strict_types=1);

namespace Vvintage\Services\Shared;

/** Контракты */
use Vvintage\Contracts\User\UserInterface;
use Vvintage\Contracts\User\UserItemsListStoreInterface;

/** Сервисы */
// use Vvintage\Repositories\Product\ProductRepository;
use Vvintage\Services\Product\ProductService;
use Vvintage\Services\Product\ProductImageService;
use Vvintage\Services\Locale\LocaleService;

/** Модели */
use Vvintage\Models\Shared\AbstractUserItemsList;

abstract class AbstractUserItemsListService 
{
    protected string $currentLang;

    public function __construct( 
      protected UserInterface $userModel, 
      protected AbstractUserItemsList $itemsModel, 
      protected array $items, 
      protected UserItemsListStoreInterface $itemsStore, 
      protected ProductService $productService, 
      protected ProductImageService $productImageService, 
      protected LocaleService $localeService, 
      ) {
        $this->currentLang = $localeService->getCurrentLang();
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

    public function mergeItemsListAfterLogin(
      AbstractUserItemsList $userItemsModel, 
      AbstractUserItemsList $guestItemsModel
    ): void
    {

      // Получаем список продуктов
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

}
