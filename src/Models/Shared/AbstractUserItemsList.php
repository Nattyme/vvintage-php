<?php
declare(strict_types=1);

namespace Vvintage\Models\Shared;

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

    abstract public function getSessionKey(): string; // обязательно для наследников
}
