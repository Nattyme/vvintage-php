<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin\Order;

use Vvintage\Routing\RouteData;
use Vvintage\Controllers\Admin\BaseAdminController;
use Vvintage\Repositories\Order\OrderRepository;

/** Сервис */
use Vvintage\Services\Admin\Order\AdminOrderService;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Base\BaseService;


class AdminOrderController extends BaseAdminController 
{   
  private const TABLE_ORDERS = 'orders';
  private const PAGE_ORDERS_ALL = 'Все заказы';
  private const PAGE_ORDERS_SINGLE = 'Заказ №';
  private const PAGE_ORDERS_DELETE = 'Удаление заказа №';

  // private OrderRepository $orderRepository;
  private AdminOrderService $adminOrderService;


  public function __construct(FlashMessage $notes)
  {
    parent::__construct();
    $this->adminOrderService = new AdminOrderService($notes);
  }

  public function all(RouteData $routeData)
  {
    $this->isAdmin();
    $this->adminOrderService->handleStatusAction($_POST);
    $this->renderAll($routeData);
  }

  public function single(RouteData $routeData)
  {
    $this->isAdmin();
    $this->renderSingle($routeData);
  }

  public function delete(RouteData $routeData)
  {
    $this->isAdmin();
    $this->renderSingle($routeData);
  }


  private function renderAll(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = self::PAGE_ORDERS_ALL;

    // Получаем данные из GET-запроса
    $searchQuery = $_GET['query'] ?? '';
    $filterSection = $_GET['action'] ?? ''; // имя селекта - action

    $ordersPerPage = 9;

    // Устанавливаем пагинацию
    $pagination = pagination($ordersPerPage, self::TABLE_ORDERS);

    $orders = $this->adminOrderService->getAllOrders($pagination);
    $total = $this->adminOrderService->getAllOrdersCount();
 
    $actions = $this->adminOrderService->getActions();
    $statusData = $this->adminOrderService->getStatusData();

    $orderViewModel = [
      'total' => $total,
      'orders' => $orders,
      'searchQuery' => $searchQuery,
      'actions'=> $actions,
      'statusData' => $statusData
    ];
        
    $this->renderLayout('orders/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'pagination' => $pagination,
      'orderViewModel' => $orderViewModel
    ]);

  }

  private function renderSingle(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = self::PAGE_ORDERS_SINGLE;

    $order = $this->adminOrderService->getOrderById((int) $routeData->uriGetParam);


    $actions = $this->adminOrderService->getActions();
    $statusData = $this->adminOrderService->getStatusData();

    $orderViewModel = [
      'order' => $order,
      'actions'=> $actions,
      'statusData' => $statusData
    ];
        
    $this->renderLayout('orders/single',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
        'order' => $order,
      'actions'=> $actions,
      'statusData' => $statusData
    ]);

  }

  private function renderDelete(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = self::PAGE_ORDERS_DELETE;

    $pageClass = 'admin-page';

    // Задаем название страницы и класс
    if( isset($_POST['submit'])) {
      // Проверка токена
      if (!check_csrf($_POST['csrf'] ?? '')) {
        $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
      }

      // Проверка на заполненность названия
      if( trim($_POST['title']) == '' ) {
        $_SESSION['errors'][] = ['title' => 'Введите название бренда'];
      } 

      // Если нет ошибок
      if ( empty($_SESSION['errors'])) {
        $brand = $this->brandRepository->getBrandById((int) $routeData->uriGetParam);
        // $brand->title = $_POST['title'];

        // R::store($brand);

        $_SESSION['success'][] = ['title' => 'Бренд успешно обновлен.'];
      }
    }

    $currentLang = LanguageConfig::getCurrentLocale();

    // Запрос постов в БД с сортировкой id по убыванию
    $brand = $this->brandRepository->getBrandById( (int) $routeData->uriGetParam);


        
    $this->renderLayout('orders/delete',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'brand' => $brand,
      'languages' => $this->languages,
      'currentLang' => $currentLang
    ]);

  }

}