<?php
declare(strict_types=1);

namespace Vvintage\Public\Services\Navigation;

use Vvintage\Public\Services\Base\BaseService;

class NavigationService extends BaseService
{

  // 1️Возвращает подкатегории, у которых есть контент
  public function getSubCategoriesWithContent(array $subCategories, array $ids): array
  {

      return array_values(array_filter(
          $subCategories,
          fn($cat) => in_array($cat->id, $ids)
      ));
  }

  // 2️Возвращает главные категории, если у их подкатегорий есть контент
  public function getMainCategoriesWithContent(array $mainCategories, array $subCategories, array $ids): array
  {
      // Получаем id подкатегорий с контентом
      $subWithContent = $this->getSubCategoriesWithContent($subCategories, $ids);
     
      $parentIds = array_unique(array_map(fn($sub) => $sub->parent_id, $subWithContent));

      return array_values(array_filter(
          $mainCategories,
          fn($main) => in_array($main->id, $parentIds)
      ));
  }
}
