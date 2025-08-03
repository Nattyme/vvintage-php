<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin;

use Vvintage\Routing\RouteData;

/** Контроллеры */
use Vvintage\Controllers\Admin\BaseAdminController;

/** Репозитории */
use Vvintage\Repositories\Brand\BrandRepository;


/** Сервисы */
// use Vvintage\Services\Admin\AdminStatsService;

class AdminBrandController extends BaseAdminController 
{
  private BrandRepository $brandRepository;

  public function __construct()
  {
    parent::__construct();
    $this->brandRepository = new BrandRepository();
  }

  public function all (RouteData $routeData)
  {
    $this->isAdmin();
    $this->renderAllBrands($routeData);
  }

  private function renderAllBrands(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = 'Бренды';

    $brandsPerPage = 9;

    // Устанавливаем пагинацию
    $pagination = pagination($brandsPerPage, 'brands');
    $brands = $this->brandRepository->getAllBrands($pagination);
    $total = $this->brandRepository->getAllBrandsCount();
        
    $this->renderLayout('brands/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'brands' => $brands,
      'pagination' => $pagination
    ]);

  }

}