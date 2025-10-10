<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin\Product;

use Vvintage\Routing\RouteData;
use Vvintage\Contracts\Brand\BrandRepositoryInterface;
use Vvintage\Controllers\Admin\BaseAdminController;
use Vvintage\Services\Admin\Product\AdminProductService;


class AdminProductController extends BaseAdminController
{
  private AdminProductService $service;

  public function __construct()
  {
    parent::__construct();
    $this->service = new AdminProductService();
  }

  public function all (RouteData $routeData)
  {
    $this->isAdmin();
    $this->setRouteData($routeData);
    $this->service->handleStatusAction($_POST);
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
    $this->service->handleStatusAction($_POST);
    $this->renderEditProduct();
  }

 
  private function renderAllProducts(): void
  {
    // Название страницы
    $pageTitle = 'Все товары';


    $productsPerPage = 9;

    // Устанавливаем пагинацию
    $pagination = pagination($productsPerPage, 'products');
    $products = $this->service->getAll($pagination);
   
    $total = $this->service->countProducts();
    $actions = $this->service->getActions();

    // Формируем единую модель для передачи в шаблон
    $productViewModel = [
        'products' => $products,
        'total' => $total,
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
    $statusList = $this->service->getStatusList();
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

    // $product = $this->service->getProductById($id);
    // $product->images = $this->service->getFlatImages($product->images);
    // Получаем модель продукта со всеми переводами и добавляем изображения
    $productModel = $this->service->getProductLocaledModelById($id, true);

    if (!$productModel) {
        http_response_code(404);
        echo 'Товар не найден';
        $this->redirect('admin/shop');
        return;
    }
   
    $this->service->setImages($productModel);
    $statusList = $this->service->getStatusList();
dd($productModel);
    // Формируем dto
    $productDto = new ProductPageDTO($productModel);

    $this->renderLayout('shop/edit',  [
      'product' => $product,
      'pageTitle' => $pageTitle,
      'routeData' => $this->routeData,
      'statusList' => $statusList,
      'flash' => $this->flash
    ]);
  }


}