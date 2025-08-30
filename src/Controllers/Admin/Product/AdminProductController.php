<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin\Product;

use Vvintage\Routing\RouteData;
use Vvintage\Contracts\Brand\BrandRepositoryInterface;
use Vvintage\Controllers\Admin\BaseAdminController;
use Vvintage\Services\Admin\Product\AdminProductService;


class AdminProductController extends BaseAdminController
{
  private AdminProductService $adminProductService;

  public function __construct()
  {
    parent::__construct();
    $this->adminProductService = new AdminProductService();
  }

  public function all (RouteData $routeData)
  {
    $this->isAdmin();
    $this->setRouteData($routeData);
    $this->adminProductService->handleStatusAction($_POST);
    $this->renderAllProducts($routeData);
  }

  public function new(RouteData $routeData)
  {
    $this->isAdmin();
    $this->setRouteData($routeData);
    $this->renderAddProduct($routeData);
  }

  public function edit(RouteData $routeData)
  {
    $this->isAdmin();
    $this->setRouteData($routeData);
    $this->adminProductService->handleStatusAction($_POST);
    $this->renderEditProduct();
  }

 
  private function renderAllProducts(): void
  {
    // Название страницы
    $pageTitle = 'Все товары';

    $productsPerPage = 9;

    // Устанавливаем пагинацию
    $pagination = pagination($productsPerPage, 'products');
    $products = $this->adminProductService->getAll($pagination);
    $total = $this->adminProductService->countProducts();
    $actions = $this->adminProductService->getActions();

    $imagesByProductId = [];

    foreach ($products as $product) {
        $imagesMainAndOthers = $this->adminProductService->getProductImages($product);
        $imagesByProductId[$product->getId()] = $imagesMainAndOthers;
    }

    // Формируем единую модель для передачи в шаблон
    $productViewModel = [
        'products' => $products,
        'total' => $total,
        'imagesByProductId' => $imagesByProductId,
        'actions'=> $actions
    ];
        

    $this->renderLayout('shop/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $this->routeData,
      'productViewModel' => $productViewModel,
      'pagination' => $pagination,
      'flash' => $this->flash
    ]);
  }

  private function renderAddProduct(): void
  {
    // Название страницы
    $pageTitle = "Добавить новый товар";
    $statusList = $this->adminProductService->getStatusList();
    // $pageClass = "admin-page";


    $this->renderLayout('shop/new',  [
      'pageTitle' => $pageTitle,
      'routeData' => $this->routeData,
      'statusList' => $statusList,
      'flash' => $this->flash,
      'product' => null,
      'languages' => $this->languages,
      'currentLang' => $this->currentLang,
    ]);
  }

  private function renderEditProduct(): void
  {
    // Название страницы
    $pageTitle = "Редактирование товара";
    // $pageClass = "admin-page";

    // Получаем продукт по Id 
    $id = $this->routeData->uriGet ? (int) $this->routeData->uriGet : null;

    if (!$id) $this->redirect('admin/shop');

    $product = $this->adminProductService->getProductById($id);
    $statusList = $this->adminProductService->getStatusList();

    $this->renderLayout('shop/edit',  [
      'product' => $product,
      'pageTitle' => $pageTitle,
      'routeData' => $this->routeData,
      'statusList' => $statusList,
      'flash' => $this->flash
    ]);
  }


}