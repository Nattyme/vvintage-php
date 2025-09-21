<?php
declare(strict_types=1);

namespace Vvintage\Models\Shared;

use Vvintage\Models\User\User;
use Vvintage\Models\User\UserInterface;
use Vvintage\Repositories\User\UserRepository;
use Vvintage\Store\UserItemsList\UserItemsListStore;
use Vvintage\Store\UserItemsList\GuestItemsListStore;


abstract class AbstractUserItemsList
{
    protected array $items; //  protected - чтобы наследники могли обращаться

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(int $productId): void
    {
        if (!isset($this->items[$productId])) {
            $this->items[$productId] = 1;
        }
    }

    public function removeItem(int $productId): void
    {
        if (isset($this->items[$productId])) {
            unset($this->items[$productId]);
        }
    }

    public function getQuantity(int $productId): int
    {
        return $this->items[$productId] ?? 0;
    }

    public function clearItems(): void
    {
      $this->items =[];
    }

    
    public function clear($userModel, $itemModel): void
    {
      $itemModel->clearItems();
      $itemKey = $itemModel->getSessionKey();

      if($userModel instanceof User) {
        $store = new UserItemsListStore( new UserRepository());
        $store->save($itemKey, $itemModel, $userModel);
      } else {
        $store = new GuestItemsListStore();
        $store->save($itemKey, $itemModel, $userModel);
      }
    }


    // обязательно для наследников
    abstract public function getSessionKey(): string;  
  }
