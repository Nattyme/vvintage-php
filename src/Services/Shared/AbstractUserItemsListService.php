<?php
declare(strict_types=1);

namespace Vvintage\Services\Shared;

/** Контракты */
use Vvintage\Contracts\User\UserInterface;
use Vvintage\Contracts\User\UserItemsListStoreInterface;

/** Сервисы */
use Vvintage\Services\Product\ProductService;
use Vvintage\Services\Product\ProductImageService;
use Vvintage\Services\Locale\LocaleService;
use Vvintage\Services\Session\SessionService;

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
      protected SessionService $sessionService, 
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
      $this->sessionService->updateUserSessionData($sessionKey, $userItemsModel->getItems());
      $this->clearGuestCookies(); // Очищаем cookies
    }

    

    private function clearGuestCookies()
    {
      $sessionKey = $this->itemsModel->getSessionKey();
      $this->sessionService->clearCookies($sessionKey);
    }

}
