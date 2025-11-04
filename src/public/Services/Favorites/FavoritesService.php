<?php
declare(strict_types=1);

namespace Vvintage\public\Services\Favorites;

use RedBeanPHP\R;
use Vvintage\Models\Favorites\Favorites;
use Vvintage\Models\Product\Product;
use Vvintage\Models\User\User;
use Vvintage\public\Services\Messages\FlashMessage;
use Vvintage\public\Services\Shared\AbstractUserItemsListService;

use Vvintage\public\DTO\Favorites\FavItemDTO;
use Vvintage\public\DTO\Favorites\FavItemDTOFactory;


class FavoritesService extends AbstractUserItemsListService
{

   // Получаем массив  dto продуктов для избранного
  public function getListItems(): array 
  {
    $products = parent::getListItems(); // вызовет метод родителя
    return array_map(fn($product) => $this->createProductForFavDTO($product), $products);
  }

  // Метод создает dto продукта для избранного 
  private function createProductForFavDTO(?Product $product, ?string $currentLang = null): FavItemDTO
  {
    $dtoFactory = new FavItemDTOFactory();
    $dto = $dtoFactory->createFromProduct(
      product: $product,
      currentLang: $this->currentLang
    );
        
    return $dto; 
  }

}
