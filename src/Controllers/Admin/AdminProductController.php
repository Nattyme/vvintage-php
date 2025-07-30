<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin;

use Vvintage\Routing\RouteData;
use Vvintage\Controllers\Admin\BaseAdminController;
use Vvintage\Repositories\ProductRepository;

class AdminProductController extends BaseAdminController
{
  private ProductRepository $productRepository;

  public function __construct()
  {
    parent::__construct();
    $this->productRepository = new ProductRepository();
  }

  public function all (RouteData $routeData)
  {
    $this->renderAllProducts($routeData);
  }

  
  private function renderAllProducts(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = 'Панель управления - все товары';

    // Устанавливаем пагинацию
    $pagination = pagination(4, 'products');
    $products = $this->productRepository->findAll($pagination);


    $this->renderLayout('shop/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
    ]);
  }
}