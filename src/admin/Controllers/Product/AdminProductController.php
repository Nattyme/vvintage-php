<?php
declare(strict_types=1);

namespace Vvintage\Admin\Controllers\Product;

use Vvintage\Routing\RouteData;
use Vvintage\Admin\Controllers\BaseAdminController;

use Vvintage\Contracts\Brand\BrandRepositoryInterface;
use Vvintage\admin\Services\Product\AdminProductService;
use Vvintage\DTO\Product\Filter\ProductFilterDTO;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Session\SessionService;

class AdminProductController extends BaseAdminController
{
  private AdminProductService $service;

  public function __construct(
    FlashMessage $flash,
    SessionService $sessionService
  )
  {
    parent::__construct($flash, $sessionService);
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
    $productsPerPage = 12;
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

    $filterDto = new ProductFilterDTO([
      'brands'    => $_GET['brand'] ?? [],
      'categories'=> $_GET['category'] ?? [],
      'priceMin'  => $_GET['priceMin'] ?? null,
      'priceMax'  => $_GET['priceMax'] ?? null,
      'sort'      => $_GET['sort'] ?? null,
      'page' =>  $page,
      'perPage' => (int) $productsPerPage ?? 10
    ]);

    // Получаем продукты с учётом пагинации
    $filteredProductsData = $this->service->getAdminProductsList( filters: $filterDto, perPage: 15);

    $filters = $filteredProductsData['filters'];
    $pagination = $filters->pagination;
    $actions = $this->service->getActions();

    // Формируем единую модель для передачи в шаблон
    $pageViewModel = [
        'products' => $filteredProductsData['products'],
        'total' => $filteredProductsData['total'],
        'actions'=> $actions
    ];
        

    $this->renderLayout('shop/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $this->routeData,
      'pageViewModel' => $pageViewModel,
      'pagination' => $pagination,
      'flash' => $this->flash
    ]);
  }

  private function renderAddProduct(): void
  {
    // Название страницы
    $pageTitle = "Добавить новый товар";
    $statusList = $this->service->getStatusList();


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

    // Получаем продукт по Id 
    $id = $this->routeData->uriGet ? (int) $this->routeData->uriGet : null;

    if (!$id) $this->redirect('admin/shop');

    // Получаем модель продукта со всеми переводами и добавляем изображения
    $productDTO = $this->service->getAdminEditProduct($id);
  
    if (!$productDTO) {
        http_response_code(404);
        echo 'Товар не найден';
        $this->redirect('admin/shop');
        return;
    }
 
    $statusList = $this->service->getStatusList();



    $this->renderLayout('shop/edit',  [
      'product' => $productDTO,
      'pageTitle' => $pageTitle,
      'routeData' => $this->routeData,
      'statusList' => $statusList,
      'flash' => $this->flash
    ]);
  }


}