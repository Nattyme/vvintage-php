<?php
declare(strict_types=1);

namespace Vvintage\Services\Navigation;

use RedBeanPHP\R;
use Vvintage\Services\Base\BaseService;

class NavigationService extends BaseService
{

  public function __construct() 
  {

  }
  // public function getSessionKey(): string
  // {
  //   return 'fav_list';
  // }

  public function getNavigtion(
    array $categories,           // Массив категорий для отображения
    array $items,                // Массив постов или продуктов
  ): array
  {
    
    // 1. Получаем список ID категорий, у которых есть контент (посты, товары и т.д.)
    $categoryIds = array_map(fn($item) => $item->category_id, $items);

    // 2. Фильтруем категории — оставляем только те, чьи ID встречаются среди контентных
    return array_values(array_filter(
        $categories,
        fn($category) => in_array($category->getId(), $categoryIds)
    ));
  }
}
