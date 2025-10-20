<?php
declare(strict_types=1);

namespace Vvintage\Services\Cart;

use RedBeanPHP\R;
use Vvintage\Models\Cart\Cart;
use Vvintage\Models\Product\Product;
use Vvintage\Models\User\User;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Shared\AbstractUserItemsListService;

use Vvintage\DTO\Cart\CartItemDTO;
use Vvintage\DTO\Cart\CartItemDTOFactory;


class CartService extends AbstractUserItemsListService
{

    // Получаем массив  dto продуктов для корзины корзины 
    public function getListItems(): array 
    {
      $products = parent::getListItems(); // вызовет метод родителя
      return array_map(fn($product) => $this->createProductForCartDTO($product), $products);
    }

    public function getCartTotalPrice($products, $cartModel)
    {
      return !empty($products) ? $cartModel->getTotalPrice($products) : 0;
    }

    // Метод создает dto продукта для корзины 
    private function createProductForCartDTO(?Product $product, ?string $currentLang = null): CartItemDTO
    {
      $dtoFactory = new CartItemDTOFactory();
      $dto = $dtoFactory->createFromProduct(
        product: $product,
        currentLang: $this->currentLang
      );
         
      return $dto; 
    }

}
