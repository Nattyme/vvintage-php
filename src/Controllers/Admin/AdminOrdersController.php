<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin;

use Vvintage\Routing\RouteData;

/** Контроллеры */
use Vvintage\Controllers\Admin\BaseAdminController;

/** Репозитории */
use Vvintage\Repositories\Order\OrderRepository;


/** Сервисы */
// use Vvintage\Services\Admin\AdminStatsService;

class AdminOrdersController extends BaseAdminController 
{   
  private const TABLE_ORDERS = 'orders';
  private const PAGE_ORDERS_ALL = 'Все заказы';
  private const PAGE_ORDERS_SINGLE = 'Заказ №';
  private const PAGE_ORDERS_DELETE = 'Удаление заказа №';

  private OrderRepository $orderRepository;



  public function __construct()
  {
    parent::__construct();
    $this->orderRepository = new OrderRepository();
  }

  public function all(RouteData $routeData)
  {
    $this->isAdmin();
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

    $orders = $this->orderRepository->getAllOrders($pagination);
    $total = $this->orderRepository->getAllOrdersCount();
        
    $this->renderLayout('orders/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'orders' => $orders,
      'total' => $total,
      'searchQuery' => $searchQuery,
      'pagination' => $pagination
    ]);

  }

  private function renderSingle(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = self::PAGE_ORDERS_SINGLE;

    // Устанавливаем пагинацию
 

    // $total = $this->brandRepository->getAllBrandsCount();
        
    $this->renderLayout('orders/single',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData
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